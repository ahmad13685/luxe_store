@extends('layouts.customer')

@section('title', 'Order #' . $order->order_number)
@section('page-title', 'Order Details')

@section('content')
<div class="dashboard-container">

    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-greeting">Order #{{ $order->order_number }}</h1>
            <p class="dashboard-subtext">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
        </div>
        <span class="{{ $order->statusBadgeClass() }}">{{ $order->status }}</span>
    </div>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="dashboard-card">
                <h2><i class="bi bi-box-seam"></i> Items</h2>
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        @if(!empty($item->product_image))
                                            <img src="{{ $item->product_image }}" alt="{{ $item->product_name }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                        @endif
                                    </td>
                                    <td>{{ $item->product_name }}</td>
                                    <td>${{ number_format($item->unit_price, 2) }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>${{ number_format($item->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end">Subtotal</td>
                                <td>${{ number_format($order->subtotal, 2) }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end">Shipping</td>
                                <td>{{ $order->shipping_fee > 0 ? '$' . number_format($order->shipping_fee, 2) : 'Free' }}</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">${{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="dashboard-card">
                <h2><i class="bi bi-truck"></i> Shipping</h2>
                <p class="mb-1"><strong>Address</strong></p>
                <p class="text-muted">{{ $order->shipping_address ?? 'Not provided' }}</p>
                <p class="mb-1"><strong>Payment Method</strong></p>
                <p class="text-muted">{{ $order->payment_method }}</p>
            </div>

            <div class="dashboard-card">
                <a href="{{ route('customer.order.tracking', $order->id) }}" class="btn-primary-custom w-100 text-center d-block mb-2">Track This Order</a>
                <a href="{{ route('customer.orders') }}" class="btn-outline-custom w-100 text-center d-block">Back to My Orders</a>
                @if($order->status === \App\Models\Order::STATUS_PENDING)
                    <form action="{{ route('customer.order.cancel', $order->id) }}" method="POST" class="mt-2" onsubmit="return confirm('Cancel this order?');">
                        @csrf
                        <button type="submit" class="btn-outline-custom w-100 text-center d-block">Cancel Order</button>
                    </form>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
