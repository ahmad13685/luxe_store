@extends('layouts.app')

@section('title', 'Your Cart | Luxe Store')

@section('content')

  <!-- ============ BREADCRUMB ============ -->
  <div class="breadcrumb-strip">
    <div class="container">
      <a href="{{ url('/') }}">Home</a> / <span class="current">Your Cart</span>
    </div>
  </div>

  <!-- ============ CART PAGE CONTENT ============ -->
  <section class="section-padding">
    <div class="container">

      <!-- Shown when there is nothing in the cart -->
      <div class="cart-empty-page" id="cartPageEmpty">
        <i class="bi bi-cart-x"></i>
        <h2 class="fw-bold mb-2">Your cart is empty</h2>
        <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
        <a href="{{ url('/shop') }}" class="btn-primary-custom">Continue Shopping</a>
      </div>

      <!-- Shown when the cart has at least one item -->
      <div class="row g-4 d-none" id="cartPageFilled">

        <!-- LEFT: CART ITEMS TABLE -->
        <div class="col-lg-8">
          <div class="cart-page-table" id="cartPageRows">
            <!-- Rows are injected here by cartPageRowTemplate() in script.js -->
          </div>
        </div>

        <!-- RIGHT: ORDER SUMMARY -->
        <div class="col-lg-4">
          <div class="order-summary-card">
            <h5>Order Summary</h5>

            <div class="coupon-row">
              <input type="text" id="couponInput" placeholder="Coupon code">
              <button type="button" id="applyCouponBtn">Apply</button>
            </div>
            <p id="couponMsg" class="small mb-3"></p>

            <div class="cart-summary-row">
              <span>Subtotal</span>
              <span id="summarySubtotal">$0.00</span>
            </div>
            <div class="cart-summary-row">
              <span>Shipping</span>
              <span id="summaryShipping">Free</span>
            </div>
            <div class="cart-summary-row">
              <span>Discount</span>
              <span id="summaryDiscount">-$0.00</span>
            </div>
            <div class="cart-summary-row total-row">
              <span>Total</span>
              <span id="summaryTotal">$0.00</span>
            </div>

            <button type="button" class="btn-primary-custom w-100 text-center d-block mt-3" id="proceedToCheckoutBtn">Proceed to Checkout</button>
            <a href="{{ url('/shop') }}" class="btn-outline-custom w-100 text-center d-block mt-2">Continue Shopping</a>
          </div>
        </div>

      </div>

    </div>
  </section>

  <!-- ============ PROCEED TO CHECKOUT ============ -->
  <!-- "Proceed to Checkout" used to open a fake, front-end-only modal
       that never created a real order. It now syncs the localStorage
       cart into the server session (see /cart/sync, CartController)
       and sends the customer to the real checkout page. If they
       aren't logged in yet, customer.auth middleware bounces them to
       /customer/login first and brings them back after. -->
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const btn = document.getElementById('proceedToCheckoutBtn');
  if (!btn) return;

  // syncCartAndGoToCheckout() lives in script.js (shared with the
  // "Buy Now" buttons elsewhere on the site) - it posts the
  // localStorage cart to /cart/sync then redirects to /customer/checkout.
  btn.addEventListener('click', function () {
    if (typeof syncCartAndGoToCheckout === 'function') {
      syncCartAndGoToCheckout();
    }
  });
});
</script>
@endsection
