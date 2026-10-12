<div class="product-card">
    <div class="product-img-wrap">
        @if ($product->created_at && $product->created_at->gt(now()->subDays(14)))
            <span class="product-badge">New</span>
        @endif

        <span class="stock-badge">
            @if ($product->stock <= 0)
                Out of Stock
            @elseif ($product->stock <= 5)
                Low Stock
            @else
                In Stock
            @endif
        </span>

        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" loading="lazy"
            data-product-id="{{ $product->id }}"
            data-image-version="{{ optional($product->updated_at)->timestamp }}">

        @if (session('customer_id'))
            <form method="POST" action="{{ route('customer.wishlist.store') }}"
                class="wishlist-form"
                @if(isset($wishlistMap[$product->name])) data-wishlist-id="{{ $wishlistMap[$product->name] }}" @endif>
                @csrf

                <input type="hidden" name="product_name" value="{{ $product->name }}">
                <input type="hidden" name="product_image" value="{{ $product->image }}">
                <input type="hidden" name="price" value="{{ $product->price }}">

                <button type="submit" class="wishlist-btn {{ isset($wishlistMap[$product->name]) ? 'is-wishlisted' : '' }}">
                    <i class="bi {{ isset($wishlistMap[$product->name]) ? 'bi-heart-fill' : 'bi-heart' }}"></i>
                </button>
            </form>
        @else
            <a href="{{ route('customer.login') }}" class="wishlist-btn">
                <i class="bi bi-heart"></i>
            </a>
        @endif
    </div>

    <div class="product-info">
        <span class="product-category">{{ $product->category_name }}</span>
        <h3 class="product-name">{{ $product->name }}</h3>
        <div class="product-rating">★★★★★</div>
        <div class="product-price">${{ number_format((float) $product->price, 2) }}</div>

        <div class="product-actions">
            <a href="{{ route('product.show', $product) }}" class="btn-view">View</a>
            @if ($product->stock > 0)
                <button class="btn-cart">Add</button>
            @else
                <button class="btn-cart" disabled>Out</button>
            @endif
        </div>
    </div>
</div>
