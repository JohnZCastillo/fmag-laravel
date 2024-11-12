@extends('layouts.admin-index')

@section('files')
    <script src="/js/pristine.min.js"></script>
@endsection

@section('style')
    <style>
        .products {
            color: var(--primary) !important;
            background: #FFFFFF !important;
            border-color: var(--primary) !important;
        }
    </style>
@endsection


@section('body')
    <h4>Edit Product Details</h4>
    <div>

        <div class="modal-body">
            <div class="row">
                <div class="order-2 order-md-1 col-sm-12  col-md-5">

                    <form id="productForm" action="/admin/product/{{$product->id}}" method="POST"
                          enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name"
                                   value="{{$product->name}}"
                                   data-pristine-required-message="Name is required"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea rows="4" class="form-control" id="description" name="description"
                                      placeholder="Enter description"
                                      data-pristine-required-message="Description is required"
                                      required>{{$product->description}}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price" placeholder="Enter price"
                                   value="{{$product->price}}" required min="0"
                                   data-pristine-min-message="Price must be greater than or equal to 0">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" placeholder="Enter stock"
                                   value="{{$product->stock}}" min="0"
                                   data-pristine-min-message="Stock must be greater than or equal to 0" required>
                        </div>
                        <div class="form-group">
                            <label for="refundable">Refund</label>
                            <select id="refundable" class="form-select" name="refundable" required>
                                <option value="1" @selected($product->refundable)>Refundable</option>
                                <option value="0" @selected(!$product->refundable)>Non Refundable</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-select text-uppercase">
                                @foreach($categories as $category)
                                    <option class="text-uppercase"
                                            @selected($category->id == $product->category_id) value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="ps-0 mt-2 justify-content-start">
                            <a href="/admin/products" class="btn btn-secondary" data-bs-dismiss="modal">Back</a>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
                <div class="order-1 order-md-2 col-sm-12 col-md-7">
                    <div class="form-group mb-1" style="max-width: 600px">

                        <p class="mb-0">Image Preview</p>

                        <div class="d-flex align-items-center justify-content-start mb-2">
                            @foreach($product->images as $image)
                                <div class="p-2 overflow-auto" style="width: 200px; height: 150px">
                                    <div class="h-100 card rounded shadow overflow-hidden">
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($image->path)}}"
                                             class="w-100 h-100">
                                        <div class="card-img-overlay d-flex flex-column align-items-end gap-1">

                                            <form method="POST" action="/admin/product-image/{{$image->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm shadow-none">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                            <button data-bs-toggle="modal" data-bs-target="#editImage{{$image->id}}"
                                                    type="button"
                                                    class="btn btn-secondary btn-sm shadow-none">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <x-edit-product-image :image="$image"/>
                            @endforeach
                        </div>

                        <form method="POST" action="/admin/product-image/{{$product->id}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-2">
                                <label>Add Image</label>
                                <input accept="image/*" name="image" type="file" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Upload</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
@section('script')

    <script>

        const changePic = (target) => {
            console.log(target);
            document.getElementById('previewImage').src = URL.createObjectURL(target.files[0]);
        }

        window.onload = function () {

            const form = document.getElementById("productForm");

            const pristine = new Pristine(form);

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                if (pristine.validate()) {
                    form.submit();
                }

            });
        };

    </script>
@endsection
