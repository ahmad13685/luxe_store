@extends('layouts.app')

@section('title', 'Shop All Products | Luxe Store')

@section('content')

    <!-- ====== MAIN CONTENT WRAPPER ====== -->
    <main id="main-content">
        <!-- ============ SHOP HEADER ============ -->
        <div class="shop-header">
            <div class="container">
                <h1>Shop All Products</h1>
                <p class="text-muted mb-0">Home / <span class="text-accent">Shop</span></p>
            </div>
        </div>

        <!-- ============ SHOP CONTENT ============ -->
        <section class="section-padding shop-page-content">
            <div class="container">
                <div class="row g-4">

                    <!-- LEFT SIDEBAR -->
                    <div class="col-lg-3">
                        <div class="shop-sidebar">

                            <div class="filter-widget">
                                <div class="filter-widget-head">
                                    <h6>Categories</h6>
                                    <button type="button" class="filter-reset-link" id="resetFiltersBtn">Reset</button>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catFashion"
                                        data-category="Fashion">
                                    <label class="form-check-label" for="catFashion">Fashion <span>(128)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catShoes"
                                        data-category="Shoes">
                                    <label class="form-check-label" for="catShoes">Shoes <span>(76)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catBags"
                                        data-category="Bags">
                                    <label class="form-check-label" for="catBags">Bags <span>(54)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catWatches"
                                        data-category="Watches">
                                    <label class="form-check-label" for="catWatches">Watches <span>(40)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catBeauty"
                                        data-category="Beauty">
                                    <label class="form-check-label" for="catBeauty">Beauty <span>(63)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catAccessories"
                                        data-category="Accessories">
                                    <label class="form-check-label" for="catAccessories">Accessories
                                        <span>(91)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catHome"
                                        data-category="Home Decor">
                                    <label class="form-check-label" for="catHome">Home Decor <span>(48)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-category" type="checkbox" id="catStationery"
                                        data-category="Stationery">
                                    <label class="form-check-label" for="catStationery">Stationery <span>(19)</span></label>
                                </div>
                            </div>

                            <div class="filter-widget">
                                <h6>Price Range</h6>
                                <input type="range" min="0" max="500" value="500" id="priceRange">
                                <div class="price-range-values">
                                    <span>$0</span>
                                    <span id="priceRangeValue">$100</span>
                                    <span>$500</span>
                                </div>
                            </div>

                            <div class="filter-widget">
                                <h6>Availability</h6>
                                <div class="form-check">
                                    <input class="form-check-input filter-availability" type="checkbox" id="stockIn"
                                        data-stock="In Stock">
                                    <label class="form-check-label" for="stockIn">In Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-availability" type="checkbox" id="stockLow"
                                        data-stock="Low Stock">
                                    <label class="form-check-label" for="stockLow">Low Stock</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input filter-availability" type="checkbox" id="stockOut"
                                        data-stock="Out of Stock">
                                    <label class="form-check-label" for="stockOut">Out of Stock</label>
                                </div>
                            </div>

                            <div class="filter-widget">
                                <h6>Brands</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="brandLuxe" checked>
                                    <label class="form-check-label" for="brandLuxe">Luxe Atelier <span>(52)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="brandNordic">
                                    <label class="form-check-label" for="brandNordic">Nordic Studio
                                        <span>(31)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="brandAtelier">
                                    <label class="form-check-label" for="brandAtelier">Maison Blanc
                                        <span>(27)</span></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="brandUrban">
                                    <label class="form-check-label" for="brandUrban">Urban Craft <span>(19)</span></label>
                                </div>
                            </div>

                            <div class="filter-widget">
                                <h6>Rating</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rating4">
                                    <label class="form-check-label" for="rating4">★★★★☆ &amp; up</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="rating3">
                                    <label class="form-check-label" for="rating3">★★★☆☆ &amp; up</label>
                                </div>
                            </div>

                            <button class="btn-primary-custom w-100" id="applyFiltersBtn">Apply Filters</button>
                        </div>
                    </div>

                    <!-- RIGHT: PRODUCT GRID -->
                    <div class="col-lg-9">

                        <div class="shop-toolbar">
                            <div>
                                <span class="result-count">Showing 1–9 of 9 results</span>
                                <span id="shopSearchLabel" class="search-result-label"></span>
                            </div>
                            <select id="shopSortSelect">
                                <option value="featured">Sort by: Featured</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="newest">Newest First</option>
                                <option value="rating">Top Rated</option>
                            </select>
                        </div>

                        <div class="shop-grid" id="shopProductGrid">

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="product-badge">New</span>
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p1.webp') }}" alt="Oversized Linen Shirt">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Oversized Linen Shirt'])) data-wishlist-id="{{ $wishlistMap['Oversized Linen Shirt'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Oversized Linen Shirt">
                                            <input type="hidden" name="product_image" value="p1.webp">
                                            <input type="hidden" name="price" value="68.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Oversized Linen Shirt']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Oversized Linen Shirt']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Oversized Linen Shirt</h3>
                                    <div class="product-rating">★★★★★ <span>(58)</span></div>
                                    <div class="product-price">$68.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 14) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p2.webp') }}" alt="Leather Ankle Boots">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Leather Ankle Boots'])) data-wishlist-id="{{ $wishlistMap['Leather Ankle Boots'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Leather Ankle Boots">
                                            <input type="hidden" name="product_image" value="p2.webp">
                                            <input type="hidden" name="price" value="175.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Leather Ankle Boots']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Leather Ankle Boots']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Leather Ankle Boots</h3>
                                    <div class="product-rating">★★★★☆ <span>(94)</span></div>
                                    <div class="product-price">$175.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 15) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="product-badge badge-sale">-10%</span>
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p3.webp') }}" alt="Tote Bag">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Structured Leather Tote'])) data-wishlist-id="{{ $wishlistMap['Structured Leather Tote'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Structured Leather Tote">
                                            <input type="hidden" name="product_image" value="p3.webp">
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
                                    <div class="product-price">$210.00 <span class="old-price">$235.00</span></div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 2) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="stock-badge">Low Stock</span>
                                    <img src="{{ asset('pic/p4.webp') }}" alt="Chrono Watch">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Chronograph Steel Watch'])) data-wishlist-id="{{ $wishlistMap['Chronograph Steel Watch'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Chronograph Steel Watch">
                                            <input type="hidden" name="product_image" value="p4.webp">
                                            <input type="hidden" name="price" value="289.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Chronograph Steel Watch']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Chronograph Steel Watch']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Chronograph Steel Watch</h3>
                                    <div class="product-rating">★★★★★ <span>(146)</span></div>
                                    <div class="product-price">$289.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 16) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="product-badge">New</span>
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p5.webp') }}" alt="Matte Lipstick">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Matte Velvet Lipstick'])) data-wishlist-id="{{ $wishlistMap['Matte Velvet Lipstick'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Matte Velvet Lipstick">
                                            <input type="hidden" name="product_image" value="p5.webp">
                                            <input type="hidden" name="price" value="22.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Matte Velvet Lipstick']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Matte Velvet Lipstick']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Matte Velvet Lipstick</h3>
                                    <div class="product-rating">★★★★☆ <span>(203)</span></div>
                                    <div class="product-price">$22.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 17) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p6.webp') }}" alt="Silk Tie">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Classic Silk Tie'])) data-wishlist-id="{{ $wishlistMap['Classic Silk Tie'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Classic Silk Tie">
                                            <input type="hidden" name="product_image" value="p6.webp">
                                            <input type="hidden" name="price" value="42.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Classic Silk Tie']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Classic Silk Tie']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Classic Silk Tie</h3>
                                    <div class="product-rating">★★★★★ <span>(47)</span></div>
                                    <div class="product-price">$42.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 18) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p7.webp') }}" alt="Table Lamp">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Ceramic Table Lamp'])) data-wishlist-id="{{ $wishlistMap['Ceramic Table Lamp'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Ceramic Table Lamp">
                                            <input type="hidden" name="product_image" value="p7.webp">
                                            <input type="hidden" name="price" value="88.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Ceramic Table Lamp']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Ceramic Table Lamp']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Ceramic Table Lamp</h3>
                                    <div class="product-rating">★★★★☆ <span>(65)</span></div>
                                    <div class="product-price">$88.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 19) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p8.webp') }}" alt="Notebook Set">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Kraft Notebook Set'])) data-wishlist-id="{{ $wishlistMap['Kraft Notebook Set'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Kraft Notebook Set">
                                            <input type="hidden" name="product_image" value="p8.webp">
                                            <input type="hidden" name="price" value="18.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Kraft Notebook Set']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Kraft Notebook Set']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Kraft Notebook Set</h3>
                                    <div class="product-rating">★★★★★ <span>(38)</span></div>
                                    <div class="product-price">$18.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 20) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                            <div class="product-card">
                                <div class="product-img-wrap">
                                    <span class="product-badge">Bestseller</span>
                                    <span class="stock-badge">In Stock</span>
                                    <img src="{{ asset('pic/p9.webp') }}" alt="Sunglasses">
                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="wishlist-form"
                                            @if(isset($wishlistMap['Round Frame Sunglasses'])) data-wishlist-id="{{ $wishlistMap['Round Frame Sunglasses'] }}" @endif>
                                            @csrf

                                            <input type="hidden" name="product_name" value="Round Frame Sunglasses">
                                            <input type="hidden" name="product_image" value="p9.webp">
                                            <input type="hidden" name="price" value="56.00">

                                            <button type="submit" class="wishlist-btn {{ isset($wishlistMap['Round Frame Sunglasses']) ? 'is-wishlisted' : '' }}">
                                                <i class="bi {{ isset($wishlistMap['Round Frame Sunglasses']) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
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
                                    <h3 class="product-name">Round Frame Sunglasses</h3>
                                    <div class="product-rating">★★★★★ <span>(112)</span></div>
                                    <div class="product-price">$56.00</div>
                                    <div class="product-actions">
                                        <a href="{{ route('customer.product-details', 21) }}" class="btn-view">View</a>
                                        <button class="btn-cart">Add</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


@endsection
