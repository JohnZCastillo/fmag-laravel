<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <title>@yield('title','Account')</title>

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/bootstrap-icons-1.11.3/fonts/bootstrap-icons.css">

    <meta name="csrf-token" content="{{ csrf_token() }}">


    @yield('files')

    <style>
        .message:empty {
            display: none;
        }

        .content .navbar .dropdown-toggle::after {
            font-family: 'bootstrap-icons', serif;
            content: "\F229";
        }

    </style>

    @yield('styles')
</head>

<body>
<div class="position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"></span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Sidebar Start -->
    <div class="shadow sidebar pe-4">
        <nav class="navbar bg-light navbar-light">
            <a href="/" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary">FMAG</h3>
            </a>
            <div class="navbar-nav w-100" style="height: calc(100vh - 100px)">
                <a href="/profile"
                   class="account nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-person-circle h4 mb-0"></i>Profile</a>
                <a href="/password"
                   class="password nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-shield h4 mb-0"></i>Password</a>
                <a href="/address"
                   class="address nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-signpost h4 mb-0"></i>Address</a>
                <a href="/orders"
                   class="orders nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-card-checklist h4 mb-0"></i>Orders</a>
                <a href="/messages"
                   class="messages nav-item nav-link d-flex align-items-center"><i
                        class="messages bi bi-envelope h4 mb-0"></i>Inbox</a>
                <a href="/notifications"
                   class="notifications nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-bell h4 mb-0"></i>Notifications
                    <span class="message ms-1 px-2 bg-danger rounded-circle text-light" id="notificationCounter">
                    </span>
                </a>

                <form class="d-block d-md-none" method="POST" action="/logout" style="padding-inline: 25px">
                    @csrf
                    <button type="submit" class="bg-transparent border-0 d-flex align-items-center gap-3">
                        <i class="bi bi-box-arrow-left"></i>
                        Log out
                    </button>
                </form>

                <a href="#" class="mt-auto nav-item nav-link sidebar-toggler flex-shrink-0 d-flex align-items-center">
                    <i class="bi bi-x-lg"></i>
                    Close Menu
                </a>
            </div>
        </nav>
    </div>
    <!-- Sidebar End -->

    <!-- Content Start -->
    <div class="content">
        <!-- Navbar Start -->
        <nav class="navbar navbar-expand navbar-light sticky-top px-4 py-0" style="background-color: #ff980f">
            <a href="/" class="navbar-brand d-flex d-lg-none me-4">
                <h3 class="text-primary">FMAG</h3>
            </a>
            <a href="#" class="sidebar-toggler flex-shrink-0">
                <i class="bi bi-list"></i>
            </a>

            <div class="navbar-nav align-items-center ms-auto">

                <div class="d-none d-lg-block nav-item">
                    <a href="/home"
                       class="text-light nav-link side-link">Home</a>
                </div>


                <div class="d-none d-lg-block nav-item dropdown">
                    <a class="text-light nav-link dropdown-toggle side-link" href="#" id="navbarDropdown"
                       data-bs-toggle="dropdown">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($services as $service)
                            <a class="text-light bg-white dropdown-item text-dark" href="/services/{{$service->id}}">{{$service->acronym}}</a>
                        @endforeach
                    </div>
                </div>

                <div class="d-none d-lg-block nav-item">
                    <a href="/shop"
                       class="text-light nav-link side-link">Shop</a>
                </div>

                <div class="d-none d-lg-block nav-item">
                    <a href="/cart"
                       class="text-light side-link nav-link">Cart</a>
                </div>

                <div class="d-block d-md-none nav-item">
                    <a href="/shop"
                       class="text-light nav-link side-link">Shop</a>
                </div>

                <div class="d-block d-md-none nav-item dropdown">
                    <a class="text-light nav-link dropdown-toggle side-link" href="#" id="navbarDropdown"
                       data-bs-toggle="dropdown">
                        Services
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @foreach($services as $service)
                            <a class="text-light bg-white dropdown-item text-dark"
                               href="/services/{{$service->id}}">{{$service->title}}</a>
                        @endforeach
                    </div>
                </div>

                <div class="d-block d-md-none nav-item">
                    <a href="/cart" class="text-light ms-4">
                        <i class="bi bi-cart"></i>
                    </a>
                </div>

                <div class="d-none d-md-block nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2" src="{{\Illuminate\Support\Facades\Storage::url(\Illuminate\Support\Facades\Auth::user()->profile)}}" alt=""
                             style="width: 40px; height: 40px;">
                        <span class="d-none d-lg-inline-flex"></span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end bg-primary border-0 rounded-0 rounded-bottom m-0">
                        <form method="POST" action="/logout">
                            @csrf
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <div class="container-fluid pt-4 px-4">
            @yield('body')
        </div>


    </div>
</div>

<script src="/js/jquery-3.4.1.min.js"></script>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/main.js"></script>

@include('partials.error');
@include('partials.success');


<script>
    function back() {
        history.back();
    }

    $(document).ready(function () {
        setInterval(() => {
            $.ajax({
                url: '/api/unread-notifications',
                success: function (response) {
                    if (response.count) {
                        $("#notificationCounter").html(response.count);
                    } else {
                        $("#notificationCounter").html('');
                    }
                }
            });
        }, 10000);
    });

</script>

@yield('script')
@yield('javascript')

</body>

</html>
