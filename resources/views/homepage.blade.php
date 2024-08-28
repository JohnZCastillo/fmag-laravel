@extends('layouts.user-index')

@section('title','Homepage')

@section('files')
    <link href="/css/owlcarousel/assets/owl.carousel.css" rel="stylesheet">
    <link href="/css/owlcarousel/assets/owl.theme.default.css" rel="stylesheet">
@endsection

@section('body')

    <section class="hero-section stack-bg bg-white pb-2">
        <section class="container mx-auto row align-items-center" style="min-height: 400px">
            <div class="order-2 order-md-1 col-sm col-md-5">
                <div>
                    <h1>Where Care Meets Preparedness</h1>
                    <a href="/shop" class="rounded-pill btn btn-primary">Shop Now!</a>
                </div>
            </div>
            <div class="order-1 order-md-2 col-sm col-md-7 d-flex align-items-center justify-content-center">
                <img class="hero-img img-fluid" src="/assets/hero-bg.png">
            </div>
        </section>
    </section>

    <div class="product-section bg-background ">
        <div class="container position-relative" style="min-height: 400px">
            <h2 class="mb-4 section-title">New Arrival</h2>
            <div class="row align-items-center mx-auto">

                @if(count($arrivals) > 3)
                    <div class="owl-carousel owl-theme">
                        @foreach($arrivals as $product)
                            <div class="item">
                                <a class="product-item" href="/product/{{$product->id}}">
                                    <img style="max-height: 240px" src="{{\Illuminate\Support\Facades\Storage::url($product->image)}}"
                                         class="img-fluid product-thumbnail">
                                    <h3 class="product-title text-capitalize">{{$product->name}}</h3>
                                    <strong class="product-price">{{$product->price}}</strong>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    @foreach($arrivals as $product)
                        <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">
                            <a class="product-item" href="/product/{{$product->id}}">
                                <img style="max-height: 240px" src="/uploads/{{$product->image}}"
                                     class="img-fluid product-thumbnail">
                                <h3 class="product-title text-capitalize">{{$product->name}}</h3>
                                <strong class="product-price">{{$product->price}}</strong>
                            </a>
                        </div>
                    @endforeach
                @endif

                {{--                {% if latestArrivals|length  > 3 %}--}}
                {{--                <div class="owl-carousel owl-theme">--}}
                {{--                    {% for product in latestArrivals %}--}}
                {{--                    <div class="item">--}}
                {{--                        <a class="product-item" href="/product/{{product.id}}">--}}
                {{--                            <img style="max-height: 240px" src="/uploads/{{product.image}}"--}}
                {{--                                 class="img-fluid product-thumbnail">--}}
                {{--                            <h3 class="product-title">{{product.name|title}}</h3>--}}
                {{--                            <strong class="product-price">{{product.price|format_currency('PHP')}}</strong>--}}
                {{--                        </a>--}}
                {{--                    </div>--}}
                {{--                    {% endfor %}--}}
                {{--                </div>--}}
                {{--                {% else %}--}}

                {{--                {% for product in latestArrivals %}--}}
                {{--                <div class="col-12 col-md-4 col-lg-3 mb-5 mb-md-0">--}}
                {{--                    <a class="product-item" href="/product/{{product.id}}">--}}
                {{--                        <img style="max-height: 240px" src="/uploads/{{product.image}}"--}}
                {{--                             class="img-fluid product-thumbnail">--}}
                {{--                        <h3 class="product-title">{{product.name|title}}</h3>--}}
                {{--                        <strong class="product-price">{{product.price|format_currency('PHP')}}</strong>--}}
                {{--                    </a>--}}
                {{--                </div>--}}
                {{--                {% endfor %}--}}
                {{--                {% endif %}--}}

            </div>
        </div>
    </div>


    <!-- carousel -->


    <div class="about-section py-2 py-md-5">
        <div class="container mx-auto row justify-content-between">
            <div class="col-lg-6">
                <h2 class="section-title ">About Us</h2>
                <p>Fmag Rescue Philippines, Inc. is registered as an Emergency Medical Rescue Training Center, Ambulance
                    Service, and nonprofit Organization dedicated to Disaster Risk Reduction Management. We train, we
                    serve,
                    we save lives, and we are ready to respond to any kind of emergency situation, calamity, or
                    disaster.
                    Our programs are tailored to each affiliate, ensuring that trainees acquire valuable skills to
                    provide
                    quality service</p>
                <div class="row my-5">
                    <div class="col-6 col-md-6">
                        <div class="feature">
                            <div class="icon">
                                <i class="bi bi-bullseye h3 mb-0"></i>
                            </div>
                            <h3>Mission</h3>
                            <p>We Build a world where every body are equipped with the ability and supply to respond to
                                medical emergencies</p>
                        </div>
                    </div>
                    <div class="col-6 col-md-6 ">
                        <div class="feature">
                            <div class="icon">
                                <i class="bi bi-eye h3 mb-0 "></i>
                            </div>
                            <h3>Vission</h3>
                            <p>We aim to be one of the best Training Services & Supplier In the Philippines</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 dot">
                <div class="img-wrap">
                    <img src="/assets/about-bg.png" alt="Image" class="img-fluid">
                </div>
            </div>
        </div>
    </div>

    <div class="about-section ">
        <div class="container mx-auto" style="min-height: 400px">
            <h2 class="section-title dot">Visit Us</h2>
            <div>
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2185.7086822835463!2d120.84959541011881!3d14.283992765937295!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33bd80623bdb7a5d%3A0xc184f1b11af451bd!2sParagon%20Village!5e0!3m2!1sen!2sph!4v1714298306041!5m2!1sen!2sph"
                    width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
@endsection


@section('javascript')
    <script>
        $(document).ready(function () {
            $(".owl-carousel").owlCarousel({
                autoplay: true,
                smartSpeed: 1000,
                items: 1,
                dots: true,
                loop: true,
                margin: 10,
                nav: true,
                navText: ["<i class=\"bi bi-caret-left-fill\"></i>", "<i class=\"bi bi-caret-right-fill\"></i>"],
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 3
                    },
                }
            });
        })
    </script>
@endsection
