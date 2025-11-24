<html>
    <head>
        <title>LB | @yield('title')</title>

        <link href="https://fonts.googleapis.com/css2?family=Pathway+Extreme:wght@400;500&display=swap" rel="stylesheet">

        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <script src="{{ asset('js/dropdown.js') }}" defer></script>
        <script src="{{ asset('js/search.js') }}" defer></script>
        <script src="{{ asset('js/profile.js') }}" defer></script>
        <script src="{{ asset('js/product.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>

        
        <style>
            body {
                font-family: 'Pathway Extreme', sans-serif;
            }
            /* Color of the links BEFORE scroll */
            .navbar-scroll .nav-link,
            .navbar-scroll .navbar-toggler-icon,
            .navbar-scroll .navbar-brand {
            color: #fff;
            }

            /* Color of the links AFTER scroll */
            .navbar-scrolled .nav-link,
            .navbar-scrolled .navbar-toggler-icon,
            .navbar-scrolled .navbar-brand {
            color: #fff;
            }

            /* Color of the navbar AFTER scroll */
            .navbar-scroll,
            .navbar-scrolled {
            background-color: #cbbcb1;
            }

            .mask-custom {
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, .15);
            }

            .navbar-brand {
            font-size: 1.75rem;
            letter-spacing: 3px;
            }
        </style>
        @yield('header')
    </head>
    <body>
        <!-- Navbar -->
        <nav>
            <a href="{{ route('home') }}"><img src="{{ asset('img/small_logo.png') }}"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-window-close-o" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="{{ route('home') }}">HOME</a></li>

                    <li><div class="dropdown" data-dropdown>
                        <a href="{{ route('product_items.index') }}">PRODUCT</a>
                           
                    </li>
                    <li><a href="{{ route('about_us') }}">ABOUT US</a></li>
                    <li><a href="{{ route('contact') }}">CONTACT US</a></li>
                    <li>
                        <input type="search" id="search" class="form-control-nav form-control-dark" placeholder="Search..." aria-label="Search" autocomplete="off">
                        <div class="search-menu" id="search-menu">

                        </div>
                    </li>
                    <li><div class="cart-icon"><a href="{{ route('getWishList') }}"><i class="fas fa-solid fa-heart" style="font-size: 1.6em;"></i></a></div></li>
                    <li><div class="cart-icon"><a href="{{ route('order.getStatusOrder') }}"><i class="fas fa-solid fa-truck"></i></a></div></li>
                    <li><div class="cart-icon"><a href="{{ route('cart.index') }}"><i class="fas fa-shopping-cart fa-"></i></a></div></li>
                    <li><div class="cart-icon"><a href="{{ route('profile.home') }}"><i class="fas fa-solid fa-user"></i></a></div></li>
                    <li>
                        <div class="action">
                            <div class="profile" onclick="menuToggle();">
                                <img src="{{ url('img/user.png') }}">
                            </div>

                            <div class="menu">
                                <ul>
                                    {{-- <li><i class="fas fa-user-alt"><a href="ViewCustomerProfile">Profile</a></i></li>
                                    <li><i class="fas fa-sticky-note"><a href="GetCustomerOrders">Orders</a></i></li> --}}
                                    <li><i class="fas fa-sign-out-alt"><a href="{{ route('login') }}">Login</a></i></li> 
                                    <li><i class="fas fa-sign-out-alt"><a href="{{ route('logout') }}">Logout</a></i></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="container px-4 py-1  my-1">
            @yield('content')
        </div>
    </body>
</html>

