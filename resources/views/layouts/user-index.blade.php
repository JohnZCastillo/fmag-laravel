<!doctype html>
<html lang="en">
<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title','FMAG')</title>

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/bootstrap-icons-1.11.3/fonts/bootstrap-icons.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>

        .nav-link{
            color: white !important;
        }
        .side-link{
            color: black !important;
        }
        .bg-pic {
            background-image: url("/assets/bg.png");
            background-position: center;
            background-repeat: no-repeat;
            background-size: auto;
        }

        .h-full{
            height: calc(100vh - 40px);
        }

        .h-half{
            height: calc(75vh - 40px);
        }

        .message:empty{
            display: none;
        }

        /**{*/
        /*    outline: 1px red solid;*/
        /*}*/

        .dot{
            position: relative;
        }

        .dot::after{
            content: "";
            position: absolute;
            width: 205px;
            height: 167px;
            background-image: url('/assets/dots.svg');
            background-size: contain;
            background-repeat: no-repeat;
            left: -50px;
            top: -30px;
            z-index: -9999999;
        }

        .bg-background{
            background-color: #eff2f1;
        }
        /*.section-page{*/
        /*    min-height: 400px;*/
        /*}*/

        .stack-bg{
            background-image: url('/assets/grid-pattern.svg');
            background-position: 0 0;
            background-size: auto;
        }

        .hero-img{
            width: 500px;
            height: auto;
        }


        .nav-opaque{
            background-color: #ff980f;
            box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;
        }

        .nav-transparent{
            background-color: transparent;
        }

        .nav-transparent .text-logo,
        .nav-transparent .nav-link {
            color: black !important;
        }

        .link-btn{
            border: none !important;
            outline: none !important;
            background-color: transparent !important;
        }

        .nav-active{
            border-bottom: 2px solid var(--primary);
        }

        .cursor-pointer{
            cursor: pointer !important;
        }

    </style>

    @yield('files')


    @yield('style')
</head>
<body>

<div>

    <!-- Spinner Start -->
    <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Navbar Side -->
    <div class="sidebar pe-0 d-md-none" style="height: 150vh; background-color: white;">
        <nav class="navbar bg-light navbar-light">
            <a href="/" class="navbar-brand mx-4 mb-3">
{{--                <img style="width: 35px; height: 35px" src="/uploads/{{settings.logo}}">--}}
            </a>
            <div class="navbar-nav w-100" style="height: calc(100vh - 100px) ">
                <div class="nav-item">
                    <a href="/home" class="nav-link side-link">Home</a>
                </div>
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle side-link" href="#" id="navbarDropdown"
                       data-bs-toggle="dropdown">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($services as $service)
                            <a class="bg-white dropdown-item text-dark" href="/services/{{$service->id}}">{{$service->acronym}}</a>
                        @endforeach
                    </div>
                </div>
                <div class="nav-item">
                    <a href="/shop" class="nav-link side-link">Shop</a>
                </div>

                <div class=" nav-item">
                    <a href="/cart" class="side-link nav-link">Cart</a>
                </div>

                <div class="nav-item">
                    <a href="/profile" class="side-link nav-link">Account</a>
                </div>
            </div>
        </nav>
    </div>

    <!-- Navbar Start -->
    <nav id="nav-header" class="nav-transparent justify-content-between navbar navbar-expand-md navbar-light sticky-top px-4">
        <a href="/home" class="nav-link">

            <div class="d-flex gap-1 align-items-center">
                 <img style="width: 35px; height: 35px" src="{{\Illuminate\Support\Facades\Storage::url($settings->logo)}}">
                <h2 class="mb-0 text-logo text-light">FMAG</h2>
            </div>

        </a>

        <a href="#" class="sidebar-toggler flex-shrink-0 d-md-none">
            <i class="bi bi-list"></i>
        </a>

        <div class="navbar-nav align-items-center ms-auto gap-2 d-none d-md-flex">
            <div class="nav-item">
                <a href="/home" class="nav-link">Home</a>
            </div>

            <div class="nav-item dropdown dropstart">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                   data-bs-toggle="dropdown">
                    Services
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    @foreach($services as $service)
                        <a class="dropdown-item" href="/services/{{$service->id}}">{{$service->acronym}} - {{$service->title}}</a>
                    @endforeach
                </div>
            </div>
            <div class="nav-item">
                <a href="/shop " class="nav-link">Shop</a>
            </div>

            <div class="nav-item">
                <a href="/cart" class="nav-link">Cart</a>
            </div>
            <div class="nav-item">
                <a href="/profile" class="nav-link">Account</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    @yield('body')

    <footer class="footer-section py-3 bg-dark">
        <div class="container relative">
            <div class="row mb-5">
                <div class="col-lg-4">
                    <div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">FMAG Philippines<span>.</span></a>
                    </div>
                    <p class="mb-4">copyright ©️2024 FMAG shop - All Right Reserved</p>
                </div>
                <div class="col-lg-8">
                    <div class="row links-wrap">
                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                <li><a class="text-secondary" href="/home">Home</a></li>
                                <li><a class="text-secondary" href="/shop">Shop</a></li>
                                <li><a class="text-secondary" href="/profile">Account</a></li>
                                <li><a class="text-secondary" href="/register">Register</a></li>
                                <li><a class="text-secondary" href="/login">Login</a></li>
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">
                                @foreach($services as $service)
                                    <a class="text-secondary" href="/services/{{$service->id}}">{{$service->acronym}}</a>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <ul class="list-unstyled">

                                @foreach($topProducts as $product)
                                    <li>
                                        <a class="text-secondary" href="/product/{{$product->id}}">{{$product->name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="col-6 col-sm-6 col-md-3">
                            <small>Contact Us</small>
                            <ul class="list-unstyled">
                                <li><a class="text-secondary" href="{{$settings->fb}}"><i class="bi bi-facebook"></i> Fb</a></li>
                                <li><a  class="text-secondary" href="mailto:{{$settings->email}}"><i class="bi bi-envelope-at-fill"></i> Email</a></li>
                                <li><a class="text-secondary" href="#"><i class="bi bi-telephone-fill"></i> {{$settings->mobile}}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</div>



<!-- JavaScript Libraries -->
<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/main.js"></script>
<script src="/lib/owlcarousel/owl.carousel.js"></script>
<script src="/js/just-validate.js"></script>

@include('partials.error');
@include('partials.success');

<script>

    function back() {
        history.back();
    }

    function backReload(){
        history.back();
        location.reload();
    }

    $(document).ready(function() {

        $(window).scroll(function() {

            const scroll = $(window).scrollTop();

            if (scroll > 50) {
                document.getElementById('nav-header').classList.add('nav-opaque');
                document.getElementById('nav-header').classList.remove('nav-transparent');
            } else {
                document.getElementById('nav-header').classList.remove('nav-opaque');
                document.getElementById('nav-header').classList.add('nav-transparent');
            }
        });
    });

</script>

@yield('script')
@yield('javascript')
</body>
</html>
