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

                                @forelse ($categories as $category)
                                    @php($categoryId = 'cat-' . \Illuminate\Support\Str::slug($category->name))

                                    <div class="form-check">
                                        <input class="form-check-input filter-category" type="checkbox"
                                            id="{{ $categoryId }}" data-category="{{ $category->name }}">

                                        <label class="form-check-label" for="{{ $categoryId }}">
                                            {{ $category->name }}
                                            <span>({{ $category->products_count }})</span>
                                        </label>
                                    </div>
                                @empty
                                    <span class="text-muted">No categories available.</span>
                                @endforelse
                            </div>

                            <div class="filter-widget">
                                <h6>Price Range</h6>
                                <input type="range" min="0" max="{{ $maxPrice }}" value="{{ $maxPrice }}"
                                    id="priceRange">
                                <div class="price-range-values">
                                    <span>$0</span>
                                    <span id="priceRangeValue">${{ $maxPrice }}</span>
                                    <span>${{ $maxPrice }}</span>
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
                                <span class="result-count">Showing {{ $products->count() }} of {{ $products->count() }}
                                    results</span>
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
                            @forelse ($products as $product)
                                @include('partials.product-card', ['product' => $product])
                            @empty
                                <div class="col-12">
                                    <div class="text-center py-5">
                                        <h4>No products found</h4>
                                        <p class="text-muted">Try another search or add an active product from the Admin
                                            panel.</p>
                                    </div>
                                </div>
                            @endforelse

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>


@endsection
