@extends('layouts.admin-index')

@section('files')
    <script src="/js/pristine.min.js"></script>
@endsection

@section('body')
    <h4>Edit Product Details</h4>
    <div>
        <form id="productForm" action="/admin/product/{{$product->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PATCH')
            <div class="modal-body">
                <div class="row">
                    <div class="order-2 order-md-1 col-sm-12  col-md-5">
                        <div class="form-group">
                            <label for="editImage">Image URL</label>
                            <input onchange="changePic(this)" type="file" class="form-control" id="editImage"
                                   name="image" accept="image/*"
                                   placeholder="Upload Image">
                        </div>
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
                                   value="{{$product->price}}" required min="0" data-pristine-min-message="Price must be greater than or equal to 0">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="text" class="form-control" id="stock" name="stock" placeholder="Enter stock"
                                   value="{{$product->stock}}" min="0" data-pristine-min-message="Stock must be greater than or equal to 0"  required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-select text-uppercase">
                                @foreach($categories as $category)
                                    <option class="text-uppercase" @selected($category->id == $product->category_id) value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="order-1 order-md-2 col-sm-12 col-md-7">
                        <div class="form-group mb-1" style="max-width: 600px">
                            <p class="mb-0">Image Preview</p>
                            <img id="previewImage" class="img-fluid"
                                 src="{{\Illuminate\Support\Facades\Storage::url($product->image)}}"
                                 alt="product image">
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-start">
                <a href="/admin/products" class="btn btn-secondary" data-bs-dismiss="modal">Back</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
        </form>
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

            // create the pristine instance
            const pristine = new Pristine(form);

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if(pristine.validate()){
                    form.submit();
                }

            });
        };

    </script>
@endsection
