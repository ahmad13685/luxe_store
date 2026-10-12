@extends('layouts.customer')

@section('title', 'My Wishlist')
@section('page-title', 'My Wishlist')

@section('content')

<div class="dashboard-container">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-greeting">My Wishlist</h1>
            <p class="dashboard-subtext">
                Products you saved for later.
            </p>
        </div>

        <a href="{{ url('/shop') }}" class="btn-outline-custom">
            <i class="bi bi-shop"></i>
            Continue Shopping
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if($wishlist->isEmpty())

        <div class="dashboard-card wishlist-empty-card">
            <div class="wishlist-empty-icon">
                <i class="bi bi-heart"></i>
            </div>

            <h2>Your Wishlist is Empty</h2>

            <p>
                You haven't saved any products yet.
            </p>

            <a href="{{ url('/shop') }}" class="btn-primary-custom">
                Browse Products
            </a>
        </div>

    @else

        <div class="wishlist-grid">

            @foreach($wishlist as $item)

                <div class="dashboard-card wishlist-product-card">

                    <div class="wishlist-product-image">

                        <img
                            src="{{ $item->image_url }}"
                            alt="{{ $item->product_name }}"
                        >

                    </div>

                    <div class="wishlist-product-info">

                        <h3>
                            {{ $item->product_name }}
                        </h3>

                        <div class="wishlist-product-price">
                            ${{ number_format($item->price, 2) }}
                        </div>

                        <div class="wishlist-actions">

                            <a
                                href="{{ $item->product_id ? route('product.show', $item->product_id) : url('/shop') }}"
                                class="btn-primary-custom"
                            >
                                View Product
                            </a>

                            <form
                                method="POST"
                                action="{{ route('customer.wishlist.destroy', $item->id) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="wishlist-remove-btn"
                                >
                                    <i class="bi bi-trash"></i>
                                    Remove
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>

@endsection
