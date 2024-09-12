@extends('layouts.admin-index')


@section('body')

    <h4>Product List</h4>
    <div class="admin-content">

        <div class="d-flex align-items-center pb-2 gap-2">

            <a type="button" class="btn btn-primary" href="/admin/add-product">Add</a>

            <form class="form w-100 autoSubmitForm" id="searchForm" style="max-width: 400px">
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
            </form>
        </div>

        <section class="d-block d-md-none">
            @forelse($products as $product)
                <div class="card mb-2">
                    <div class="card-body">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text">Price: {{ $product->price }}</p>
                        <p class="card-text">Stock: {{ $product->stock }}</p>
                        <p class="card-text">Category: {{ $product->category->name }}</p>
                        <div class="d-flex gap-2 align-items-center">
                            <a class="btn btn-primary" href="/admin/product/{{ $product->id }}">EDIT</a>
                            <form class="confirmation"
                                  data-message="Are you sure you want to archive {{$product->name}} ?"
                                  method="POST" action="/admin/archive-product/{{ $product->id }}">
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
                        <td>{{$product->price}}</td>
                        <td>{{$product->stock}}</td>
                        <td>{{$product->category->name}}</td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <a class="btn btn-primary" href="/admin/product/{{$product->id}}">EDIT</a>

                                <form class="confirmation"
                                      data-message="Are you sure you want to archive {{$product->name}} ?" method="POST"
                                      action="/admin/product/{{ $product->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-secondary">Archive</button>
                                </form>
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
    </div>
@endsection

