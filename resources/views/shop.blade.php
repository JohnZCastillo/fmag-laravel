@extends('layouts.user-index')

@section('title','Shop')

@section('files')
    <script src="/js/quantity.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js" integrity="sha512-EC3CQ+2OkM+ZKsM1dbFAB6OGEPKRxi6EDRnZW9ys8LghQRAq6cXPUgXCCujmDrXdodGXX9bqaaCRtwj4h4wgSQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.css" integrity="sha512-eG8C/4QWvW9MQKJNw2Xzr0KW7IcfBSxljko82RuSs613uOAg/jHEeuez4dfFgto1u6SRI/nXmTr9YPCjs1ozBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('style')
    <style>
        .wrapper {
            position: relative;
            overflow: hidden;

            .inside {
                z-index: 9;
                background: #f2431c;
                width: 140px;
                height: 140px;
                position: absolute;
                top: -80px;
                right: -80px;
                border-radius: 0px 0px 200px 200px;
                transition: all 0.5s, border-radius 2s, top 1s;
                overflow: hidden;

                .icon {
                    position: absolute;
                    right: 60%;
                    top: 60%;
                    color: white;
                    opacity: 1;
                }

                &:hover {
                    width: 100%;
                    right: 0;
                    top: 0;
                    border-radius: 0;
                    height: 100%;

                    .icon {
                        opacity: 0;
                        right: 15px;
                        top: 15px;
                    }

                    .contents {
                        opacity: 1;
                        transform: scale(1);
                        transform: translateY(0);
                    }
                }

                .contents {
                    padding: 5%;
                    opacity: 0;
                    transform: scale(0.5);
                    transform: translateY(-200%);
                    transition: opacity 0.2s, transform 0.8s;

                    table {
                        text-align: center;
                        width: 100%;
                        color: white;
                        font-size: 16px;
                    }

                }
            }
        }

        /* Custom CSS for styling container, cards, and buttons */
        #category-container .container-fluid {
            padding-top: 20px; /* Adjust the padding as needed */
            padding-bottom: 20px; /* Adjust the padding as needed */
        }

        #category-container .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2); /* Add shadow effect */
            transition: 0.3s; /* Add transition effect on hover */
            margin-bottom: 20px; /* Adjust the margin as needed */
            border-radius: 10px; /* Add border-radius for rounded corners */
            overflow: hidden; /* Ensure contents stay within the card */

        }

        #category-container .card:hover {
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2); /* Increase shadow on hover */
        }

        #category-container .card-img-top {
            width: 100%; /* Ensure the image fills the card width */
            height: 200px; /* Adjust the height of the image as needed */
            object-fit: cover; /* Ensure the image covers the entire space */
            border-top-left-radius: 10px; /* Adjust for rounded corners */
            border-top-right-radius: 10px; /* Adjust for rounded corners */
        }

        #category-container .card-body {
            height: 200px; /* Set the height of the card body */
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            margin-bottom: 20px; /* Add margin to the bottom */
            color: black;
        }

        #category-container .btn {
            width: 100%; /* Make buttons fill the width of the card */
        }

        #category-container .card-title {
            width: 100%; /* Set a fixed width for the container */
            font-size: medium;
            white-space: nowrap;
        }

        .product-image{
            width: 300px !important;
            height: 300px !important;
            object-position: center;
            object-fit: cover;
        }

        .pointer{
            cursor: pointer;
        }

    </style>
@endsection
@section('body')

    @if($errors->any())
        <h4>{{$errors->first()}}</h4>
    @endif

    <section class="stack-bg">
        <div class="container">
            @foreach($categories as $category)
                @if(count($category->products))
                    <section class="products">
                        <h3 class="text-capitalize">{{$category->name}}</h3>
                        <div class="row align-items-stretch">
                            @foreach($category->products as $product)
                                <div class="col-sm-6 col-md-4 col-lg-3 py-2" id="2">
                                    <div class="card mb-4 pb-2 h-100 text-dark" data-stock="0">
                                        <div class="wrapper">
                                            <div class="images pointer">
                                                <img src="{{\Illuminate\Support\Facades\Storage::url($product->image)}}" class="card-img-top product-image">
                                            </div>
                                            <div class="inside">
                                                <div class="icon">Info</div>
                                                <div class="contents">
                                                    <table>
                                                        <tbody>
                                                        <tr>
                                                            <th>Description
                                                                <hr class="m-0" style="color: black;">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                {{$product->description}}
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body" style="height: 150px;">
                                            <a href="/product/{{$product->id}}">
                                                <h5 class="card-title text-truncate" style="max-width: 20ch">{{$product->name}}</h5>
                                                <span class="small text-dark">Remaining Stock: {{$product->stock}}</span>
                                            </a>
                                            <p class="card-text">{{\App\Helper\CurrencyHelper::currency($product->price) }}</p>

                                            @if($product->stock > 0)
                                                <div class="d-flex gap-2">
                                                    <button data-bs-toggle="modal" data-bs-target="#inputModal{{$product->id}}" type="button" class="btn btn-success">Buy</button>
                                                    <button data-bs-toggle="modal" data-bs-target="#inputCartModal{{$product->id}}" type="button" class="btn btn-primary">Cart</button>
                                                </div>
                                            @else
                                                <div class="d-flex gap-2">
                                                    <button disabled type="button" class="btn btn-success">Buy</button>
                                                    <button disabled type="button" class="btn btn-primary">Cart</button>
                                                </div>
                                                <span class="small text-dark">Product out of stock</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal -->
                                <x-input-quantity :id="$product->id" :max="$product->stock" :stock="$product->stock" />

                                <!-- cart -->
                                <x-input-cart :id="$product->id" :max="$product->stock" :stock="$product->stock" />

                            @endforeach
                        </div>
                        <hr class="m-0">
                    </section>
                @endif
            @endforeach
        </div>
    </section>

@endsection

@section('script')

    <script>

        const images = document.querySelectorAll('.images');

        images.forEach(image =>{
            const viewer = new Viewer(image);
        });

    </script>
@endsection
