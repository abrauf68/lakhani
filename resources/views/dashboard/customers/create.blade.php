@extends('layouts.master')

@section('title', __('Create Customer'))

@section('css')
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.customers.store') }}" enctype="multipart/form-data" id="customerForm">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Customer') }}</h3>
                        
                        <!-- Customer Basic Information -->
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}"
                                value="{{ old('name') }}" />
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-6">
                            <label for="father_husband_name" class="form-label">{{ __('S/o.D/o.W/o') }}</label><span class="text-danger">*</span>
                            <input class="form-control @error('father_husband_name') is-invalid @enderror" type="text" id="father_husband_name"
                                name="father_husband_name" required placeholder="{{ __('Enter S/o.D/o.W/o') }}"
                                value="{{ old('father_husband_name') }}" />
                            @error('father_husband_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-6">
                            <label for="cnic" class="form-label">{{ __('CNIC') }}</label><span class="text-danger">*</span>
                            <input class="form-control @error('cnic') is-invalid @enderror" type="text" id="cnic"
                                name="cnic" required placeholder="{{ __('XXXXX-XXXXXXX-X') }}"
                                value="{{ old('cnic') }}" />
                            @error('cnic')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-6">
                            <label for="nominee" class="form-label">{{ __('Nominee') }}</label><span class="text-danger">*</span>
                            <input class="form-control @error('nominee') is-invalid @enderror" type="text" id="nominee"
                                name="nominee" required placeholder="{{ __('Enter nominee name') }}"
                                value="{{ old('nominee') }}" />
                            @error('nominee')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-6">
                            <label for="email" class="form-label">{{ __('Customer Email') }}</label>
                            <input class="form-control @error('email') is-invalid @enderror" type="email" id="email"
                                name="email" placeholder="{{ __('Enter customer email') }}"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-6">
                            <label for="phone" class="form-label">{{ __('Customer Phone') }}</label>
                            <input class="form-control @error('phone') is-invalid @enderror" type="text" id="phone"
                                name="phone" placeholder="{{ __('Enter customer phone') }}"
                                value="{{ old('phone') }}" />
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mb-4 col-md-12">
                            <label for="address" class="form-label">{{ __('Customer Address') }}</label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" id="address"
                                name="address" placeholder="{{ __('Enter customer address') }}"
                                value="{{ old('address') }}" />
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Plot Selection -->
                        <h6 class="mt-3">{{ __('Plot Details') }}</h6>
                        <hr>
                        
                        <div class="mb-4 col-md-6">
                            <label for="plot_id" class="form-label">{{ __('Select Plot') }}</label><span class="text-danger">*</span>
                            <select name="plot_id" class="form-select select2 @error('plot_id') is-invalid @enderror"
                                id="plot_id" required>
                                <option value="" selected disabled>{{ __('Select Plot') }}</option>
                                @foreach ($plots as $plot)
                                    <option value="{{ $plot->id }}" data-price="{{ $plot->price }}">
                                        {{ $plot->block.' - '.$plot->plot_no }} ( Rs. {{ number_format($plot->price, 2) }} )
                                    </option>
                                @endforeach
                            </select>
                            @error('plot_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <!-- Plot File Details Fields (Initially Hidden) -->
                        <div id="plotFileDetails" style="display: none;" class="row">
                            <div class="mb-4 col-md-6">
                                <label for="file_no" class="form-label">{{ __('File No.') }}</label><span class="text-danger">*</span>
                                <input class="form-control @error('file_no') is-invalid @enderror" type="text" id="file_no"
                                    name="file_no" placeholder="{{ __('Enter file number') }}"
                                    value="{{ old('file_no') }}" />
                                @error('file_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 col-md-6">
                                <label for="booked_by" class="form-label">{{ __('Booked By') }}</label>
                                <input class="form-control @error('booked_by') is-invalid @enderror" type="text" id="booked_by"
                                    name="booked_by" placeholder="{{ __('Enter booked by name') }}"
                                    value="{{ old('booked_by') }}" />
                                @error('booked_by')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 col-md-6">
                                <label for="total_cost" class="form-label">{{ __('Total Cost') }}</label><span class="text-danger">*</span>
                                <input class="form-control @error('total_cost') is-invalid @enderror" type="number" step="0.01" id="total_cost"
                                    name="total_cost" readonly placeholder="{{ __('Total cost will be auto-filled') }}"
                                    value="{{ old('total_cost') }}" />
                                @error('total_cost')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 col-md-6">
                                <label for="discount" class="form-label">{{ __('Discount') }}</label>
                                <input class="form-control @error('discount') is-invalid @enderror" type="number" step="0.01" id="discount"
                                    name="discount" placeholder="{{ __('Enter discount amount') }}"
                                    value="{{ old('discount', 0) }}" />
                                @error('discount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 col-md-6">
                                <label for="remaining_amount" class="form-label">{{ __('Remaining Amount') }}</label>
                                <input class="form-control @error('remaining_amount') is-invalid @enderror" type="number" step="0.01" id="remaining_amount"
                                    name="remaining_amount" readonly placeholder="{{ __('Remaining amount will be auto-calculated') }}"
                                    value="{{ old('remaining_amount', 0) }}" />
                                @error('remaining_amount')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            
                            <div class="mb-4 col-md-6">
                                <label for="booking_date" class="form-label">{{ __('Booking Date') }}</label>
                                <input class="form-control @error('booking_date') is-invalid @enderror" type="date" id="booking_date"
                                    name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}" />
                                @error('booking_date')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Customer') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        
        // When plot is selected, show file details and autofill total cost
        $('#plot_id').on('change', function() {
            var selectedOption = $(this).find('option:selected');
            var plotPrice = selectedOption.data('price');
            
            if ($(this).val()) {
                // Show the plot file details section
                $('#plotFileDetails').slideDown('fast');
                
                // Autofill total cost with plot price
                $('#total_cost').val(plotPrice);
                
                // Calculate remaining amount
                calculateRemainingAmount();
            } else {
                // Hide the plot file details section if no plot selected
                $('#plotFileDetails').slideUp('fast');
                
                // Clear all plot file detail fields
                $('#file_no').val('');
                $('#booked_by').val('');
                $('#total_cost').val('');
                $('#discount').val(0);
                $('#paid_amount').val(0);
                $('#remaining_amount').val(0);
                $('#booking_date').val('');
                $('#status').val('booked');
            }
        });
        
        // Calculate remaining amount when discount or paid amount changes
        function calculateRemainingAmount() {
            var totalCost = parseFloat($('#total_cost').val()) || 0;
            var discount = parseFloat($('#discount').val()) || 0;
            var paidAmount = parseFloat($('#paid_amount').val()) || 0;
            
            var netAmount = totalCost - discount;
            var remainingAmount = netAmount - paidAmount;
            
            $('#remaining_amount').val(remainingAmount.toFixed(2));
        }
        
        // Listen for changes on discount and paid_amount
        $('#discount, #paid_amount').on('input', function() {
            calculateRemainingAmount();
        });
        
        // If plot was previously selected (e.g., after form validation error), show details
        @if(old('plot_id'))
            $('#plot_id').trigger('change');
            $('#file_no').val('{{ old('file_no') }}');
            $('#booked_by').val('{{ old('booked_by') }}');
            $('#discount').val('{{ old('discount', 0) }}');
            $('#paid_amount').val('{{ old('paid_amount', 0) }}');
            $('#booking_date').val('{{ old('booking_date', date('Y-m-d')) }}');
            $('#status').val('{{ old('status', 'booked') }}');
        @endif
    });
</script>
@endsection