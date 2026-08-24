@extends('layouts.app')

@section('title', 'Luxe Store | Modern Multi-Category Shopping')

@section('content')

    <!-- ====== MAIN CONTENT WRAPPER ====== -->
    <main id="main-content">
        <!-- ============================== HERO SECTION (WORKING BUTTONS) ============================== -->
        <section class="hero-new" id="home">
            <div class="wrap hero-new-inner">

                <!-- LEFT: TEXT CONTENT -->
                <div class="hero-new-text reveal in">
                    <span class="hero-new-badge">
                        <span class="hero-new-dot"></span>
                        Premium Quality · Since 2019
                    </span>

                    <h1 class="hero-new-title serif">
                        <span class="hero-new-line">Your Daily</span>
                        <span class="hero-new-line accent">Luxury</span>
                        <span class="hero-new-line">Essentials</span>
                    </h1>

                    <p class="hero-new-desc">
                        Discover our curated collection of premium fashion, accessories,
                        beauty, and home decor. Quality craftsmanship designed for the
                        modern lifestyle.
                    </p>

                    <div class="hero-new-actions">
                        <!-- Shop Now Button -->
                        <a href="{{ url('/shop') }}" class="hero-new-btn-primary">
                            Shop Now
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>

                        <!-- View Categories Button -->
                        <a href="#categories" class="hero-new-link">
                            <span>View Categories</span>
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="hero-new-stats">
                        <div class="hero-new-stat">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Premium Products</span>
                        </div>
                        <div class="hero-new-stat">
                            <span class="stat-number">4.9★</span>
                            <span class="stat-label">Customer Rating</span>
                        </div>
                        <div class="hero-new-stat">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">Happy Customers</span>
                        </div>
                    </div>
                </div>

                <!-- RIGHT: IMAGE WITH BADGES -->
                <div class="hero-new-visual reveal in">
                    <div class="hero-new-image-wrap">
                        <img src="{{ asset('pic/main-2.jpg') }}" alt="Luxe Collection" class="hero-new-main-img">

                        <!-- Floating Badge 1: Top Left -->
                        <div class="hero-new-float hero-new-float-1">
                            <div class="float-icon">🛍️</div>
                            <div class="float-content">
                                <span class="float-title">Free Shipping</span>
                                <span class="float-sub">On orders over $80</span>
                            </div>
                        </div>

                        <!-- Floating Badge 2: Bottom Right -->
                        <div class="hero-new-float hero-new-float-2">
                            <div class="float-icon">✨</div>
                            <div class="float-content">
                                <span class="float-title">Premium Quality</span>
                                <span class="float-sub">100% authentic</span>
                            </div>
                        </div>

                        <!-- Floating Badge 3: Bottom Left -->
                        <div class="hero-new-float hero-new-float-3">
                            <div class="float-icon">↺</div>
                            <div class="float-content">
                                <span class="float-title">Easy Returns</span>
                                <span class="float-sub">30 day guarantee</span>
                            </div>
                        </div>

                        <!-- Organic Shape Background -->
                        <div class="hero-new-blob"></div>
                        <div class="hero-new-blob-2"></div>
                    </div>
                </div>

            </div>
        </section>
        <!-- ============ QUICK VIEW MODAL ============ -->
        <!-- Shared by every product card on the site. script.js fills in
                                                           the image/name/price etc. when a card's Quick View button
                                                           (bi-eye icon) is clicked. -->
        <div class="modal fade quick-view-modal" id="quickViewModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <button type="button" class="qv-close-btn" data-bs-dismiss="modal" aria-label="Close"><i
                            class="bi bi-x-lg"></i></button>
                    <div class="modal-body">
                        <div class="row g-0">
                            <div class="col-md-6 qv-img-side">
                                <img id="qvImage" src="" alt="">
                            </div>
                            <div class="col-md-6 qv-info-side">
                                <span id="qvBadge" class="qv-badge d-none"></span>
                                <span id="qvCategory" class="product-category d-block"></span>
                                <h3 id="qvName"></h3>
                                <div id="qvRating" class="product-rating mb-2"></div>
                                <div class="price">
                                    <span id="qvPrice"></span>
                                    <span id="qvOldPrice" class="old-price"></span>
                                </div>
                                <div class="product-actions mt-4">
                                    <a href="{{ url('/product-details') }}" id="qvViewDetails" class="btn-view">View Full
                                        Details</a>
                                    <button type="button" id="qvAddToCart" class="btn-quik">Add To Cart</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============ TRUST STRIP ============ -->
        <div class="trust-strip">
            <div class="container">
                <div class="row g-4">
                    <div class="col-6 col-md-3">
                        <div class="trust-item">
                            <i class="bi bi-truck"></i>
                            <div>
                                <span class="trust-title">Fast Delivery</span>
                                <span class="trust-sub">2-4 business days</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="trust-item">
                            <i class="bi bi-shield-check"></i>
                            <div>
                                <span class="trust-title">Secure Payment</span>
                                <span class="trust-sub">100% protected</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="trust-item">
                            <i class="bi bi-arrow-repeat"></i>
                            <div>
                                <span class="trust-title">Easy Returns</span>
                                <span class="trust-sub">30 day window</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="trust-item">
                            <i class="bi bi-headset"></i>
                            <div>
                                <span class="trust-title">24/7 Support</span>
                                <span class="trust-sub">We're here to help</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============ CATEGORIES SECTION (SINGLE ROW - 4 ITEMS) ============ -->
        <section class="section-padding categories-section-new" id="categories">
            <div class="container">

                <!-- Section Header -->
                <div class="categories-header">
                    <div class="categories-header-left">
                        <span class="eyebrow">Shop by Category</span>
                        <h2 class="categories-title">Explore Our <span class="text-accent">Collections</span></h2>
                    </div>
                    <a href="{{ url('/shop') }}" class="view-all-link">
                        View All Categories <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <!-- 4 Categories in Single Row -->
                <div class="categories-grid-single">

                    <!-- Category 1: Fashion -->
                    <a href="{{ url('/shop') }}" class="category-card-new">
                        <div class="category-image-wrap">
                            <img src="{{ asset('pic/p1.webp') }}" alt="Fashion" loading="lazy">
                            <div class="category-overlay-new">
                                <div class="category-icon">
                                    <i class="bi bi-handbag"></i>
                                </div>
                                <h3 class="category-name-new">Fashion</h3>
                                <span class="category-count-new">128 Products</span>
                                <span class="category-arrow-new">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Category 2: Accessories -->
                    <a href="{{ url('/shop') }}" class="category-card-new">
                        <div class="category-image-wrap">
                            <img src="{{ asset('pic/p10.webp') }}" alt="Accessories" loading="lazy">
                            <div class="category-overlay-new">
                                <div class="category-icon">
                                    <i class="bi bi-watch"></i>
                                </div>
                                <h3 class="category-name-new">Accessories</h3>
                                <span class="category-count-new">91 Products</span>
                                <span class="category-arrow-new">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Category 3: Beauty -->
                    <a href="{{ url('/shop') }}" class="category-card-new">
                        <div class="category-image-wrap">
                            <img src="{{ asset('pic/p4.webp') }}" alt="Beauty" loading="lazy">
                            <div class="category-overlay-new">
                                <div class="category-icon">
                                    <i class="bi bi-flower1"></i>
                                </div>
                                <h3 class="category-name-new">Beauty</h3>
                                <span class="category-count-new">63 Products</span>
                                <span class="category-arrow-new">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>

                    <!-- Category 4: Home Decor -->
                    <a href="{{ url('/shop') }}" class="category-card-new">
                        <div class="category-image-wrap">
                            <img src="{{ asset('pic/p3.webp') }}" alt="Home Decor" loading="lazy">
                            <div class="category-overlay-new">
                                <div class="category-icon">
                                    <i class="bi bi-house"></i>
                                </div>
                                <h3 class="category-name-new">Home Decor</h3>
                                <span class="category-count-new">48 Products</span>
                                <span class="category-arrow-new">
                                    <i class="bi bi-arrow-right"></i>
                                </span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>
        </section>
        <!-- ============ FEATURED PRODUCTS ============ -->
        <section class="section-padding bg-card" id="featured">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <span class="eyebrow d-block mb-2">Handpicked</span>
                        <h2 class="mb-0" style="font-size:30px; font-weight:700;">Featured Products</h2>
                    </div>
                    <a href="{{ url('/shop') }}" class="view-all-link">View All <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="row g-4">

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">New</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/scarf.webp') }}" alt="Silk Scarf">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Printed Silk Scarf'])) data-wishlist-id="{{ $wishlistMap['Printed Silk Scarf'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Printed Silk Scarf">
                                        <input type="hidden" name="product_image" value="scarf.webp">
                                        <input type="hidden" name="price" value="45.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Printed Silk Scarf']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Printed Silk Scarf']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Fashion</span>
                                <h3 class="product-name">Printed Silk Scarf</h3>
                                <div class="product-rating">★★★★★ <span>(124)</span></div>
                                <div class="product-price">$45.00</div>
                                <div class="product-actions">
                                  <a href="{{ route('customer.product-details', 1) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/bag.webp') }}" alt="Leather Tote">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Structured Leather Tote'])) data-wishlist-id="{{ $wishlistMap['Structured Leather Tote'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Structured Leather Tote">
                                        <input type="hidden" name="product_image" value="bag.webp">
                                        <input type="hidden" name="price" value="210.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Structured Leather Tote']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Structured Leather Tote']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Bags</span>
                                <h3 class="product-name">Structured Leather Tote</h3>
                                <div class="product-rating">★★★★★ <span>(89)</span></div>
                                <div class="product-price">$210.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 2) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge badge-sale">-20%</span>
                                <span class="stock-badge">Low Stock</span>
                                <img src="{{ asset('pic/p10.webp') }}" alt="Minimal Watch">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Minimal Steel Watch'])) data-wishlist-id="{{ $wishlistMap['Minimal Steel Watch'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Minimal Steel Watch">
                                        <input type="hidden" name="product_image" value="p10.webp">
                                        <input type="hidden" name="price" value="499.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Minimal Steel Watch']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Minimal Steel Watch']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Watches</span>
                                <h3 class="product-name">Minimal Steel Watch</h3>
                                <div class="product-rating">★★★★☆ <span>(212)</span></div>
                                <div class="product-price">$499.00 <span class="old-price">$624.00</span></div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 3) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p11.webp') }}" alt="Suede Loafers">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Suede Loafers'])) data-wishlist-id="{{ $wishlistMap['Suede Loafers'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Suede Loafers">
                                        <input type="hidden" name="product_image" value="p11.webp">
                                        <input type="hidden" name="price" value="168.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Suede Loafers']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Suede Loafers']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Shoes</span>
                                <h3 class="product-name">Suede Loafers</h3>
                                <div class="product-rating">★★★★★ <span>(58)</span></div>
                                <div class="product-price">$168.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 4) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ============ NEW ARRIVALS ============ -->
        <section class="section-padding" id="new-arrivals">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <span class="eyebrow d-block mb-2">Just In</span>
                        <h2 class="mb-0" style="font-size:30px; font-weight:700;">New Arrivals</h2>
                    </div>
                    <a href="{{ url('/shop') }}" class="view-all-link">View All <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="product-scroll-row">

                    <div class="product-card">
                        <div class="product-img-wrap">
                            <span class="product-badge">New</span>
                            <span class="stock-badge">In Stock</span>
                            <img src="{{ asset('pic/p1.webp') }}" alt="Wool Coat">
                            @if (session('customer_id'))
                                <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                    class="wishlist-form"
                                    @if(isset($wishlistMap['Tailored Wool Coat'])) data-wishlist-id="{{ $wishlistMap['Tailored Wool Coat'] }}" @endif>
                                    @csrf

                                    <input type="hidden" name="product_name" value="Tailored Wool Coat">
                                    <input type="hidden" name="product_image" value="p1.webp">
                                    <input type="hidden" name="price" value="498.00">

                                    <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Tailored Wool Coat']) ? 'is-wishlisted' : '' }}">
                                        <i class="bi {{ isset($wishlistMap['Tailored Wool Coat']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endif
                        </div>
                        <div class="product-info">
                            <span class="product-category">Fashion</span>
                            <h3 class="product-name">Tailored Wool Coat</h3>
                            <div class="product-rating">★★★★★ <span>(41)</span></div>
                            <div class="product-price">$498.00</div>
                            <div class="product-actions">
                                <a href="{{ route('customer.product-details', 5) }}" class="btn-view">View</a>
                                <button class="btn-cart">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-img-wrap">
                            <span class="product-badge">New</span>
                            <span class="stock-badge">In Stock</span>
                            <img src="{{ asset('pic/p2.webp') }}" alt="Gold Hoops">
                            @if (session('customer_id'))
                                <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                    class="wishlist-form"
                                    @if(isset($wishlistMap['Gold Hoop Earrings'])) data-wishlist-id="{{ $wishlistMap['Gold Hoop Earrings'] }}" @endif>
                                    @csrf

                                    <input type="hidden" name="product_name" value="Gold Hoop Earrings">
                                    <input type="hidden" name="product_image" value="p2.webp">
                                    <input type="hidden" name="price" value="642.00">

                                    <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Gold Hoop Earrings']) ? 'is-wishlisted' : '' }}">
                                        <i class="bi {{ isset($wishlistMap['Gold Hoop Earrings']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endif
                        </div>
                        <div class="product-info">
                            <span class="product-category">Accessories</span>
                            <h3 class="product-name">Gold Hoop Earrings</h3>
                            <div class="product-rating">★★★★★ <span>(97)</span></div>
                            <div class="product-price">$642.00</div>
                            <div class="product-actions">
                                <a href="{{ route('customer.product-details', 6) }}" class="btn-view">View</a>
                                <button class="btn-cart">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-img-wrap">
                            <span class="product-badge">New</span>
                            <span class="stock-badge">In Stock</span>
                            <img src="{{ asset('pic/p3.webp') }}" alt="Ceramic Vase">
                            @if (session('customer_id'))
                                <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                    class="wishlist-form"
                                    @if(isset($wishlistMap['Sculpted Ceramic Vase'])) data-wishlist-id="{{ $wishlistMap['Sculpted Ceramic Vase'] }}" @endif>
                                    @csrf

                                    <input type="hidden" name="product_name" value="Sculpted Ceramic Vase">
                                    <input type="hidden" name="product_image" value="p3.webp">
                                    <input type="hidden" name="price" value="74.00">

                                    <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Sculpted Ceramic Vase']) ? 'is-wishlisted' : '' }}">
                                        <i class="bi {{ isset($wishlistMap['Sculpted Ceramic Vase']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endif
                        </div>
                        <div class="product-info">
                            <span class="product-category">Home Decor</span>
                            <h3 class="product-name">Sculpted Ceramic Vase</h3>
                            <div class="product-rating">★★★★☆ <span>(33)</span></div>
                            <div class="product-price">$74.00</div>
                            <div class="product-actions">
                                <a href="{{ route('customer.product-details', 7) }}" class="btn-view">View</a>
                                <button class="btn-cart">Add</button>
                            </div>
                        </div>
                    </div>

                    <div class="product-card">
                        <div class="product-img-wrap">
                            <span class="product-badge">New</span>
                            <span class="stock-badge">In Stock</span>
                            <img src="{{ asset('pic/p4.webp') }}" alt="Face Serum">
                            @if (session('customer_id'))
                                <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                    class="wishlist-form"
                                    @if(isset($wishlistMap['Radiance Face Serum'])) data-wishlist-id="{{ $wishlistMap['Radiance Face Serum'] }}" @endif>
                                    @csrf

                                    <input type="hidden" name="product_name" value="Radiance Face Serum">
                                    <input type="hidden" name="product_image" value="p4.webp">
                                    <input type="hidden" name="price" value="38.00">

                                    <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Radiance Face Serum']) ? 'is-wishlisted' : '' }}">
                                        <i class="bi {{ isset($wishlistMap['Radiance Face Serum']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                    <i class="bi bi-heart"></i>
                                </a>
                            @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Beauty</span>
                                <h3 class="product-name">Radiance Face Serum</h3>
                                <div class="product-rating">★★★★★ <span>(156)</span></div>
                                <div class="product-price">$38.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 8) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>

                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">New</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p5.webp') }}" alt="Leather Journal">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Leather Bound Journal'])) data-wishlist-id="{{ $wishlistMap['Leather Bound Journal'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Leather Bound Journal">
                                        <input type="hidden" name="product_image" value="p5.webp">
                                        <input type="hidden" name="price" value="32.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Leather Bound Journal']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Leather Bound Journal']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Stationery</span>
                                <h3 class="product-name">Leather Bound Journal</h3>
                                <div class="product-rating">★★★★★ <span>(28)</span></div>
                                <div class="product-price">$32.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 9) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
        </section>
        <!-- ============ BEST SELLERS ============ -->
        <section class="section-padding bg-card" id="best-sellers">
            <div class="container">
                <div class="section-header-row">
                    <div>
                        <span class="eyebrow d-block mb-2">Loved By Many</span>
                        <h2 class="mb-0" style="font-size:30px; font-weight:700;">Best Sellers</h2>
                    </div>
                    <a href="{{ url('/shop') }}" class="view-all-link">View All <i class="bi bi-arrow-right"></i></a>
                </div>

                <div class="row g-4">

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">Bestseller</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p6.webp') }}" alt="Canvas Backpack">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Canvas Travel Backpack'])) data-wishlist-id="{{ $wishlistMap['Canvas Travel Backpack'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Canvas Travel Backpack">
                                        <input type="hidden" name="product_image" value="p6.webp">
                                        <input type="hidden" name="price" value="139.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Canvas Travel Backpack']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Canvas Travel Backpack']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Bags</span>
                                <h3 class="product-name">Canvas Travel Backpack</h3>
                                <div class="product-rating">★★★★★ <span>(301)</span></div>
                                <div class="product-price">$139.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 10) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">Bestseller</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p7.webp') }}" alt="Chelsea Boots">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Classic Chelsea Boots'])) data-wishlist-id="{{ $wishlistMap['Classic Chelsea Boots'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Classic Chelsea Boots">
                                        <input type="hidden" name="product_image" value="p7.webp">
                                        <input type="hidden" name="price" value="189.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Classic Chelsea Boots']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Classic Chelsea Boots']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Shoes</span>
                                <h3 class="product-name">Classic Chelsea Boots</h3>
                                <div class="product-rating">★★★★★ <span>(178)</span></div>
                                <div class="product-price">$189.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 11) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">Bestseller</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p8.webp') }}" alt="Signature Perfume">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Signature Eau de Parfum'])) data-wishlist-id="{{ $wishlistMap['Signature Eau de Parfum'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Signature Eau de Parfum">
                                        <input type="hidden" name="product_image" value="p8.webp">
                                        <input type="hidden" name="price" value="95.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Signature Eau de Parfum']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Signature Eau de Parfum']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Beauty</span>
                                <h3 class="product-name">Signature Eau de Parfum</h3>
                                <div class="product-rating">★★★★★ <span>(264)</span></div>
                                <div class="product-price">$95.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 12) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6 col-lg-3">
                        <div class="product-card">
                            <div class="product-img-wrap">
                                <span class="product-badge">Bestseller</span>
                                <span class="stock-badge">In Stock</span>
                                <img src="{{ asset('pic/p9.webp') }}" alt="Linen Cushion">
                                @if (session('customer_id'))
                                    <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                        class="wishlist-form"
                                        @if(isset($wishlistMap['Linen Throw Cushion'])) data-wishlist-id="{{ $wishlistMap['Linen Throw Cushion'] }}" @endif>
                                        @csrf

                                        <input type="hidden" name="product_name" value="Linen Throw Cushion">
                                        <input type="hidden" name="product_image" value="p9.webp">
                                        <input type="hidden" name="price" value="29.00">

                                        <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Linen Throw Cushion']) ? 'is-wishlisted' : '' }}">
                                            <i class="bi {{ isset($wishlistMap['Linen Throw Cushion']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                @endif
                            </div>
                            <div class="product-info">
                                <span class="product-category">Home Decor</span>
                                <h3 class="product-name">Linen Throw Cushion</h3>
                                <div class="product-rating">★★★★☆ <span>(112)</span></div>
                                <div class="product-price">$29.00</div>
                                <div class="product-actions">
                                    <a href="{{ route('customer.product-details', 13) }}" class="btn-view">View</a>
                                    <button class="btn-cart">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- ============ WHY CHOOSE US ============ -->
        <section class="section-padding">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Our Promise</span>
                    <h2>Why Shop With Us</h2>
                </div>

                <div class="row g-4">
                    <div class="col-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-truck"></i></div>
                            <h5>Fast Delivery</h5>
                            <p>Orders shipped within 24 hours, delivered in 2-4 days.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-shield-check"></i></div>
                            <h5>Secure Payment</h5>
                            <p>Every transaction is encrypted and fully protected.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-arrow-repeat"></i></div>
                            <h5>Easy Return</h5>
                            <p>Changed your mind? Return within 30 days, hassle-free.</p>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="feature-card">
                            <div class="feature-icon"><i class="bi bi-headset"></i></div>
                            <h5>24/7 Support</h5>
                            <p>Our team is always here to help, day or night.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ CUSTOMER REVIEWS ============ -->
        <section class="section-padding bg-card">
            <div class="container">
                <div class="section-heading">
                    <span class="eyebrow">Testimonials</span>
                    <h2>What Our Customers Say</h2>
                </div>

                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="stars">★★★★★</div>
                            <p class="review-text">The quality is far beyond what I expected for the price. My leather tote
                                looks and feels genuinely luxurious.</p>
                            <div class="testimonial-author">
                                <img src="https://placehold.co/100x100/E6DFD3/2F3E46?text=AM&font=raleway" alt="Amara M.">
                                <div>
                                    <span class="author-name">Amara M.</span>
                                    <span class="author-role">Verified Buyer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="stars">★★★★★</div>
                            <p class="review-text">Fast shipping and the packaging alone felt premium. The watch is now
                                something I wear every single day.</p>
                            <div class="testimonial-author">
                                <img src="https://placehold.co/100x100/EDE7DE/2F3E46?text=DK&font=raleway"
                                    alt="Daniel K.">
                                <div>
                                    <span class="author-name">Daniel K.</span>
                                    <span class="author-role">Verified Buyer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="stars">★★★★☆</div>
                            <p class="review-text">Clean, minimal, exactly as pictured. Customer support helped me with
                                sizing within minutes.</p>
                            <div class="testimonial-author">
                                <img src="https://placehold.co/100x100/F0EBE3/2F3E46?text=SR&font=raleway" alt="Sara R.">
                                <div>
                                    <span class="author-name">Sara R.</span>
                                    <span class="author-role">Verified Buyer</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ============ NEWSLETTER ============ -->
        <div class="newsletter-strip">
            <div class="container">
                <div class="row align-items-center g-3">
                    <div class="col-lg-5">
                        <h4>Join Our Newsletter</h4>
                        <p>Be the first to hear about new arrivals and exclusive offers.</p>
                    </div>
                    <div class="col-lg-7">
                        <form class="newsletter-form">
                            <input type="email" placeholder="Enter your email address" required>
                            <button type="submit" class="btn-primary-custom">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
