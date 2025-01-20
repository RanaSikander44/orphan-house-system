@extends('admin.default')

@section('Page-title', 'Dashboard')

@section('content')

<!-- Include Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>


<div class="container-fluid px-4">
    <div class="card bg-white px-4 py-3 mt-4 border-0 shadow-sm rounded">
        <div class="d-flex justify-content-center align-items-center mb-4 w-100">
            <h5 class="text-primary mb-0">Make Payment</h5>
        </div>

        <form id="paymentForm" action="{{ route('donor.payment') }}" method="POST">
            @csrf

            <input type="hidden" name="child_id" value="{{ $data->id }}">

            <!-- Amount Due -->
            <div class="mb-3">
                <label for="amount" class="form-label"><i class="fas fa-money-bill-wave"></i> Amount to be Paid</label>
                <input type="text" class="form-control" id="amount" name="amount"
                    value="{{ $data->school->fees + $child_charges->charges_of_a_child }}" readonly>
                @error('amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Credit Card Number -->
            <div class="mb-3">
                <label for="cardNumber" class="form-label"><i class="fas fa-credit-card"></i> Credit Card Number</label>
                <input type="text" class="form-control" id="cardNumber" name="cardNumber"
                    placeholder="1234 5678 9012 3456" required>
                @error('cardNumber')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Expiration Date -->
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="expiryMonth" class="form-label"><i class="far fa-calendar-alt"></i> Expiration
                        Month</label>
                    <input type="text" class="form-control" id="expiryMonth" name="expiryMonth" placeholder="MM"
                        maxlength="2" required>
                    @error('expiryMonth')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="expiryYear" class="form-label"><i class="far fa-calendar-alt"></i> Expiration
                        Year</label>
                    <input type="text" class="form-control" id="expiryYear" name="expiryYear" placeholder="YY"
                        maxlength="2" required>
                    @error('expiryYear')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="col-md-6 mt-3">
                    <label for="cvc" class="form-label"><i class="fas fa-lock"></i> CVC</label>
                    <input type="text" class="form-control" id="cvc" name="cvc" placeholder="123" maxlength="3"
                        required>
                    @error('cvc')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Automatic Payment Schedule Section -->
                <div class="col-md-6 mt-3">
                    <label for="paymentSchedule" class="form-label">Automatic Payment Schedule</label>
                    <select name="paymentSchedule" id="paymentSchedule" class="form-control">
                        <option value="monthly">Monthly</option>
                        <option value="custom_date">Custom Date</option>
                    </select>

                    <!-- Display error message for invalid selection -->
                    @error('paymentSchedule')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Custom Date Fields Section -->
                <div class="col-md-6 mt-3" id="custom_date_fields" style="display: none;">
                    <div class="custom-date-info">
                        <h5>Custom Date Selection</h5>
                        <p class="text-muted">Choose your custom payment period below.</p>
                    </div>

                    <div class="row mt-2 mb-3">
                        <!-- Start Date -->
                        <div class="col-md-6">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="pay_start_date" class="form-control"
                                min="{{ date('Y-m-d') }}">

                            @error('pay_start_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- End Date -->
                        <div class="col-md-6">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="pay_end_date" class="form-control"   
                                min="{{ date('Y-m-d') }}">

                            @error('pay_end_date')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="payment_message"></div>
                    </div>
                </div>
            </div>

            <!-- Cardholder Name -->
            <div class="mb-3">
                <label for="cardHolderName" class="form-label"><i class="fas fa-user"></i> Cardholder Name</label>
                <input type="text" class="form-control" id="cardHolderName" name="cardHolderName" placeholder="John Doe"
                    required>
                @error('cardHolderName')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane"></i> Pay Now</button>
            </div>
        </form>
    </div>
</div>


<script>
    document.getElementById('paymentSchedule').addEventListener('change', function () {
        if (this.value === 'custom_date') {
            document.getElementById('custom_date_fields').style.display = 'block';
        } else {
            document.getElementById('custom_date_fields').style.display = 'none';
        }
    });

</script>


<script>
    document.getElementById('paymentSchedule').addEventListener('change', function () {
        const customDateFields = document.getElementById('custom_date_fields');
        const messageContainer = document.getElementById('payment_message');
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');

        if (this.value === 'custom_date') {
            customDateFields.style.display = 'block';
        } else {
            customDateFields.style.display = 'none';
            messageContainer.innerHTML = ''; // Clear the message
        }

        // Attach change listeners to calculate and show the message
        startDateInput.addEventListener('change', calculatePaymentSchedule);
        endDateInput.addEventListener('change', calculatePaymentSchedule);

        function calculatePaymentSchedule() {
            const startDate = new Date(startDateInput.value);
            const endDate = new Date(endDateInput.value);

            if (!isNaN(startDate) && !isNaN(endDate) && endDate > startDate) {
                // Calculate the difference in days
                const timeDiff = endDate - startDate;
                const totalDays = Math.ceil(timeDiff / (1000 * 60 * 60 * 24));

                // Convert days into months and years
                const totalMonths = Math.floor(totalDays / 30);
                const totalYears = Math.floor(totalMonths / 12);

                let durationMessage = `Total duration is ${totalDays} day(s).`;
                if (totalMonths > 0) {
                    durationMessage = `Total duration is ${totalMonths} month(s) and ${totalDays % 30} day(s).`;
                }
                if (totalYears > 0) {
                    durationMessage = `Total duration is ${totalYears} year(s), ${totalMonths % 12} month(s), and ${totalDays % 30} day(s).`;
                }

                // Calculate the next payment date
                const nextPaymentDate = new Date(startDate);
                nextPaymentDate.setDate(nextPaymentDate.getDate() + totalDays);

                const options = { year: 'numeric', month: 'long', day: 'numeric' };
                messageContainer.innerHTML = `
                    <div class="alert alert-info mt-3">
                        ${durationMessage}<br>
                        Your next amount will be automatically deducted from your card on 
                        <strong>${nextPaymentDate.toLocaleDateString(undefined, options)}</strong>.
                    </div>
                `;
            } else {
                messageContainer.innerHTML = `
                    <div class="alert alert-warning mt-3">
                        Please select a valid start and end date.
                    </div>
                `;
            }
        }
    });
</script>



@endsection