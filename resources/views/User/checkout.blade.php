@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 90vh;">
    <div class="card shadow-lg p-4 rounded-4" style="width: 100%; max-width: 500px;">
        <h3 class="text-center mb-4">Secure Payment Checkout</h3>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('make.payment') }}">
            @csrf
            <input type="hidden" name="amount" value="{{ $amount }}">

            <div class="mb-3">
                <label class="form-label"> Card Type</label>
                <select name="card_type" class="form-select" required>
                    <option value="VISA">VISA</option>
                    <option value="MasterCard">MasterCard</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label"> Card Holder Name</label>
                <input type="text" name="card_holder_name" class="form-control" required placeholder="Full Name">
            </div>

            <div class="mb-3">
                <label class="form-label"> Card Number</label>
                <input type="text" name="card_number" class="form-control" >
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label class="form-label"> Expiry Month</label>
                    <input type="text" name="expiryMonth" class="form-control" required placeholder="MM">
                </div>
                <div class="col">
                    <label class="form-label"> Expiry Year</label>
                    <input type="text" name="expiryYear" class="form-control" required placeholder="YYYY">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label"> CVV</label>
                <input type="text" name="cvv" class="form-control" required placeholder="e.g. 123">
            </div>

            <button type="submit" class="btn btn-success w-100 py-2 fw-semibold">
                 Pay {{ $amount }} TK
            </button>
        </form>
    </div>
</div>
@endsection

