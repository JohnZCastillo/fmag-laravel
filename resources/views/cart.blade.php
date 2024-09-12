@extends('layouts.user-index')

@section('title','Cart')


@section('style')
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .container-fluid {
            padding: 0;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            width: 95%; /* Adjust the width as needed */
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ccc;
            font-weight: bold;
            color: black;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
            color: black;
        }

        th {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .btn-primary {
            border-color: black;
            color: #fff;
        }

        .text-right {
            text-align: center;
        }

        #totalCart {
            font-weight: bold;
            color: black;
        }

        .form-control {
            width: 100%;
        }

        .product-img {
            width: 100px; /* Set the width of the image to 100px */
            height: 100px; /* Automatically adjust the height to maintain aspect ratio */
        }

        /*Mobile */
        @media (max-width: 991.98px) {
            .card {
                width: 100%;
                border-radius: 0; /* Remove border-radius for full-width appearance */
            }

            .table {
                font-size: 11px; /* Adjust font size for better readability on smaller screens */
            }

            .form-control {
                width: 60px; /* Let the input fields adjust their width based on content */
                font-size: 12px;
            }

            .btn {
                padding: 1px 8px;
                border-radius: 1px;
            }

            .btn-primary {
                border-color: black;
                color: #fff;
            }

            #pimg {
                display: none;
            }

            #phide {
                display: none;
            }
        }
    </style>
@endsection

@section('body')
    <div class="container-fluid h-50">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Shopping Cart</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($cart->items as $item)
                                    <tr id="product{{$item->product->id}}">
                                        <td>
                                            <img class="product-img"
                                                 src="{{\Illuminate\Support\Facades\Storage::url($item->product->image)}}">
                                        </td>
                                        <td>
                                            {{$item->product->name}}
                                            <p>Stock: {{$item->product->stock}}</p>
                                        </td>
                                        <td>{{$item->product->price}}</td>
                                        <td>
                                            <input id="quantity{{$item->product->id}}"
                                                   onchange="updateQuantity('{{$item->product->id}}'); limitQuantity('{{$item->product->id}}');"
                                                   type="number" min="1" max="{{$item->product->stock}}"
                                                   class="form-control"
                                                   name="quantity"
                                                   value="{{$item->quantity}}">
                                            <p id="stock{{$item->product->id}}" style="display: none;">
                                                {{$item->product->stock}}</p>
                                        </td>
                                        <td id="subTotal{{$item->product->id}}">{{$item->product->price * $item->quantity}}
                                        </td>
                                        <td>
                                            <form method="POST" action="/cart-item/{{$item->id}}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">X</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="7"
                                            style="height: 200px; vertical-align: middle"></td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="text-right">
                                @if(count($cart->items))
                                    <h3>Total: ₱<span id="totalCart">{{$total}}</span></h3>
                                    <form id="cartForm" method="POST" action="/order/cart-checkout">
                                        @csrf
                                        <button id="checkoutButton" type="submit" class="btn btn-primary">
                                            Checkout
                                        </button>
                                    </form>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($errors->any())
            <span class="text-danger">{{$errors->first()}}</span>
        @endif

    </div>
@endsection

@section('script')
    <script>
        {{--const cart = document.querySelector('#cartForm');--}}
        {{--const total = document.querySelector('#totalCart');--}}

        {{--async function updateQuantity(productId) {--}}

        {{--    const subTotal = document.querySelector("#subTotal" + productId);--}}
        {{--    let quantity = document.querySelector("#quantity" + productId);--}}

        {{--    const formData = new FormData();--}}
        {{--    formData.append("quantity", quantity.value);--}}

        {{--    const result = await fetch('{{base_path()}}/api/cart/update/' + productId, {--}}
        {{--        method: "POST",--}}
        {{--        body: formData,--}}
        {{--    })--}}

        {{--    const data = await result.json();--}}

        {{--    if (result.ok) {--}}
        {{--        total.innerHTML = data.total;--}}
        {{--        subTotal.innerHTML = data.subtotal;--}}
        {{--    } else {--}}
        {{--        quantity.value = data.stock;--}}
        {{--    }--}}

        {{--}--}}
    </script>
@endsection
