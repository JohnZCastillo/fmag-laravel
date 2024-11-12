@extends('layouts.user-index')

@section('title',$product->name)

@section('files')
    <script src="/js/quantity.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.min.js"
            integrity="sha512-EC3CQ+2OkM+ZKsM1dbFAB6OGEPKRxi6EDRnZW9ys8LghQRAq6cXPUgXCCujmDrXdodGXX9bqaaCRtwj4h4wgSQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.6/viewer.css"
          integrity="sha512-eG8C/4QWvW9MQKJNw2Xzr0KW7IcfBSxljko82RuSs613uOAg/jHEeuez4dfFgto1u6SRI/nXmTr9YPCjs1ozBg=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
@endsection

@section('style')
    <style>
        .rating {
            display: inline-block;
            position: relative;
            height: 50px;
            line-height: 50px;
            font-size: 50px;
        }

        .rating label {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            cursor: pointer;
        }

        .rating label:last-child {
            position: static;
        }

        .rating label:nth-child(1) {
            z-index: 5;
        }

        .rating label:nth-child(2) {
            z-index: 4;
        }

        .rating label:nth-child(3) {
            z-index: 3;
        }

        .rating label:nth-child(4) {
            z-index: 2;
        }

        .rating label:nth-child(5) {
            z-index: 1;
        }

        .rating label input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .rating label .icon {
            float: left;
            color: transparent;
        }

        .rating label:last-child .icon {
            color: grey;
        }

        .rating:not(:hover) label input:checked ~ .icon,
        .rating:hover label:hover input ~ .icon {
            color: yellow;
        }

        .rating label input:focus:not(:checked) ~ .icon:last-child {
            color: yellow;
            text-shadow: 0 0 5px #09f;
        }

    </style>
@endsection

@section('body')

    <section class="stack-bg text-dark">
        <div class="container mx-auto bg-light">
            <div class="mb-3">
                <div class="row g-0">
                    <div class="col-md-5 dot">
                        <div class="images">
                            <div style="height: 300px">
                                @if($product->image)

                                <img src="{{\Illuminate\Support\Facades\Storage::url($product->image->path)}}"
                                     class="w-100 h-100 rounded-start">
                                @else
                                    <img src="/assets/product.png"
                                         class="w-100 h-100 rounded-start">
                                @endif
                            </div>

                            <div class="d-flex gap-1 align-items-center py-2">
                                @foreach($product->images as $image)
                                    <div style="width: 100px; height: 100px">
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($image->path)}}"
                                             class="w-100 h-100 rounded-start">
                                        @else
                                            <img src="/assets/product.png"
                                                 class="w-100 h-100 rounded-start">
                                        @endif
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body">
                            <h5 class="card-title">{{$product->name}} <span class="text-secondary text-lowercase">({{$product->category->name}})</span>
                            </h5>
                            <p>{{\App\Helper\CurrencyHelper::currency($product->price)}}</p>
                            <p class="card-text">{{$product->description}}</p>

                            <div class="d-flex align-items-center mt-2 gap-1">
                                @for ($i = 0; $i < $product->rating; $i++)
                                    <h6 class="text-warning">★</h6>
                                @endfor
                            </div>

                            @if($product->stock)
                                <div class="d-flex gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#inputModal{{$product->id}}"
                                            type="button" class="btn btn-success">Buy
                                    </button>
                                    <button data-bs-toggle="modal" data-bs-target="#inputCartModal{{$product->id}}"
                                            type="button" class="btn btn-primary">Cart
                                    </button>
                                </div>
                            @else
                                <div class="d-flex gap-2">
                                    <button disabled type="button" class="btn btn-success">Buy</button>
                                    <button disabled class="rounded-pill btn btn-primary" href="#">
                                        Add to Cart
                                    </button>
                                </div>
                                <span class="mt-2 text-secondary">Out of Stock</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <h4>Reviews</h4>
            <section class="card mb-2">
                <ul class="list-group list-group-flush comments">
                    @foreach($product->feedbacks as $feedback)
                        <li class="list-group-item">

                            @for ($i = 1; $i <= $feedback->rating; $i++)
                                <span class="icon text-warning">★</span>
                            @endfor

                            <h6 class="text-muted mb-1"><small>{{$feedback->user->name}}</small></h6>
                            <p class="mb-0">{{$feedback->comment}}</p>

                            <div class="d-flex">
                                @foreach($feedback->attachments as $attachment)
                                    @if($attachment->type == 'image')
                                        <img src="{{\Illuminate\Support\Facades\Storage::url($attachment->file)}}"
                                             style="width: 320px; height: 240px" class="img-fluid">
                                    @else
                                        <video class="img-fluid" width="320" height="240" controls>
                                            <source
                                                src="{{\Illuminate\Support\Facades\Storage::url($attachment->file)}}">
                                            Your browser does not support the video tag.
                                        </video>
                                    @endif
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
            </section>

            <hr>

            <div class="mb-3">
                <div class="card-body">
                    <h5 class="card-title">Leave a review</h5>
                    <form enctype="multipart/form-data" method="POST"
                          action="/product/feedback/{{$product->id}}">
                        @csrf
                        <section class="rating">
                            <label>
                                <input type="radio" name="rating" value="1" required/>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="2" required/>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="3" required/>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="4" required/>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                            <label>
                                <input type="radio" name="rating" value="5" required/>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                                <span class="icon">★</span>
                            </label>
                        </section>
                        <div class="form-group mb-2">
                            <label for="message">Content</label>
                            <textarea minlength="10" maxlength="100" required name="content" id="message" rows="3"
                                      class="form-control"
                                      style="resize: none;"></textarea>
                            <small id="contentLength">0/100</small>
                        </div>

                        <div class="form-group mb-2">
                            <label for="message">Insert Media</label>
                            <input
                                multiple
                                class="form-control"
                                type="file"
                                name="files[]"
                                accept=".jpeg,.jpg,.png,.mp4"
                                id="attachment"
                            />
                        </div>

                        <button type="submit" class="rounded-pill btn btn-primary btn-block">submit</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <x-input-quantity :id="$product->id" :max="$product->stock" :stock="$product->stock"/>

    <!-- cart -->
    <x-input-cart :id="$product->id" :max="$product->stock" :stock="$product->stock"/>

@endsection

@section('script')
    <script>

        const contentLength = document.querySelector('#contentLength');
        const message = document.querySelector('#message');
        const attachment = document.querySelector('#attachment');

        console.log('yawa');

        message.addEventListener('input', () => {
            console.log('yawa');
            const length = message.value.length ?? 0;
            contentLength.innerText = `${length}/100`;
        })

        attachment.addEventListener('change', (e) => {

            if (attachment.files.length <= 5) {
                return
            }

            alert('You can only upload a maximum of 5 files.');
            attachment.value = null;
        })


        const images = document.querySelectorAll('.images');

        images.forEach(image => {
            const viewer = new Viewer(image);
        });


        // const addToCartUrl = "/cart/add";
        // const productCheckoutUrl = "/product-checkout";
        //
        // const modal = new bootstrap.Modal(document.getElementById('exampleModal'), {
        //     keyboard: false,
        // })
        //
        // const form = document.getElementById('addToCartForm');
        // const quantityInput = document.getElementById('quantityInput');
        // const remainingStockHolder = document.getElementById('remainingStockValue');
        // const productIdHolder = document.getElementById('productId');
        //
        // async function addToCart(productId) {
        //
        //     form.action = addToCartUrl;
        //
        //     const data = await fetch('/api/product/' + productId);
        //
        //     if (!data.ok) {
        //         return
        //     }
        //
        //     const result = await data.json();
        //
        //     remainingStockHolder.innerHTML = result.stock;
        //     productIdHolder.value = result.id;
        //     quantityInput.setAttribute('max', result.stock);
        //
        //     modal.show();
        //
        // }
        //
        // async function checkoutProduct(productId) {
        //
        //     form.action = productCheckoutUrl;
        //
        //     const data = await fetch('/api/product/' + productId);
        //
        //     if (!data.ok) {
        //         return
        //     }
        //
        //     const result = await data.json();
        //
        //     remainingStockHolder.innerHTML = result.stock;
        //     productIdHolder.value = result.id;
        //     quantityInput.setAttribute('max', result.stock);
        //
        //     modal.show();
        //
        // }
        //
        // function incrementQuantity() {
        //
        //     let quantity = parseInt(quantityInput.value);
        //
        //     if (quantity < quantityInput.getAttribute('max')) {
        //         quantityInput.value = quantity + 1;
        //     }
        // }
        //
        // function decrementQuantity() {
        //     if (quantityInput.value > 1) {
        //         quantityInput.value = parseInt(quantityInput.value) - 1;
        //     }
        // }
        //
        // quantityInput.addEventListener('input', (event) => {
        //
        //     let quantity = parseInt(quantityInput.value);
        //     let max = quantityInput.getAttribute('max');
        //
        //     if (quantity <= 0) {
        //         quantityInput.value = 1;
        //     }
        //
        //     if (quantity > max) {
        //         quantityInput.value = max;
        //     }
        //
        // })
    </script>
@endsection

