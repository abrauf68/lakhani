@extends('layouts.master')

@section('title', __('Create Payment'))

@section('css')
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.payments.index') }}">{{ __('Payments') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <!-- Account -->
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.payments.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row p-5">
                        <h3>{{ __('Add New Payment') }}</h3>

                        <div class="mb-4 col-md-12">
                            <label for="customer_plot_file_id" class="form-label">{{ __('Customer Plot File') }}</label><span
                                class="text-danger">*</span>
                            <select name="customer_plot_file_id" class="form-select select2 @error('customer_plot_file_id') is-invalid @enderror"
                                id="customer_plot_file_id" required>
                                <option value="" selected disabled>Select Customer Plot File</option>
                                @foreach ($customerPlotFiles as $file)
                                    <option value="{{ $file->id }}" data-remaining="{{ $file->remaining_amount }}">
                                        {{ $file->file_no }} - {{ $file->customer->name }} ({{ $file->customer->cnic }}) - Plot {{ $file->projectPlot->block }}-{{ $file->projectPlot->plot_no }}
                                    </option>
                                @endforeach
                            </select>
                            @error('customer_plot_file_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label">Remaining Amount</label>
                            <input type="text" id="remaining_amount" class="form-control" readonly>
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label">Amount</label><span class="text-danger">*</span>
                            <input type="number" step="0.01" name="amount" id="amount"
                                class="form-control @error('amount') is-invalid @enderror" required>

                            @error('amount')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="ref_no" class="form-label">{{ __('Ref. No') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('ref_no') is-invalid @enderror" type="text" id="ref_no"
                                name="ref_no" required placeholder="{{ __('Enter reference number') }}"
                                value="{{ old('ref_no') }}" />
                            @error('ref_no')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label for="received_by" class="form-label">{{ __('Received By') }}</label><span
                                class="text-danger">*</span>
                            <input class="form-control @error('received_by') is-invalid @enderror" type="text" id="received_by"
                                name="received_by" required placeholder="{{ __('Enter received by') }}"
                                value="{{ old('received_by', auth()->user()->name) }}" />
                            @error('received_by')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label">Payment Date</label><span class="text-danger">*</span>
                            <input type="date" name="payment_date"
                                class="form-control @error('payment_date') is-invalid @enderror"
                                value="{{ old('payment_date', date('Y-m-d')) }}" required>

                            @error('payment_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4 col-md-6">
                            <label class="form-label">Payment Method</label><span class="text-danger">*</span>
                            <select name="payment_method" id="payment_method"
                                class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="">Select Method</option>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                            </select>

                            @error('payment_method')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Cheque Fields Container -->
                        <div class="col-md-12" id="cheque_container" style="display: none;">
                            <div class="row">
                                <div class="mb-4 col-md-6">
                                    <label for="cheque_no" class="form-label">{{ __('Cheque Number') }}</label><span class="text-danger">*</span>
                                    <input class="form-control @error('cheque_no') is-invalid @enderror" type="text" id="cheque_no"
                                        name="cheque_no" placeholder="{{ __('Enter cheque number') }}"
                                        value="{{ old('cheque_no') }}" />
                                    @error('cheque_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Bank Transfer Fields Container -->
                        <div class="col-md-12" id="bank_container" style="display: none;">
                            <div class="row">
                                <div class="mb-4 col-md-4">
                                    <label for="bank_name" class="form-label">{{ __('Bank Name') }}</label><span class="text-danger">*</span>
                                    <input class="form-control @error('bank_name') is-invalid @enderror" type="text" id="bank_name"
                                        name="bank_name" placeholder="{{ __('Enter bank name') }}"
                                        value="{{ old('bank_name') }}" />
                                    @error('bank_name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-4">
                                    <label for="bank_branch" class="form-label">{{ __('Bank Branch (Optional)') }}</label>
                                    <input class="form-control @error('bank_branch') is-invalid @enderror" type="text" id="bank_branch"
                                        name="bank_branch" placeholder="{{ __('Enter bank branch') }}"
                                        value="{{ old('bank_branch') }}" />
                                    @error('bank_branch')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4 col-md-4">
                                    <label for="cheque_no_bank" class="form-label">{{ __('Cheque Number (Optional)') }}</label>
                                    <input class="form-control @error('cheque_no') is-invalid @enderror" type="text" id="cheque_no_bank"
                                        name="cheque_no" placeholder="{{ __('Enter cheque number if any') }}"
                                        value="{{ old('cheque_no') }}" />
                                    @error('cheque_no')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-4 col-md-12">
                            <label for="remarks" class="form-label">{{ __('Remarks') }}</label>
                            <textarea class="form-control @error('remarks') is-invalid @enderror" id="remarks"
                                name="remarks" rows="3" placeholder="{{ __('Enter remarks (optional)') }}">{{ old('remarks') }}</textarea>
                            @error('remarks')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Add Payment') }}</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            console.log('Document ready - Script loaded');

            // Handle billing selection
            $('#customer_plot_file_id').on('change', function() {
                let remaining = $(this).find(':selected').data('remaining');
                console.log('Remaining amount:', remaining);
                $('#remaining_amount').val(remaining);
                $('#amount').val(remaining);
            });

            // Handle payment method change
            function togglePaymentFields() {
                let paymentMethod = $('#payment_method').val();
                console.log('Toggling fields for payment method:', paymentMethod);

                // Hide all conditional fields first
                $('#cheque_container').hide();
                $('#bank_container').hide();

                // Remove required attributes
                $('#cheque_no').removeAttr('required');
                $('#bank_name').removeAttr('required');
                // $('#bank_branch').removeAttr('required');
                $('#cheque_no_bank').removeAttr('required');

                // Show relevant fields based on selection
                if (paymentMethod === 'cheque') {
                    console.log('Showing cheque fields');
                    $('#cheque_container').show();
                    $('#cheque_no').attr('required', true);
                } else if (paymentMethod === 'bank_transfer') {
                    console.log('Showing bank transfer fields');
                    $('#bank_container').show();
                    $('#bank_name').attr('required', true);
                    // $('#bank_branch').attr('required', true);
                } else {
                    console.log('No extra fields for:', paymentMethod);
                }
            }

            // Trigger on page load for old values
            setTimeout(function() {
                togglePaymentFields();
            }, 100);

            // Trigger on change
            $('#payment_method').on('change', function() {
                console.log('Payment method changed to:', $(this).val());
                togglePaymentFields();
            });
        });
    </script>
@endsection
