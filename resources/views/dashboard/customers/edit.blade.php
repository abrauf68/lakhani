@extends('layouts.master')

@section('title', __('Edit Customer'))

@section('css')
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card mb-6">
            <div class="card-body pt-4">
                <form method="POST" action="{{ route('dashboard.customers.update', $customer->id) }}" enctype="multipart/form-data" id="customerForm">
                    @csrf
                    @method('PUT')

                    <div class="row p-5">
                        <h3>{{ __('Edit Customer') }}</h3>
                        
                        <!-- Customer Basic Information -->
                        <div class="mb-4 col-md-6">
                            <label for="name" class="form-label">{{ __('Name') }}</label><span class="text-danger">*</span>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" id="name"
                                name="name" required placeholder="{{ __('Enter name') }}"
                                value="{{ old('name', $customer->name) }}" />
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
                                value="{{ old('father_husband_name', $customer->father_husband_name) }}" />
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
                                value="{{ old('cnic', $customer->cnic) }}" />
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
                                value="{{ old('nominee', $customer->nominee) }}" />
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
                                value="{{ old('email', $customer->email) }}" />
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
                                value="{{ old('phone', $customer->phone) }}" />
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
                                value="{{ old('address', $customer->address) }}" />
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-3">{{ __('Edit Customer') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
</script>
@endsection