@extends('layouts.admin-index')

@section('files')
    <script src="/js/pristine.min.js"></script>
    <script src="/js/InputOnChangeSubmit.js"></script>
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

    <h4>Product List</h4>
    <div class="admin-content">

        <div class="d-flex align-items-center pb-2 gap-2">

            <button data-bs-toggle="modal" data-bs-target="#addProduct" type="button" class="btn btn-primary">Add
            </button>

            <form class="flex-fill d-flex gap-2 form autoSubmitForm" id="searchForm" style="max-width: 400px">

                <div class="bg-dark p-2 gap-1 rounded-2">
                    <input value="{{$app->request->search}}"
                           name="search"
                           class="form-control text-white bg-transparent border-0 autoSubmitInput"
                           id="searchBox"
                           type="search"
                           style="box-shadow: none"
                           placeholder="Search Product"
                    >
                </div>

                <div class="col-5 form-group d-flex gap-2 align-items-center">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-select">
                        <option value="active" @selected($app->request->status == 'active')>Active</option>
                        <option value="inactive" @selected($app->request->status == 'inactive')>Inactive</option>
                    </select>
                </div>
            </form>


        </div>

        <section class="d-block d-md-none">
            @forelse($products as $product)
                <div class="card mb-2 text-dark">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: {{\App\Helper\CurrencyHelper::currency($product->price)}}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <p class="card-text">Category: {{ $product->category->name }}</p>
                        <div class="d-flex gap-2 align-items-center">
                            <a class="btn btn-primary" href="/admin/product/{{ $product->id }}">EDIT</a>
                            <form class="confirmation"
                                  data-message="Are you sure you want to archive {{$product->name}} ?"
                                  method="POST" action="/admin/product/{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-secondary">Archive</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="d-flex align-items-center justify-content-center" style="height: 300px">
                    <h3 class="text-center text-secondary">Empty Result</h3>
                </div>
            @endforelse
        </section>

        <div class="d-none d-md-block">
            <table class="table table-bordered table-light">
                <thead class="table-dark">
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{\App\Helper\CurrencyHelper::currency($product->price)}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <a class="btn btn-primary" href="/admin/product/{{$product->id}}">EDIT</a>
                                @if($product->archived)
                                    <form method="POST" action="/admin/unarchived-product/{{ $product->id }}">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary">Unarchived</button>
                                    </form>
                                @else
                                    <form class="confirmation"
                                          data-message="Are you sure you want to archive {{$product->name}} ?"
                                          method="POST"
                                          action="/admin/product/{{ $product->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-secondary">Archive</button>
                                    </form>

                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="text-center" colspan="5" style="height: 300px; vertical-align: middle">Empty Result
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="container-fluid">
            {{$products->links()}}
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="productForm" action="/admin/product" method="POST" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">New Product</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="editImage">Image URL</label>
                            <input type="file" class="form-control" id="editImage"
                                   name="image" accept="image/png, image/jpg, image/jpeg"
                                   placeholder="Upload Image">
                        </div>
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                   placeholder="Enter name"
                                   data-pristine-required-message="Name is required"
                                   required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea rows="4" class="form-control" id="description" name="description"
                                      placeholder="Enter description"
                                      data-pristine-required-message="Description is required"
                                      required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="number" class="form-control" id="price" name="price"
                                   placeholder="Enter price"
                                   value="" required min="0" step="0.1"
                                   data-pristine-min-message="Price must be greater than or equal to 0">
                        </div>
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock"
                                   placeholder="Enter stock"
                                   value="" min="0" step="0.1"
                                   data-pristine-min-message="Stock must be greater than or equal to 0"
                                   required>
                        </div>
                        <div class="form-group">
                            <label for="category">Category</label>
                            <select name="category_id" id="category" class="form-select text-uppercase">
                                @foreach($categories as $category)
                                    <option class="text-uppercase" value="{{$category->id}}">
                                        {{$category->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start">
                        <a href="/admin/products" class="btn btn-secondary" data-bs-dismiss="modal">Back</a>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        window.onload = function () {

            const form = document.getElementById("productForm");

            // create the pristine instance
            const pristine = new Pristine(form);

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (pristine.validate()) {
                    form.submit();
                }

            });

            handleInputsChange('#searchForm', 'change', '#status');
            handleInputChange('#searchForm', 'input', '#searchBox', (search) => !search.length);
        };


    </script>
@endsection

