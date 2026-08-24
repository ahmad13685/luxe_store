@extends('layouts.customer')

@section('title', 'Checkout')
@section('page-title', 'Checkout')

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <div>
            <h1 class="dashboard-greeting">Checkout</h1>
            <p class="dashboard-subtext">Review your order and complete your purchase.</p>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <!-- Order Summary -->
        <div class="col-lg-7">
            <div class="dashboard-card">
                <h2><i class="bi bi-box-seam"></i> Order Summary</h2>
                <div class="table-responsive">
                    <table class="dashboard-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total = 0; @endphp
                            @foreach($cart as $item)
                                @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                                <tr>
                                    <td>
                                        @if(!empty($item['image']))
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width:48px;height:48px;object-fit:cover;border-radius:6px;">
                                        @endif
                                    </td>
                                    <td>{{ $item['name'] }}</td>
                                    <td>${{ number_format($item['price'], 2) }}</td>
                                    <td>{{ $item['quantity'] }}</td>
                                    <td>${{ number_format($subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end fw-bold">Total</td>
                                <td class="fw-bold">${{ number_format($total, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- Shipping Details -->
        <div class="col-lg-5">
            <div class="dashboard-card">
                <h2><i class="bi bi-truck"></i> Shipping Details</h2>
                <form action="{{ route('customer.place.order') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter full name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phone</label>
                        <input type="text" name="phone" class="form-control" placeholder="Enter phone number" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="shipping_address" class="form-control" rows="3" placeholder="Enter shipping address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Payment Method</label>
                        <select name="payment_method" id="paymentMethod" class="form-control" required>
                            <option value="VPP / Pay on Delivery">VPP / Pay on Delivery</option>
                            <option value="Credit / Debit Card">Credit / Debit Card</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>

                    <div id="cardFields" class="border rounded p-3 mb-3 d-none">
                        <label class="form-label">Card Number</label>
                        <input type="text" name="card_number" id="cardNumber" class="form-control mb-2" inputmode="numeric" autocomplete="cc-number" maxlength="19" placeholder="1234 5678 9012 3456">
                        @error('card_number')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                        <label class="form-label mt-2">Expiry</label>
                        <input type="text" name="card_expiry" id="cardExpiry" class="form-control" inputmode="numeric" autocomplete="cc-exp" maxlength="5" placeholder="MM/YY">
                        @error('card_expiry')<div class="text-danger small mt-1">{{ $message }}</div>@enderror

                        <small class="text-muted d-block mt-2">
                            Card numbers are checked for a valid card-number checksum. No full card number or CVV is stored.
                        </small>
                    </div>

                    <div id="chequeFields" class="border rounded p-3 mb-3 d-none">
                        <label class="form-label">Cheque Number</label>
                        <input type="text" name="cheque_number" class="form-control" maxlength="100" placeholder="Enter cheque number">
                        @error('cheque_number')<div class="text-danger small mt-1">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" class="btn-primary-custom w-100">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const paymentMethod = document.getElementById('paymentMethod');
    const cardFields = document.getElementById('cardFields');
    const chequeFields = document.getElementById('chequeFields');
    const cardNumber = document.getElementById('cardNumber');
    const cardExpiry = document.getElementById('cardExpiry');

    function updatePaymentFields() {
        const card = paymentMethod.value === 'Credit / Debit Card';
        const cheque = paymentMethod.value === 'Cheque';
        cardFields.classList.toggle('d-none', !card);
        chequeFields.classList.toggle('d-none', !cheque);
    }

    cardNumber?.addEventListener('input', function () {
        let digits = this.value.replace(/\D/g, '').slice(0, 16);
        this.value = digits.replace(/(.{4})/g, '$1 ').trim();
    });

    cardExpiry?.addEventListener('input', function () {
        let digits = this.value.replace(/\D/g, '').slice(0, 4);
        this.value = digits.length > 2 ? digits.slice(0, 2) + '/' + digits.slice(2) : digits;
    });

    paymentMethod.addEventListener('change', updatePaymentFields);
    updatePaymentFields();
});
</script>
@endsection
