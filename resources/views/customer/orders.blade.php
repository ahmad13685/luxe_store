@extends('layouts.customer')

@section('title', 'My Orders')
@section('page-title', 'My Orders')

@section('content')
<div class="dashboard-container">

    <div class="dashboard-card">
        <div class="dashboard-card-head">
            <h2><i class="bi bi-bag-check"></i> My Orders</h2>
        </div>

        @if($orders->isEmpty())
            <div class="empty-state-block">
                <i class="bi bi-bag"></i>
                <p>You haven't placed any orders yet. <a href="{{ url('/shop') }}" class="auth-link">Browse the shop</a> to get started.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Order #</th>
                            <th>Date</th>
                            <th>Items</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php $firstItem = $order->items->first(); @endphp
                            <tr>
                                <td>
                                    @if($firstItem && !empty($firstItem->product_image))
                                        <img src="{{ $firstItem->product_image }}" alt="{{ $firstItem->product_name }}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;">
                                    @endif
                                </td>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->created_at->format('d M Y') }}</td>
                                <td>{{ $order->items->count() }} item{{ $order->items->count() === 1 ? '' : 's' }}</td>
                                <td>${{ number_format($order->total_amount, 2) }}</td>
                                <td><span class="{{ $order->statusBadgeClass() }}">{{ $order->status }}</span></td>
                                <td class="text-end">
                                    <a href="{{ route('customer.order.detail', $order->id) }}" class="table-action-link">View</a>
                                    <a href="{{ route('customer.order.tracking', $order->id) }}" class="table-action-link">Track</a>
                                    @if($order->status === \App\Models\Order::STATUS_PENDING)
                                        <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Cancel this order?');">
                                            @csrf
                                            <button type="submit" class="table-action-link table-action-link-danger">Cancel</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $orders->links() }}
            </div>
        @endif
    </div>

</div>
@endsection

@section('scripts')
@if(session('success') && str_contains(session('success'), 'Order placed'))
<script>
    // The PHP session cart is cleared in OrderController@placeOrder,
    // but the localStorage cart (used everywhere on the public site)
    // is separate and needs to be cleared too, or the navbar badge
    // and mini-cart would keep showing items from the order just placed.
    localStorage.removeItem('luxe-cart');
</script>
@endif
@endsection
