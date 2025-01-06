@extends('admin.default')

@section('Page-title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="text-primary mb-0"><i class="fas fa-credit-card"></i> Make Payment</h5>
        </div>

        <form id="paymentForm" action="{{ route('donor.payment') }}" method="POST">
            @csrf

            <input type="hidden" name="child_id" value="{{ $data->id }}">
            <!-- Amount Due -->
            <div class="mb-3">
                <label for="amount" class="form-label"><i class="fas fa-money-bill-wave"></i> Amount to be Paid</label>
                <input type="text" class="form-control" id="amount" name="amount" value="{{ $data->school->fees }}"
                    readonly>
            </div>

            <!-- Credit Card Number -->
            <div class="mb-3">
                <label for="cardNumber" class="form-label"><i class="fas fa-credit-card"></i> Credit Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber"
                    placeholder="1234 5678 9012 3456" maxlength="19" required>
            </div>

            <!-- Expiration Date -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="expiryMonth" class="form-label"><i class="far fa-calendar-alt"></i> Expiration
                        Month</label>
                    <input type="text" class="form-control" id="expiryMonth" name="expiryMonth" placeholder="MM"
                        maxlength="2" required>
                </div>
                <div class="col-md-6">
                    <label for="expiryYear" class="form-label"><i class="far fa-calendar-alt"></i> Expiration
                        Year</label>
                    <input type="text" class="form-control" id="expiryYear" name="expiryYear" placeholder="YY"
                        maxlength="2" required>
                </div>
            </div>

            <!-- CVC -->
            <div class="mb-3">
                <label for="cvc" class="form-label"><i class="fas fa-lock"></i> CVC</label>
                <input type="text" class="form-control" id="cvc" name="cvc" placeholder="123" maxlength="3" required>
            </div>

            <!-- Cardholder Name -->
            <div class="mb-3">
                <label for="cardHolderName" class="form-label"><i class="fas fa-user"></i> Cardholder Name</label>
                <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" placeholder="John Doe"
                    required>
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Pay Now</button>
            </div>
        </form>
    </div>
</div>


@endsection