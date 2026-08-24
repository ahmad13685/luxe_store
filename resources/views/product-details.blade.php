@extends('layouts.app')

@section('title', $product->name . ' | Luxe Store')

@section('content')

    {{-- BREADCRUMB --}}
    <div class="breadcrumb-strip">
        <div class="container">
            <a href="{{ url('/') }}">Home</a>
            /
            <a href="{{ url('/shop') }}">
                {{ $product->category ?: 'Products' }}
            </a>
            /
            <span class="current">{{ $product->name }}</span>
        </div>
    </div>


    {{-- PRODUCT DETAILS --}}
    <section class="section-padding">

        <div class="container">

            <div class="row g-5">

                {{-- LEFT: GALLERY --}}
                <div class="col-lg-6">

                    <div class="pd-gallery">

                        {{-- DYNAMIC PRODUCT GALLERY --}}
                        @php
                            $galleryImages = $product->images;

                            if ($galleryImages->isEmpty() && $product->image) {
                                $galleryImages = collect([
                                    (object) [
                                        'image' => $product->image,
                                        'sort_order' => 1,
                                    ],
                                ]);
                            }
                        @endphp

                        <div class="pd-thumbnails">

                            @foreach ($galleryImages as $index => $galleryImage)
                                <img src="{{ asset($galleryImage->image) }}" alt="{{ $product->name }}"
                                    class="{{ $index === 0 ? 'active' : '' }}" onclick="changeProductImage(this)">
                            @endforeach

                        </div>

                        <div class="pd-main-image">

                            @if ($galleryImages->isNotEmpty())
                                <img src="{{ asset($galleryImages->first()->image) }}" alt="{{ $product->name }}"
                                    id="pdMainImage">
                            @else
                                <div class="d-flex align-items-center justify-content-center h-100">
                                    <span>No image available</span>
                                </div>
                            @endif

                        </div>

                    </div>

                </div>

                {{-- RIGHT: PRODUCT INFO --}}
                <div class="col-lg-6 pd-info">

                    <span class="pd-badge">
                        New Arrival
                    </span>

                    <h1>
                        {{ $product->name }}
                    </h1>

                    <p class="pd-brand">
                        Category:
                        <strong>
                            {{ $product->category ?: 'General' }}
                        </strong>
                    </p>


                    <div class="pd-rating-row">

                        <span class="stars">
                            ★★★★★
                        </span>

                        <span class="review-count">
                            Product
                        </span>

                    </div>


                    {{-- PRICE --}}
                    <div class="pd-price-row">

                        <span class="price">
                            ${{ number_format($product->price, 2) }}
                        </span>

                    </div>


                    {{-- PRODUCT META --}}
                    <ul class="pd-meta-list">

                        <li>
                            <span>Availability</span>

                            @if ($product->stock > 0)
                                <span class="in-stock">
                                    In Stock
                                </span>
                            @else
                                <span class="text-danger">
                                    Out of Stock
                                </span>
                            @endif
                        </li>

                        <li>
                            <span>SKU</span>

                            <span>
                                LX-{{ str_pad($product->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </li>

                        <li>
                            <span>Category</span>

                            <span>
                                {{ $product->category ?: 'General' }}
                            </span>
                        </li>

                        <li>
                            <span>Stock</span>

                            <span>
                                {{ $product->stock }}
                            </span>
                        </li>

                    </ul>


                    {{-- QUANTITY --}}
                    @if ($product->stock > 0)
                        <label class="fw-semibold mb-2 d-block" style="font-size:14px;">
                            Quantity
                        </label>

                        <div class="qty-selector">

                            <button type="button" id="qtyMinus">
                                &minus;
                            </button>

                            <input type="text" id="qtyInput" value="1" readonly>

                            <button type="button" id="qtyPlus">
                                +
                            </button>

                        </div>
                    @endif


                    {{-- ACTION BUTTONS --}}
                    <div class="pd-action-row">

                        @if ($product->stock > 0)
                            <button type="button" class="btn-cart flex-grow-1"
                                style="
                                flex:1;
                                padding:14px 0;
                                border-radius:4px;
                                background-color:var(--color-primary);
                                color:#fff;
                                border:1px solid var(--color-primary);
                                font-weight:700;
                            ">
                                <i class="bi bi-bag-plus"></i>
                                Add To Cart
                            </button>

                            <button type="button" class="btn-buy-now">
                                Buy Now
                            </button>
                        @else
                            <button type="button" class="btn-cart flex-grow-1" disabled>
                                Out of Stock
                            </button>
                        @endif


                        {{-- WISHLIST --}}
                        @if (session('customer_id'))
                            <form method="POST" action="{{ route('customer.wishlist.store') }}" class="m-0">
                                @csrf

                                <input type="hidden" name="product_name" value="{{ $product->name }}">

                                <input type="hidden" name="product_image" value="{{ $product->image }}">

                                <input type="hidden" name="price" value="{{ $product->price }}">

                                <button type="submit" class="pd-wishlist-btn" title="Add to Wishlist">
                                    <i class="bi bi-heart"></i>
                                </button>

                            </form>
                        @else
                            <a href="{{ route('customer.login') }}" class="pd-wishlist-btn"
                                title="Sign in to add to Wishlist">
                                <i class="bi bi-heart"></i>
                            </a>
                        @endif

                    </div>


                    {{-- TRUST --}}
                    <div class="pd-trust-row">

                        <div class="trust-mini">
                            <i class="bi bi-truck"></i>
                            Free shipping over $80
                        </div>

                        <div class="trust-mini">
                            <i class="bi bi-arrow-repeat"></i>
                            30-day returns
                        </div>

                        <div class="trust-mini">
                            <i class="bi bi-shield-check"></i>
                            Secure checkout
                        </div>

                    </div>

                </div>

            </div>


            {{-- PRODUCT TABS --}}
            <div class="pd-tabs">

                <ul class="nav nav-tabs" id="productTabs" role="tablist">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-description"
                            type="button">
                            Description
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-details" type="button">
                            Additional Details
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-reviews" type="button">
                            Reviews
                        </button>
                    </li>

                </ul>


                <div class="tab-content">

                    {{-- DESCRIPTION --}}
                    <div class="tab-pane fade show active" id="tab-description">

                        @if ($product->description)
                            <p>
                                {{ $product->description }}
                            </p>
                        @else
                            <p>
                                No description available.
                            </p>
                        @endif

                    </div>


                    {{-- DETAILS --}}
                    <div class="tab-pane fade" id="tab-details">

                        <ul>

                            <li>
                                Product ID:
                                {{ $product->id }}
                            </li>

                            <li>
                                Category:
                                {{ $product->category ?: 'General' }}
                            </li>

                            <li>
                                Stock:
                                {{ $product->stock }}
                            </li>

                            <li>
                                Status:
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </li>

                        </ul>

                    </div>


                    {{-- REVIEWS --}}
                    <div class="tab-pane fade" id="tab-reviews">

                        <p>
                            Reviews will be available soon.
                        </p>

                    </div>

                </div>

            </div>

        </div>

    </section>


    {{-- RELATED PRODUCTS --}}
    @if (isset($relatedProducts) && $relatedProducts->count())

        <section class="section-padding bg-card">

            <div class="container">

                <div class="section-heading">

                    <span class="eyebrow">
                        You May Also Like
                    </span>

                    <h2>
                        Related Products
                    </h2>

                </div>


                <div class="row g-4">

                    @foreach ($relatedProducts as $related)
                        <div class="col-sm-6 col-lg-3">

                            <div class="product-card">

                                <div class="product-img-wrap">

                                    @if ($related->stock > 0)
                                        <span class="stock-badge">
                                            In Stock
                                        </span>
                                    @else
                                        <span class="stock-badge">
                                            Out of Stock
                                        </span>
                                    @endif


                                    <img src="{{ $related->image_url }}" alt="{{ $related->name }}">


                                    @if (session('customer_id'))
                                        <form method="POST" action="{{ route('customer.wishlist.store') }}"
                                            class="m-0">

                                            @csrf

                                            <input type="hidden" name="product_name" value="{{ $related->name }}">

                                            <input type="hidden" name="product_image" value="{{ $related->image }}">

                                            <input type="hidden" name="price" value="{{ $related->price }}">

                                            <button type="submit" class="wishlist-btn">
                                                <i class="bi bi-heart"></i>
                                            </button>

                                        </form>
                                    @else
                                        <a href="{{ route('customer.login') }}" class="wishlist-btn">
                                            <i class="bi bi-heart"></i>
                                        </a>
                                    @endif

                                </div>


                                <div class="product-info">

                                    <span class="product-category">
                                        {{ $related->category ?: 'General' }}
                                    </span>

                                    <h3 class="product-name">
                                        {{ $related->name }}
                                    </h3>

                                    <div class="product-rating">
                                        ★★★★★
                                    </div>

                                    <div class="product-price">
                                        ${{ number_format($related->price, 2) }}
                                    </div>

                                    <div class="product-actions">

                                        <a href="{{ route('customer.product-details', $related->id) }}" class="btn-view">
                                            View
                                        </a>

                                        <button type="button" class="btn-cart">
                                            Add
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

            </div>

        </section>

    @endif


    {{-- GALLERY SCRIPT --}}
    <script>
        function changeProductImage(thumbnail) {

            const mainImage = document.getElementById('pdMainImage');

            if (!mainImage || !thumbnail) {
                return;
            }

            mainImage.src = thumbnail.src;

            document
                .querySelectorAll('.pd-thumbnails img')
                .forEach(function(img) {
                    img.classList.remove('active');
                });

            thumbnail.classList.add('active');
        }
    </script>

@endsection
