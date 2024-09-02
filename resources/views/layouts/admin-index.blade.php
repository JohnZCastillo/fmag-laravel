<!DOCTYPE html>
<html lang="en">

<head>
    <link href="img/favicon.ico" rel="icon">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">

    <link href="/css/all.min.css" rel="stylesheet">

    <link href="/css/bootstrap.min.css" rel="stylesheet">

    <link href="/fontawesome/css/all.css" rel="stylesheet">

    <link href="/css/style.css" rel="stylesheet">

    <link rel="stylesheet" href="/bootstrap-icons-1.11.3/fonts/bootstrap-icons.css">

    @yield('files')


    @yield('style')

</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->


    <!-- Sidebar Start -->
    <div class="sidebar pe-4" style="background-color: white;">
        <nav class="navbar bg-light navbar-light">
            <a href="/" class="navbar-brand mx-4 mb-3">
                <h3 class="text-primary">FMAG</h3>
            </a>
            <div class="navbar-nav w-100" style="height: calc(100vh - 100px) ">
                <a href="/admin/dashboard"
                   class="nav-item nav-link d-flex align-items-center "><i
                        class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                <a href="/admin/sales"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-graph-up-arrow"></i>Sales</a>
                <a href="/admin/products"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-basket"></i>Products</a>
                <a href="/admin/orders"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-box-seam-fill"></i>Orders</a>
                <a href="/admin/services"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-card-checklist"></i>Services</a>
                <a href="/admin/inquire"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-chat-square-dots"></i>Inquire</a>
                <a href="/admin/support"
                   class="nav-item nav-link d-flex align-items-center">
                    <i class="bi bi-headset"></i>User Support</a>
                <a href="" class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-bell"></i>Notification
                    <span class="message ms-1 px-2 bg-danger rounded-circle text-light" id="notificationCounter">
                    </span>
                </a>

                <a href="/admin/general-settings"
                   class="nav-item nav-link d-flex align-items-center"><i
                        class="bi bi-gear-fill"></i>Settings</a>


                <form class="d-block d-md-none" method="POST" action="/logout" style="padding-inline: 25px">
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
            <a href="#" class="sidebar-toggler flex-shrink-0 d-flex align-items-center">
                <i class="fa fa-bars"></i>
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
                        <a class="text-light bg-white dropdown-item text-dark"></a>
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


                <div class="d-none d-md-block nav-item dropdown align-items-center">

                    <a href="#" class="nav-link dropdown-toggle " data-bs-toggle="dropdown">
                        <img class="rounded-circle me-lg-2 bg-white"
                             src="/public/resources/default-profile.svg" alt=""
                             style="width: 40px; height: 40px;">
                    </a>

                    <div class="dropdown-menu dropdown-menu-end bg-primary border-0 rounded-0 rounded-bottom m-0">
                        <form method="POST" action="/logout">
                            <button type="submit" class="dropdown-item">Log Out</button>
                        </form>
                    </div>
                </div>

                <div class="d-block d-md-none nav-item">
                    <a href="/shop"
                       class="text-light nav-link side-link"></a>
                    <div class="d-block d-md-none nav-item dropdown">
                        <a class="text-light nav-link dropdown-toggle side-link" href="#" id="navbarDropdown"
                           data-bs-toggle="dropdown">
                            Services
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            {% for service in services %}
                            <a class="text-light bg-white dropdown-item text-dark"
                               href="/service/"></a>
                            {% endfor %}
                        </div>
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
<script src="/lib/chart/chart.min.js"></script>
<script src="/js/main.js"></script>

{{--{% include '/partials/error-modal.html' %}--}}
{{--{% include '/partials/success-modal.html' %}--}}
{{--{% include '/partials/confirmation-modal.html' %}--}}
{{--{% include '/partials/image-modal.html' %}--}}


@yield('javascript')
<script>

    window.addEventListener('load', (evt) => {

        const forms = document.querySelectorAll('.confirmation');
        const autoSubmitForms = document.querySelectorAll('.autoSubmitForm');

        const confirmationModal = new bootstrap.Modal(document.getElementById('confirmationModal'), {
            keyboard: false
        })

        const confirmationForm = document.getElementById('confirmationForm');

        const confirmationMessage = document.getElementById('confirmationMessage');

        let confirmed = null;

        forms.forEach(form => {
            form.addEventListener('submit', (event) => {

                event.preventDefault();

                confirmed = (event) => {
                    event.preventDefault();
                    confirmationForm.removeEventListener('submit', confirmed)
                    form.submit();
                };

                confirmationForm.addEventListener('submit', confirmed)

                confirmationMessage.innerText = form.dataset.message;
                confirmationModal.show();

            })
        })

        if (autoSubmitForms) {

            autoSubmitForms.forEach(form => {

                let input = form.querySelector('.autoSubmitInput');
                let selection = form.querySelector('.autoSubmitSelect');

                if (input) {
                    input.addEventListener('change', (event) => {
                        if (input.value.length <= 0) {
                            form.submit();
                        }
                    })
                }

                if (selection) {
                    selection.addEventListener('change', (event) => form.submit());
                }
            })
        }
    })

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

    function back() {
        history.back();
    }

</script>

</body>

</html>
