<html>
    <head>
        <title>YEEKIA | Home</title>
        <link rel="icon" href="{{ asset('img/small_logo.png') }}">
        <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
        <link rel="stylesheet" href="{{ asset('css/footer.css') }}">
        <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
        <script src="{{ asset('js/dropdown.js') }}" defer></script>
        <script src="{{ asset('js/search.js') }}" defer></script>
        <script src="{{ asset('js/profile.js') }}" defer></script>
        <script src="{{ asset('js/product.js') }}" defer></script>


    <!-- header -->
    <section class="header">
        <nav>
            <a href="{{ route('home') }}"><img src="{{ asset('img/small_logo.png') }}"></a>
            <div class="nav-links" id="navLinks">
                <i class="fa fa-window-close-o" onclick="hideMenu()"></i>
                <ul>
                    <li><a href="{{ route('home') }}">HOME</a></li>

                    <li><div class="dropdown" data-dropdown>
                        <a href="{{ route('product_items.index') }}">PRODUCT</a>
                            <!-- <button class="link" data-dropdown-button>Product</button>
                            <div class="dropdown-menu information-grid">

                                <div class="dropdown-heading-main">
                                    <a href="Getproduct_filter"><strong>All Product</strong></a>
                                </div>


                                <div>
                                    <div class="dropdown-heading">Bed room</div>
                                    <div class="dropdown-link">
                                        <a href="category/bedpage.html" class="link-text">Bed</a>
                                        <a href="category/tablepage.html" class="link-text">Table</a>
                                    </div>
                                </div>

                                <div>
                                    <div class="dropdown-heading">Home office</div>
                                    <div class="dropdown-link">
                                        <a href="category/tablepage.html" class="link-text">Table</a>
                                        <a href="#" class="link-text">Chair</a>
                                    </div>
                                </div>

                                <div>
                                    <div class="dropdown-heading">Both room</div>
                                    <div class="dropdown-link">
                                        <a href="#" class="link-text">Mirror</a>
                                    </div>
                                </div>

                            </div>
                        </div> -->
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
                                    <li><i class="fas fa-sign-out-alt"><a href="{{ route('login') }}">Login</a></i></li> 
                                    <li><i class="fas fa-sign-out-alt"><a href="{{ route('logout') }}">Logout</a></i></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </section>
    <!-- EndHeader -->

</head>
</html>

