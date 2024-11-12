<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{


    public function addImage(Request $request, Product $product)
    {

        try {

            DB::beginTransaction();

            $validated = $request->validate([
                'image' => 'required|image'
            ]);

            if ($product->images->count() >= 3) {
                throw  new \Exception('Exceed Product Image limit');
            }

            $filename = $request->file('image')->store('public');

            if (!$filename) {
                throw new \Exception('Upload image failed');
            }

            ProductImages::create([
                'product_id' => $product->id,
                'path' => $filename,
            ]);

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function updateImage(Request $request, ProductImages $productImages)
    {

        try {

            $validated = $request->validate([
                'image' => 'required|image'
            ]);

            DB::beginTransaction();

            $filename = $request->file('image')->store('public');

            if (!$filename) {
                throw new \Exception('Upload image failed');
            }

            $productImages->path = $filename;

            $productImages->save();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while updating product image']);
        }
    }


    public function deleteImage(ProductImages $productImages)
    {

        try {

            DB::beginTransaction();

            $productImages->delete();

            DB::commit();

            return redirect()->back();

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['message' => 'Something went wrong while deleting product image']);
        }
    }
}
