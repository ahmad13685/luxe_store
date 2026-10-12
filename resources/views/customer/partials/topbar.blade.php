{{-- Top bar shown above the page content, inside the dashboard-main column --}}
<div class="dashboard-topbar">
  <button type="button" class="sidebar-toggle-btn" id="sidebarToggleBtn" aria-label="Toggle menu">
    <i class="bi bi-list"></i>
  </button>

  <h1 class="dashboard-page-title">@yield('page-title', 'Dashboard')</h1>

  <div class="topbar-user">
    @if(session('customer_id') && isset($customer))
      @if($customer->photoUrl())
        <img src="{{ $customer->photoUrl() }}" alt="{{ $customer->name }}" class="topbar-avatar">
      @else
        <span class="topbar-avatar topbar-avatar-initials">{{ $customer->initials() }}</span>
      @endif
      <span class="topbar-username d-none d-sm-inline">{{ $customer->name }}</span>
    @endif
  </div>
</div>
