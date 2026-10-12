@extends('layouts.customer')

@section('title', 'Track Order #' . $order->order_number)
@section('page-title', 'Order Tracking')

@section('content')
<div class="dashboard-container">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-greeting">Tracking Order #{{ $order->order_number }}</h1>
            <p class="dashboard-subtext">Placed on {{ $order->created_at->format('d M Y') }}</p>
        </div>
        <span class="{{ $order->statusBadgeClass() }}">{{ $order->status }}</span>
    </div>

    @if($order->status === 'Cancelled')
        <div class="dashboard-card">
            <div class="empty-state-block">
                <i class="bi bi-x-circle"></i>
                <p>This order was cancelled and is no longer being tracked.</p>
            </div>
        </div>
    @else
        <div class="dashboard-card">
            <h2><i class="bi bi-truck"></i> Tracking Timeline</h2>

            <ul class="tracking-timeline">
                @foreach($steps as $index => $step)
                    <li class="tracking-step {{ $index <= $currentIndex ? 'completed' : '' }} {{ $index === $currentIndex ? 'current' : '' }}">
                        <span class="tracking-step-dot"><i class="bi bi-check-lg"></i></span>
                        <span class="tracking-step-label">{{ $step }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="dashboard-card">
        <a href="{{ route('customer.order.detail', $order->id) }}" class="btn-outline-custom">View Order Details</a>
        <a href="{{ route('customer.orders') }}" class="btn-outline-custom">Back to My Orders</a>
    </div>

</div>

<style>
    /* Minimal inline styles so the timeline works even before
       dashboard.css is updated with a matching class set. */
    .tracking-timeline { list-style: none; padding: 0; margin: 1rem 0 0; }
    .tracking-step { display: flex; align-items: center; gap: .75rem; padding: .5rem 0; opacity: .5; }
    .tracking-step.completed { opacity: 1; }
    .tracking-step-dot { width: 24px; height: 24px; border-radius: 50%; border: 2px solid currentColor; display: inline-flex; align-items: center; justify-content: center; font-size: .75rem; }
    /* Fixed mid-tone green (not currentColor) so the checkmark stays
       white-on-green and readable in both light and dark theme - using
       currentColor here would resolve to the icon's own white color,
       making the dot the same color as the icon and hiding it. */
    .tracking-step.completed .tracking-step-dot { background: #3E8E5A; border-color: #3E8E5A; color: #fff; }
    .tracking-step-dot i { display: none; }
    .tracking-step.completed .tracking-step-dot i { display: inline; }
    .tracking-step.current .tracking-step-label { font-weight: 700; }
</style>
@endsection
