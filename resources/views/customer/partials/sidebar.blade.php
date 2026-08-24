{{--
    Dashboard sidebar.

    "Dashboard", "My Orders", "Track Order" and "Logout" are real links now.
    Wishlist/Profile/Change Password are still "#" placeholders until
    their modules are built - swap href="#" for a real route() call
    as each one ships.
--}}
<aside class="dashboard-sidebar" id="dashboardSidebar">
  <div class="sidebar-brand">
    <a href="{{ url('/') }}">LUXE</a>
    <span>My Account</span>
  </div>

  <nav class="sidebar-nav">
    <a href="{{ route('customer.dashboard') }}" class="sidebar-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}">
      <i class="bi bi-grid-1x2"></i> Dashboard
    </a>
    <a href="{{ route('customer.orders') }}" class="sidebar-link {{ request()->routeIs('customer.orders') || request()->routeIs('customer.order.detail') ? 'active' : '' }}">
      <i class="bi bi-bag-check"></i> My Orders
    </a>
    <a href="{{ route('customer.orders') }}" class="sidebar-link {{ request()->routeIs('customer.order.tracking') ? 'active' : '' }}">
      <i class="bi bi-truck"></i> Track Order
    </a>
    <a href="{{ route('customer.wishlist') }}" class="sidebar-link">
      <i class="bi bi-heart"></i> Wishlist
    </a>
    <a href="{{ route('customer.profile.edit') }}" class="sidebar-link {{ request()->routeIs('customer.profile.*') ? 'active' : '' }}">
      <i class="bi bi-person-circle"></i> My Profile
    </a>
    <a href="{{ url('/customer/forgot-password') }}" class="sidebar-link">
      <i class="bi bi-shield-lock"></i> Change Password
    </a>

    <div class="sidebar-divider"></div>

    {{-- Logout must be POST (not a plain link) so it can't be
         triggered accidentally by a crawler or a stray click --}}
    <form method="POST" action="{{ route('customer.logout') }}" class="sidebar-logout-form">
      @csrf
      <button type="submit" class="sidebar-link sidebar-link-logout">
        <i class="bi bi-box-arrow-right"></i> Logout
      </button>
    </form>
  </nav>
</aside>

<!-- Dims the page and closes the sidebar when tapped on mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>
