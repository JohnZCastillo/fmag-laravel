<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index(Request $request)
    {

        $query = Product::query();

        $query->with(['category' => function ($query) {
            $query->select(['id', 'name']);
        }]);

        $query->when($request->input('search'), function ($qb) use ($request) {
            $qb->where(function ($qb) use ($request) {
                $qb->whereLike('name', '%' . $request->input('search') . '%');
                $qb->orWhereLike('price', '%' . $request->input('search') . '%');
                $qb->orWhereLike('stock', '%' . $request->input('search') . '%');
                $qb->orWhereLike('description', '%' . $request->input('search') . '%');

                $qb->orWhereHas('category', function ($qb) use ($request) {
                    $qb->whereLike('name', '%' . $request->input('search') . '%');
                });
            });
        });

        $query->when($request->input('status'), function ($query) use ($request) {
            $query->where('archived', $request->input('status') == 'inactive');
        }, function ($query) use ($request) {
            $query->where('archived', false);
        });

        $products = $query->paginate(8)->appends($request->except('page'));

        $categories = ProductCategory::select(['name', 'id'])
            ->get();

        return view('admin.products', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function viewProduct($productID)
    {

        $product = Product::with(['category' => function ($query) {
            $query->select(['id', 'name']);
        }, 'feedbacks' => function ($qb) {
            $qb->with([
                'user', 'product', 'attachments'
            ]);
        }])->findOrFail($productID);

        return view('product', [
            'product' => $product
        ]);
    }

    public function getProduct($productID)
    {

        $categories = ProductCategory::select(['id', 'name'])->get();

        $product = Product::with(['category' => function ($query) {
            $query->select(['id', 'name']);
        }, 'feedbacks' => function ($qb) {
            $qb->with([
                'user', 'product', 'attachments'
            ]);

        }])->findOrFail($productID);

        return view('admin.product', [
            'product' => $product,
            'categories' => $categories,
        ]);
    }

    public function updateProduct(Request $request, Product $product)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'category_id' => 'required|numeric',
                'image' => 'nullable|image|mimes:jpg,jpeg,png',
                'refundable' => 'required|boolean',
            ]);

            $product->update($validated);

            if ($request->file('image') && $request->file('image')->isValid()) {

                if (Storage::exists($product->image)) {
                    Storage::delete($product->image);
                }

                $product->image = $request->file('image')->store('public');
            }

            $product->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            dd($request);
//            return redirect()->back()->withErrors(['message' => 'Product update failed!']);
        }
    }

    public function addProduct(Request $request)
    {

        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock' => 'required|numeric',
                'category_id' => 'required|numeric',
                'image' => 'required|mimes:jpg,jpeg,png|mimetypes:image/jpeg,image/png',
            ]);

            $product = new Product();

            $product->fill($validated);

            $filename = $request->file('image')->store('public');

            if (!$filename) {
                throw new \Exception('Unable to upload product image');
            }

            $product->image = $filename;

            $product->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Product add failed!']);
        }
    }

    public function archiveProduct($productID)
    {
        try {

            DB::beginTransaction();

            Product::where('id', $productID)->update([
                'archived' => true
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'message' => 'product deletion failed!'
            ]);
        }
    }

    public function unarchivedProduct($productID)
    {
        try {

            DB::beginTransaction();

            Product::where('id', $productID)->update([
                'archived' => false
            ]);

            DB::commit();
            return redirect()->back();
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect()->back()->withErrors([
                'message' => 'product unarchived failed!'
            ]);
        }
    }
}
