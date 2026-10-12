@extends('layouts.customer')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

  {{-- ===================== GREETING ===================== --}}
  <div class="dash-greeting-row">
    <div>
      <h2 class="dash-greeting">👋 Hi, {{ explode(' ', $customer->name)[0] }}</h2>
      <p class="dash-greeting-sub">Here's what's happening with your account today.</p>
    </div>
  </div>

  <div class="row g-4 dashboard-layout-row">

    {{-- ===================== MAIN COLUMN ===================== --}}
    <div class="col-lg-8">

      {{-- ----- Wishlist preview (real data from the wishlists table) ----- --}}
      <div class="dashboard-card wishlist-preview-card">
        <div class="dashboard-card-head">
          <h2>From Your Wishlist</h2>
          {{-- Becomes a real link once the Wishlist page module is built --}}
          <a href="{{ route('customer.wishlist') }}" class="view-all-link">
    View All <i class="bi bi-arrow-right"></i>
</a>
        </div>

        @if($wishlistPreview->isEmpty())
          <div class="empty-state-block">
            <i class="bi bi-heart"></i>
            <p>Your wishlist is empty. <a href="{{ url('/shop') }}" class="auth-link">Browse the shop</a> to save your favorites.</p>
          </div>
        @else
          <div class="wishlist-preview-row">
            @foreach($wishlistPreview as $item)
              <div class="wishlist-mini-card">
                <div class="wmc-img">
                  <img src="{{ $item->image_url }}" alt="{{ $item->product_name }}">
                </div>
                <div class="wmc-name">{{ $item->product_name }}</div>
                <div class="wmc-price">${{ number_format($item->price, 2) }}</div>
              </div>
            @endforeach
          </div>
        @endif
      </div>

      {{-- ----- Stat cards ----- --}}
      <div class="row g-3 stat-cards-row">

        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon stat-icon-total"><i class="bi bi-bag-check"></i></div>
            <div>
              <span class="stat-number">{{ $totalOrders }}</span>
              <span class="stat-label">Total Orders</span>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon stat-icon-pending"><i class="bi bi-hourglass-split"></i></div>
            <div>
              <span class="stat-number">{{ $pendingOrders }}</span>
              <span class="stat-label">Pending Orders</span>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon stat-icon-delivered"><i class="bi bi-check-circle"></i></div>
            <div>
              <span class="stat-number">{{ $deliveredOrders }}</span>
              <span class="stat-label">Delivered</span>
            </div>
          </div>
        </div>

        <div class="col-6 col-md-3">
          <div class="stat-card">
            <div class="stat-icon stat-icon-wishlist"><i class="bi bi-heart"></i></div>
            <div>
              <span class="stat-number">{{ $wishlistItems }}</span>
              <span class="stat-label">Wishlist</span>
            </div>
          </div>
        </div>

      </div>

      {{-- ----- Recent Orders ----- --}}
      <div class="dashboard-card recent-orders-card">
        <div class="dashboard-card-head">
          <h2>Recent Orders</h2>
          <a href="{{ route('customer.orders') }}" class="view-all-link">View All <i class="bi bi-arrow-right"></i></a>
        </div>

        @if($recentOrders->isEmpty())
          <div class="empty-state-block">
            <i class="bi bi-bag"></i>
            <p>You haven't placed any orders yet.</p>
          </div>
        @else
          <div class="order-rows-list">
            @foreach($recentOrders as $order)
              <div class="order-row">
                <div class="order-row-icon"><i class="bi bi-bag-fill"></i></div>
                <div class="order-row-info">
                  <span class="order-row-id">#{{ $order->order_number }}</span>
                  <span class="order-row-meta">{{ $order->created_at->format('d M Y') }} &middot; {{ $order->items->count() }} item{{ $order->items->count() === 1 ? '' : 's' }}</span>
                </div>
                <div class="order-row-amount">${{ number_format($order->total_amount, 2) }}</div>
                <span class="{{ $order->statusBadgeClass() }} order-row-status">{{ $order->status }}</span>
                <a href="{{ route('customer.order.detail', $order->id) }}" class="table-action-link order-row-action">View <i class="bi bi-chevron-right"></i></a>
              </div>
            @endforeach
          </div>
        @endif
      </div>

    </div>

    {{-- ===================== RIGHT PANEL ===================== --}}
    <div class="col-lg-4">

      {{-- ----- Profile snapshot ----- --}}
      <div class="dashboard-card profile-snapshot-card">
        <div class="profile-snapshot-top">
          @if($customer->photoUrl())
            <img src="{{ $customer->photoUrl() }}" alt="{{ $customer->name }}" class="profile-snapshot-avatar">
          @else
            <span class="profile-snapshot-avatar profile-snapshot-initials">{{ $customer->initials() }}</span>
          @endif
          <div>
            <h3>{{ $customer->name }}</h3>
            <p>{{ $customer->email }}</p>
          </div>
        </div>
        <div class="profile-snapshot-meta">
          <i class="bi bi-calendar3"></i> Member since {{ $customer->created_at->format('M Y') }}
        </div>
        {{-- Becomes a real link once the My Profile module is built --}}
        <a href="{{ route('customer.profile.edit') }}" class="btn-outline-custom w-100 text-center d-block mt-3">Edit Profile</a>
      </div>

      {{-- ----- Order progress (real percentages, not decorative) ----- --}}
      <div class="dashboard-card order-progress-card">
        <h2 class="mini-card-title">Order Progress</h2>

        <div class="progress-row">
          <div class="progress-row-head">
            <span><i class="bi bi-hourglass-split"></i> Pending</span>
            <span>{{ $orderProgress['pending'] }}%</span>
          </div>
          <div class="progress-track"><div class="progress-fill progress-fill-pending" style="width: {{ $orderProgress['pending'] }}%"></div></div>
        </div>

        <div class="progress-row">
          <div class="progress-row-head">
            <span><i class="bi bi-truck"></i> In Transit</span>
            <span>{{ $orderProgress['in_transit'] }}%</span>
          </div>
          <div class="progress-track"><div class="progress-fill progress-fill-transit" style="width: {{ $orderProgress['in_transit'] }}%"></div></div>
        </div>

        <div class="progress-row">
          <div class="progress-row-head">
            <span><i class="bi bi-check-circle"></i> Delivered</span>
            <span>{{ $orderProgress['delivered'] }}%</span>
          </div>
          <div class="progress-track"><div class="progress-fill progress-fill-delivered" style="width: {{ $orderProgress['delivered'] }}%"></div></div>
        </div>
      </div>

      {{-- ----- Quick links ----- --}}
      <div class="dashboard-card quick-links-card">
        <h2 class="mini-card-title">Quick Links</h2>
        <a href="{{ url('/shop') }}" class="quick-link-item"><i class="bi bi-bag-plus"></i> Continue Shopping</a>
        <a href="{{ route('customer.orders') }}" class="quick-link-item"><i class="bi bi-truck"></i> Track an Order</a>
        <a href="{{ route('customer.wishlist') }}" class="quick-link-item"><i class="bi bi-heart"></i> View Wishlist</a>
      </div>

    </div>

  </div>

@endsection
