<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Luxe Store | Modern Multi-Category Shopping')</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Our custom stylesheet -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    @yield('head-extra')
</head>
{{--
    data-discount="0" was only used on cart.php in the old project
    (script.js reads it for the coupon discount). It's harmless on
    every other page, so it's kept here on <body> globally instead
    of adding a separate yield section just for one attribute.
--}}

<body data-discount="0">
    <div class="announcement-bar">
        Free worldwide shipping on orders over $80 &nbsp;•&nbsp; New season arrivals are here
    </div>

    <!-- ============ NAVBAR ============ -->
    <nav class="navbar navbar-expand-lg site-navbar sticky-top">
        <div class="container">
            <a class="navbar-brand navbar-logo-link" href="{{ url('/') }}" aria-label="Luxe Store home">
                <img src="{{ asset('pic/luxe-logo-light.png') }}" class="navbar-logo navbar-logo-light" alt="LUXE">
                <img src="{{ asset('pic/luxe-logo-dark.png') }}" class="navbar-logo navbar-logo-dark" alt="LUXE">
            </a>

            <!-- Mobile toggler opens Bootstrap Offcanvas -->
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenu">
                <i class="bi bi-list fs-2"></i>
            </button>

            {{-- Mobile/tablet inline search. Desktop header remains unchanged. --}}
            <form class="mobile-navbar-search" role="search" action="{{ url('/shop') }}" method="GET">
                <i class="bi bi-search mobile-navbar-search-icon"></i>
                <input type="text" name="q" placeholder="Search products..." autocomplete="off"
                    aria-label="Search products">
                <button type="submit" aria-label="Search"><i class="bi bi-search"></i></button>
            </form>
            {{-- Mobile/tablet cart --}}
            <a href="{{ url('/cart') }}" class="navbar-icon-btn mobile-cart-btn position-relative"
                data-bs-toggle="offcanvas" data-bs-target="#miniCartOffcanvas" aria-label="Open cart">

                <i class="bi bi-cart3"></i>

                <span class="cart-count">0</span>
            </a>
            {{-- Mobile/tablet theme toggle --}}
            <button class="theme-toggle-btn mobile-theme-toggle" type="button" title="Toggle dark mode"
                aria-label="Toggle dark mode">
                <i class="bi bi-moon-stars"></i>
            </button>

            <div class="collapse navbar-collapse d-none d-lg-flex justify-content-center">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ url('/') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('shop') ? 'active' : '' }}"
                            href="{{ url('/shop') }}">Shop</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Fashion</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Shoes</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Bags</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Watches</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Beauty</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Accessories</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Home Decor</a></li>
                            <li><a class="dropdown-item" href="{{ url('/shop') }}">Stationery</a></li>
                        </ul>
                    </li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ url('/about') }}">About</a></li>
                    <li class="nav-item"><a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                            href="{{ url('/contact') }}">Contact</a></li>
                </ul>
            </div>

            <div class="d-flex align-items-center">
                <button class="navbar-icon-btn" data-bs-toggle="offcanvas" data-bs-target="#searchOffcanvas"
                    aria-label="Open search"><i class="bi bi-search"></i></button>
                <a href="{{ url('/cart') }}" class="navbar-icon-btn position-relative" data-bs-toggle="offcanvas"
                    data-bs-target="#miniCartOffcanvas" aria-label="Open cart">
                    <i class="bi bi-cart3"></i>
                    <span class="cart-count">0</span>
                </a>

                {{-- Logged-in customers see "My Account" instead of "Login".
                     Hidden below md (like the guest "Login" link) so the full
                     "My Account ▾" button doesn't crowd/overflow the mobile
                     header - mobile users get the same links from the
                     offcanvas menu instead. --}}
                @if (session('customer_id'))
                    <div class="dropdown d-none d-md-block">
                        <button class="login-btn-nav dropdown-toggle" type="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            My Account
                        </button>

                        <ul class="dropdown-menu">

                            <li>
                                <a class="dropdown-item" href="{{ route('customer.dashboard') }}">
                                    My Dashboard
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('customer.orders') }}">
                                    My Orders
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('customer.wishlist') }}">
                                    Wishlist
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('customer.profile.edit') }}">
                                    My Profile
                                </a>
                            </li>

                            <li>
                                <a class="dropdown-item" href="{{ route('customer.forgot-password') }}">
                                    Forgot Password
                                </a>
                            </li>

                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            <li>
                                <form method="POST" action="{{ route('customer.logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        Logout
                                    </button>
                                </form>
                            </li>

                        </ul>
                    </div>
                @else
                    <a href="{{ route('customer.login') }}" class="login-btn-nav d-none d-md-inline-block">
                        Login
                    </a>
                @endif

                <button class="theme-toggle-btn" title="Toggle dark mode">
                    <i class="bi bi-moon-stars"></i>
                </button>

            </div>
        </div>
    </nav>

    <!-- ============ MOBILE OFFCANVAS MENU ============ -->
    <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">
        <div class="offcanvas-header">
            <h5 class="fw-bold">LUXE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <ul class="nav flex-column">
                <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/shop') }}">Categories</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/about') }}">About</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('/contact') }}">Contact</a></li>
                @if (session('customer_id'))
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.dashboard') }}">My
                            Dashboard</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.orders') }}">My Orders</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.wishlist') }}">Wishlist</a>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.profile.edit') }}">My
                            Profile</a>
                    </li>
                    <li class="nav-item">
                        <form method="POST" action="{{ route('customer.logout') }}">
                            @csrf
                            <button type="submit"
                                class="nav-link border-0 bg-transparent w-100 text-start">Logout</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('customer.login') }}">Login</a></li>
                @endif
            </ul>
        </div>
    </div>

    <!-- ============ SEARCH OFFCANVAS ============ -->
    <!-- Opens from the search icon in the navbar. On the shop page it
     filters the product grid live; on every other page submitting
     it redirects to /shop?q=... so results are ready there. -->
    <div class="offcanvas offcanvas-top search-offcanvas" tabindex="-1" id="searchOffcanvas"
        aria-labelledby="searchOffcanvasLabel">
        <div class="offcanvas-header">
            <h5 id="searchOffcanvasLabel" class="visually-hidden">Search</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <form id="siteSearchForm" class="site-search-form" role="search" action="{{ url('/shop') }}"
                method="GET">
                <i class="bi bi-search"></i>
                <input type="text" name="q" id="siteSearchInput"
                    placeholder="Search for products, categories..." autocomplete="off">
                <button type="submit" class="btn-primary-custom">Search</button>
            </form>
            <div class="search-suggest-tags">
                <span>Popular:</span>
                <a href="#">Linen Shirt</a>
                <a href="#">Leather Tote</a>
                <a href="#">Chronograph Watch</a>
                <a href="#">Sunglasses</a>
            </div>
        </div>
    </div>

    <!-- ============ MINI CART OFFCANVAS (SIDE BAR CART) ============ -->
    <!-- Slides in from the right when the cart icon in the navbar is
     clicked. script.js renders the line items, subtotal, shipping
     and total here straight from localStorage. -->
    <div class="offcanvas offcanvas-end side-offcanvas" tabindex="-1" id="miniCartOffcanvas"
        aria-labelledby="miniCartLabel">
        <div class="offcanvas-header">
            <h5 id="miniCartLabel">Your Cart</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">

            <!-- Line items get injected here (cartLineTemplate in script.js) -->
            <div class="cart-items-wrap d-none" id="miniCartItems"></div>

            <!-- Shown when the cart has nothing in it -->
            <div class="empty-cart-state" id="miniCartEmpty">
                <i class="bi bi-cart-x"></i>
                <p>Your cart is empty.</p>
                <a href="{{ url('/shop') }}" class="btn-primary-custom">Start Shopping</a>
            </div>

            <!-- Subtotal / shipping / total + view cart & checkout buttons -->
            <div class="cart-summary-block d-none" id="miniCartFooter">
                <div class="cart-summary-row">
                    <span>Subtotal</span>
                    <span id="miniCartSubtotal">$0.00</span>
                </div>
                <div class="cart-summary-row">
                    <span>Shipping</span>
                    <span id="miniCartShipping">Free</span>
                </div>
                <div class="cart-summary-row">
                    <span>Total</span>
                    <span id="miniCartTotal">$0.00</span>
                </div>
                <a href="{{ url('/cart') }}" class="btn-outline-custom">View Cart</a>
                <a href="{{ url('/cart') }}" class="btn-primary-custom">Checkout</a>
            </div>

        </div>
    </div>

    <!-- ====== PAGE CONTENT (different on every page) ====== -->
    @yield('content')

    <!-- ============ FOOTER ============ -->
    <footer class="site-footer" id="contact">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 footer-about">
                    <h6 class="fs-4">LUXE</h6>
                    <p>A modern multi-category store bringing you fashion, beauty, and home essentials crafted with
                        quality and care.</p>
                    <div class="footer-social">
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                        <a href="#"><i class="bi bi-pinterest"></i></a>
                    </div>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Quick Links</h6>
                    <ul>
                        <li><a href="{{ url('/') }}">Home</a></li>
                        <li><a href="{{ url('/shop') }}">Shop</a></li>
                        <li><a href="{{ url('/about') }}">About Us</a></li>
                        <li><a href="{{ url('/contact') }}">Contact</a></li>
                        <li><a href="#">Blog</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6>Categories</h6>
                    <ul>
                        <li><a href="{{ url('/shop') }}">Fashion</a></li>
                        <li><a href="{{ url('/shop') }}">Shoes</a></li>
                        <li><a href="{{ url('/shop') }}">Bags</a></li>
                        <li><a href="{{ url('/shop') }}">Beauty</a></li>
                        <li><a href="{{ url('/shop') }}">Home Decor</a></li>
                    </ul>
                </div>

                <div class="col-lg-4">
                    <h6>Contact Us</h6>
                    <ul class="footer-contact">
                        <li><i class="bi bi-geo-alt"></i> 221B Baker Street, London, UK</li>
                        <li><i class="bi bi-envelope"></i> support@luxestore.com</li>
                        <li><i class="bi bi-telephone"></i> +1 (555) 012-3456</li>
                    </ul>
                </div>
            </div>

            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} Luxe Store. All rights reserved.</span>
                <span>Crafted with care for everyday luxury.</span>
            </div>
        </div>
    </footer>

    <!-- ============ BACK TO TOP ============ -->
    <button class="back-to-top" id="backToTop"><i class="bi bi-arrow-up"></i></button>

    <!-- ============ TOAST ============ -->
    <div class="toast" id="toast">✓ Added to cart</div>
    <div id="toast-container"></div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Our custom script -->
    <script src="{{ asset('js/script.js') }}"></script>

    @yield('scripts')

</body>

</html>
