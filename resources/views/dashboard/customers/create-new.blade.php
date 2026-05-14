@extends('layouts.master')

@section('title', __('Create Customer'))

@section('css')
<style>
    /* ── Application Form Styles ── */
    .app-form-wrapper {
        background: #2c2c1e;
        border-radius: 10px;
        padding: 0;
        overflow: hidden;
    }

    /* Dark header bar */
    .app-form-header {
        background: #2c2c1e;
        padding: 18px 24px 14px;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
    }

    .brand-block .brand-name {
        font-size: 28px;
        font-weight: 900;
        color: #4caf50;
        letter-spacing: 2px;
        line-height: 1;
        font-family: 'Arial Black', sans-serif;
    }

    .brand-block .brand-divider {
        display: flex;
        align-items: center;
        gap: 6px;
        color: #aaa;
        font-size: 10px;
        letter-spacing: 3px;
        margin: 2px 0;
    }

    .brand-block .brand-divider span { color: #4caf50; font-size: 12px; }

    .brand-block .brand-sub {
        color: #ccc;
        font-size: 11px;
        letter-spacing: 4px;
        font-style: italic;
    }

    .photo-box {
        width: 90px;
        height: 90px;
        background: #fff;
        border: 2px solid #ccc;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #888;
        gap: 4px;
        cursor: pointer;
        position: relative;
        overflow: hidden;
        border-radius: 4px;
    }

    .photo-box img { width: 100%; height: 100%; object-fit: cover; position: absolute; }
    .photo-box input[type="file"] { display: none; }

    .form-title-bar {
        background: linear-gradient(135deg, #3a3a2a 0%, #555540 100%);
        color: #fff;
        font-size: 17px;
        font-weight: 700;
        letter-spacing: 3px;
        padding: 10px 24px;
        text-transform: uppercase;
        border-left: 4px solid #4caf50;
    }

    /* White form body */
    .app-form-body {
        background: #f0f0e8;
        padding: 20px 24px 24px;
    }

    /* Intro text box */
    .intro-box {
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 16px;
        font-size: 12.5px;
        color: #222;
        line-height: 1.7;
    }

    .intro-box .inline-field {
        display: inline-block;
        border-bottom: 1px solid #333;
        min-width: 120px;
        height: 18px;
        vertical-align: bottom;
    }

    .intro-box strong { font-weight: 700; }

    /* Section label */
    .section-label {
        font-size: 12px;
        font-weight: 700;
        color: #1a1a1a;
        margin: 14px 0 6px;
        text-transform: uppercase;
        letter-spacing: .5px;
        border-bottom: 1.5px solid #888;
        padding-bottom: 3px;
    }

    /* Field rows */
    .field-group {
        display: flex;
        align-items: flex-end;
        gap: 8px;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }

    .field-item {
        display: flex;
        align-items: flex-end;
        gap: 5px;
        flex: 1;
        min-width: 0;
    }

    .field-item label {
        font-size: 12px;
        font-weight: 600;
        color: #1a1a1a;
        white-space: nowrap;
        flex-shrink: 0;
        margin-bottom: 0;
        padding-bottom: 3px;
    }

    .field-item .form-control {
        border: none;
        border-bottom: 1px solid #555;
        border-radius: 0;
        background: transparent;
        padding: 0 4px 2px;
        font-size: 12.5px;
        height: 26px;
        box-shadow: none;
        flex: 1;
    }

    .field-item .form-control:focus {
        background: rgba(76,175,80,.06);
        border-bottom-color: #4caf50;
        box-shadow: none;
        outline: none;
    }

    .field-item .form-control.is-invalid {
        border-bottom-color: #dc3545;
    }

    /* CNIC boxes */
    .cnic-boxes {
        display: flex;
        gap: 2px;
        align-items: flex-end;
    }

    .cnic-box {
        width: 20px;
        height: 22px;
        border: 1px solid #555;
        background: #fff;
        text-align: center;
        font-size: 11px;
        padding: 0;
    }

    .cnic-separator {
        font-size: 16px;
        font-weight: 700;
        color: #555;
        line-height: 22px;
        padding: 0 1px;
    }

    /* Checkbox occupation */
    .occupation-row {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 10px;
    }

    .occupation-row label { font-size: 12px; font-weight: 600; flex-shrink: 0; }

    .occ-option {
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
    }

    .occ-checkbox {
        width: 16px;
        height: 16px;
        border: 1px solid #555;
        background: #fff;
        appearance: none;
        cursor: pointer;
        flex-shrink: 0;
    }

    .occ-checkbox:checked { background: #4caf50; }

    /* Thumb + signature row */
    .bottom-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-end;
        margin-top: 20px;
        gap: 20px;
    }

    .thumb-box {
        border: 1px solid #999;
        width: 130px;
        height: 90px;
        background: #fff;
        display: flex;
        align-items: flex-end;
        justify-content: center;
        padding-bottom: 5px;
        font-size: 11px;
        color: #666;
        flex-shrink: 0;
    }

    .sig-block {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 4px;
    }

    .sig-line { width: 260px; border-top: 1px solid #333; }
    .sig-label { font-size: 11.5px; color: #333; }

    .nic-row-bottom {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-top: 8px;
    }

    .nic-row-bottom label { font-size: 12px; font-weight: 600; flex-shrink: 0; }

    /* Footer logos + address */
    .app-footer {
        background: #fff;
        border-top: 1px solid #ccc;
        padding: 12px 24px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .footer-logos { display: flex; gap: 10px; flex-shrink: 0; }

    .footer-logo-img {
        width: 48px;
        height: 48px;
        background: #eee;
        border: 1.5px dashed #aaa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 7px;
        color: #aaa;
        text-align: center;
    }

    .footer-address {
        flex: 1;
        font-size: 11px;
        color: #333;
        line-height: 1.6;
    }

    /* Submit button area */
    .submit-area {
        background: #2c2c1e;
        padding: 14px 24px;
        display: flex;
        gap: 10px;
    }

    /* Invalid feedback for bottom-border fields */
    .field-item .invalid-feedback { font-size: 10px; position: absolute; bottom: -16px; }
    .field-item { position: relative; }

    /* Select2 overrides */
    .select2-container--default .select2-selection--single {
        border: none;
        border-bottom: 1px solid #555;
        border-radius: 0;
        background: transparent;
        height: 26px;
    }

    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px;
        font-size: 12.5px;
        padding-left: 4px;
    }

    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 24px; }

    /* Top strip (partial from image) */
    .top-strip {
        background: #f0f0e8;
        padding: 6px 24px;
        display: flex;
        gap: 24px;
        font-size: 11.5px;
        color: #333;
        border-bottom: 1px solid #ccc;
    }

    .top-strip .ts-item {
        display: flex;
        align-items: flex-end;
        gap: 5px;
    }

    .top-strip .ts-item label { font-weight: 600; white-space: nowrap; font-size: 11.5px; margin: 0; }
    .top-strip .ts-line { border-bottom: 1px solid #555; width: 100px; height: 18px; }
</style>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Create') }}</li>
@endsection

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <form method="POST" action="{{ route('dashboard.customers.store') }}" enctype="multipart/form-data" id="customerForm">
        @csrf

        <div class="app-form-wrapper shadow-lg">
            <div class="top-strip">
                <div class="ts-item">
                    <label>Cash Amount Rs.</label>
                    <div class="ts-line"></div>
                </div>
                <div class="ts-item">
                    <label>Corner Charges Rs.</label>
                    <div class="ts-line"></div>
                </div>
                <div class="ts-item">
                    <label>100 Ft Road Facing Rs.</label>
                    <div class="ts-line"></div>
                </div>
                <div class="ts-item">
                    <label>West Open Rs.</label>
                    <div class="ts-line"></div>
                </div>
            </div>

            {{-- Dark header --}}
            <div class="app-form-header">
                <div class="brand-block">
                    <div class="brand-name">LAKHANI</div>
                    <div class="brand-divider">—<span>👑</span>—</div>
                    <div class="brand-sub">— IMPERIAL CITY —</div>
                </div>
                <div class="photo-box" onclick="document.getElementById('photoInput').click()">
                    <img id="photoPreview" src="" style="display:none;" alt="Photo">
                    <i class="bx bx-user" style="font-size:24px; color:#aaa;"></i>
                    <span>PHOTO</span>
                    <input type="file" id="photoInput" name="photo" accept="image/*"
                           onchange="previewPhoto(this)">
                </div>
            </div>

            {{-- Form title bar --}}
            <div class="form-title-bar">APPLICATION FORM</div>

            {{-- White body --}}
            <div class="app-form-body">

                {{-- Intro text --}}
                <div class="intro-box">
                    Dear Sir,<br>
                    I/We, the undersigned, request you to please register my/our name(s) for the allotment of plot /
                    No.<span class="inline-field" style="min-width:80px;"></span>
                    in your project <strong>LAKHANI IMPERIAL CITY</strong>, Located at M9, Motorway,
                    <select name="payment_basis" class="d-inline-block border-0 border-bottom"
                        style="background:transparent; font-size:12.5px; width:110px; outline:none;">
                        <option value="cash">on cash basis</option>
                        <option value="installment">on installment</option>
                    </select>
                    <br>
                    <strong>The following particulars are true to the best of my knowledge.</strong>
                </div>

                {{-- Personal Info --}}
                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Name Mr./Mrs./Miss:</label>
                        <input class="form-control @error('name') is-invalid @enderror"
                               type="text" name="name" value="{{ old('name') }}"
                               placeholder="Full name" required>
                        @error('name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Name of Father/Husband:</label>
                        <input class="form-control @error('father_husband_name') is-invalid @enderror"
                               type="text" name="father_husband_name" value="{{ old('father_husband_name') }}"
                               placeholder="" required>
                        @error('father_husband_name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Name of Spouse:</label>
                        <input class="form-control @error('spouse_name') is-invalid @enderror"
                               type="text" name="spouse_name" value="{{ old('spouse_name') }}"
                               placeholder="">
                        @error('spouse_name')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                {{-- NIC + NTN --}}
                <div class="field-group" style="gap:20px;">
                    <div class="field-item" style="flex:0 0 auto; gap:8px;">
                        <label>NIC #:</label>
                        <div class="cnic-boxes">
                            @for($i=0;$i<5;$i++)<input class="cnic-box" type="text" maxlength="1" name="cnic_d[]" inputmode="numeric">@endfor
                            <span class="cnic-separator">-</span>
                            @for($i=0;$i<7;$i++)<input class="cnic-box" type="text" maxlength="1" name="cnic_d[]" inputmode="numeric">@endfor
                            <span class="cnic-separator">-</span>
                            @for($i=0;$i<1;$i++)<input class="cnic-box" type="text" maxlength="1" name="cnic_d[]" inputmode="numeric">@endfor
                        </div>
                        <input type="hidden" name="cnic" id="cnicHidden" value="{{ old('cnic') }}">
                        @error('cnic')<span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:1;">
                        <label>NTN #:</label>
                        <input class="form-control @error('ntn') is-invalid @enderror"
                               type="text" name="ntn" value="{{ old('ntn') }}" placeholder="">
                        @error('ntn')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="field-item" style="flex:1;">
                        <label>Date of Birth:</label>
                        <input class="form-control @error('date_of_birth') is-invalid @enderror"
                               type="date" name="date_of_birth" value="{{ old('date_of_birth') }}">
                        @error('date_of_birth')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Current Residential Address:</label>
                        <input class="form-control @error('address') is-invalid @enderror"
                               type="text" name="address" value="{{ old('address') }}" placeholder="">
                        @error('address')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                {{-- Tel / Res / Mobile --}}
                <div class="field-group">
                    <div class="field-item">
                        <label>Tel. Off.:</label>
                        <input class="form-control" type="text" name="tel_office" value="{{ old('tel_office') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Res.:</label>
                        <input class="form-control" type="text" name="tel_res" value="{{ old('tel_res') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Mobile:</label>
                        <input class="form-control @error('phone') is-invalid @enderror"
                               type="text" name="phone" value="{{ old('phone') }}" placeholder="">
                        @error('phone')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                {{-- Fax + Email --}}
                <div class="field-group">
                    <div class="field-item">
                        <label>Fax #:</label>
                        <input class="form-control" type="text" name="fax" value="{{ old('fax') }}" placeholder="">
                    </div>
                    <div class="field-item" style="flex:2;">
                        <label>Email Address:</label>
                        <input class="form-control @error('email') is-invalid @enderror"
                               type="email" name="email" value="{{ old('email') }}" placeholder="">
                        @error('email')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                {{-- Occupation --}}
                <div class="occupation-row">
                    <label>Occupation:</label>
                    <label class="occ-option">
                        <input class="occ-checkbox" type="radio" name="occupation_type" value="business"
                               {{ old('occupation_type') == 'business' ? 'checked' : '' }}>
                        Business
                    </label>
                    <label class="occ-option">
                        <input class="occ-checkbox" type="radio" name="occupation_type" value="salaried"
                               {{ old('occupation_type') == 'salaried' ? 'checked' : '' }}>
                        Salaried
                    </label>
                </div>

                {{-- Business tel row --}}
                <div class="field-group">
                    <div class="field-item">
                        <label>Tel. Off.:</label>
                        <input class="form-control" type="text" name="biz_tel_office" value="{{ old('biz_tel_office') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Res.:</label>
                        <input class="form-control" type="text" name="biz_tel_res" value="{{ old('biz_tel_res') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Mobile:</label>
                        <input class="form-control" type="text" name="biz_mobile" value="{{ old('biz_mobile') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Nature of Business/Employment:</label>
                        <input class="form-control" type="text" name="nature_of_business" value="{{ old('nature_of_business') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Name of Company/Business:</label>
                        <input class="form-control" type="text" name="company_name" value="{{ old('company_name') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>Address:</label>
                        <input class="form-control" type="text" name="company_address" value="{{ old('company_address') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item">
                        <label>Nationality:</label>
                        <input class="form-control" type="text" name="nationality" value="{{ old('nationality', 'Pakistani') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Religion:</label>
                        <input class="form-control" type="text" name="religion" value="{{ old('religion') }}" placeholder="">
                    </div>
                </div>

                {{-- Nominee --}}
                <div class="field-group">
                    <div class="field-item">
                        <label>Name of Nominee:</label>
                        <input class="form-control @error('nominee') is-invalid @enderror"
                               type="text" name="nominee" value="{{ old('nominee') }}" placeholder="" required>
                        @error('nominee')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                    <div class="field-item">
                        <label>F/H's Name:</label>
                        <input class="form-control" type="text" name="nominee_father_name" value="{{ old('nominee_father_name') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group" style="gap:20px;">
                    <div class="field-item">
                        <label>Relationship:</label>
                        <input class="form-control" type="text" name="nominee_relationship" value="{{ old('nominee_relationship') }}" placeholder="">
                    </div>
                    <div class="field-item" style="flex:0 0 auto; gap:8px;">
                        <label>NIC #:</label>
                        <div class="cnic-boxes">
                            @for($i=0;$i<5;$i++)<input class="cnic-box" type="text" maxlength="1" name="nominee_cnic_d[]" inputmode="numeric">@endfor
                            <span class="cnic-separator">-</span>
                            @for($i=0;$i<7;$i++)<input class="cnic-box" type="text" maxlength="1" name="nominee_cnic_d[]" inputmode="numeric">@endfor
                            <span class="cnic-separator">-</span>
                            @for($i=0;$i<1;$i++)<input class="cnic-box" type="text" maxlength="1" name="nominee_cnic_d[]" inputmode="numeric">@endfor
                        </div>
                        <input type="hidden" name="nominee_cnic" id="nomineeCnicHidden" value="{{ old('nominee_cnic') }}">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item">
                        <label>Tel. Off.:</label>
                        <input class="form-control" type="text" name="nominee_tel" value="{{ old('nominee_tel') }}" placeholder="">
                    </div>
                    <div class="field-item">
                        <label>Mobile:</label>
                        <input class="form-control" type="text" name="nominee_mobile" value="{{ old('nominee_mobile') }}" placeholder="">
                    </div>
                </div>

                <div class="field-group">
                    <div class="field-item">
                        <label>Date:</label>
                        <input class="form-control" type="date" name="application_date" value="{{ old('application_date', date('Y-m-d')) }}">
                    </div>
                    <div class="field-item">
                        <label>Place:</label>
                        <input class="form-control" type="text" name="application_place" value="{{ old('application_place') }}" placeholder="">
                    </div>
                </div>

                {{-- Plot Selection --}}
                <div class="section-label mt-3">{{ __('Plot Details') }}</div>

                <div class="field-group">
                    <div class="field-item" style="flex:2;">
                        <label>{{ __('Select Plot') }}<span class="text-danger">*</span></label>
                        <select name="plot_id" class="form-control select2 @error('plot_id') is-invalid @enderror"
                            id="plot_id" required>
                            <option value="" selected disabled>{{ __('Select Plot') }}</option>
                            @foreach ($plots as $plot)
                                <option value="{{ $plot->id }}" data-price="{{ $plot->price }}"
                                    {{ old('plot_id') == $plot->id ? 'selected' : '' }}>
                                    {{ $plot->block.' - '.$plot->plot_no }} ( Rs. {{ number_format($plot->price, 2) }} )
                                </option>
                            @endforeach
                        </select>
                        @error('plot_id')<span class="invalid-feedback d-block"><strong>{{ $message }}</strong></span>@enderror
                    </div>
                </div>

                {{-- Plot File Details --}}
                <div id="plotFileDetails" style="display:none;">
                    <div class="field-group">
                        <div class="field-item">
                            <label>{{ __('File No.') }}<span class="text-danger">*</span></label>
                            <input class="form-control @error('file_no') is-invalid @enderror"
                                   type="text" name="file_no" value="{{ old('file_no') }}" placeholder="">
                            @error('file_no')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="field-item">
                            <label>{{ __('Booked By') }}</label>
                            <input class="form-control @error('booked_by') is-invalid @enderror"
                                   type="text" name="booked_by" value="{{ old('booked_by') }}" placeholder="">
                            @error('booked_by')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    <div class="field-group">
                        <div class="field-item">
                            <label>{{ __('Total Cost') }}<span class="text-danger">*</span></label>
                            <input class="form-control @error('total_cost') is-invalid @enderror"
                                   type="number" step="0.01" id="total_cost" name="total_cost"
                                   readonly value="{{ old('total_cost') }}" placeholder="">
                            @error('total_cost')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="field-item">
                            <label>{{ __('Discount') }}</label>
                            <input class="form-control @error('discount') is-invalid @enderror"
                                   type="number" step="0.01" id="discount" name="discount"
                                   value="{{ old('discount', 0) }}" placeholder="">
                            @error('discount')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                        <div class="field-item">
                            <label>{{ __('Remaining Amount') }}</label>
                            <input class="form-control @error('remaining_amount') is-invalid @enderror"
                                   type="number" step="0.01" id="remaining_amount" name="remaining_amount"
                                   readonly value="{{ old('remaining_amount', 0) }}" placeholder="">
                            @error('remaining_amount')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>

                    <div class="field-group">
                        <div class="field-item">
                            <label>{{ __('Booking Date') }}</label>
                            <input class="form-control @error('booking_date') is-invalid @enderror"
                                   type="date" id="booking_date" name="booking_date"
                                   value="{{ old('booking_date', date('Y-m-d')) }}">
                            @error('booking_date')<span class="invalid-feedback"><strong>{{ $message }}</strong></span>@enderror
                        </div>
                    </div>
                </div>

                {{-- Bottom: thumb + signature --}}
                <div class="bottom-row">
                    <div>
                        <div class="thumb-box">Thumb Impression</div>
                    </div>
                    <div class="sig-block">
                        <div class="sig-line"></div>
                        <div class="sig-label">Signature of the Applicant</div>
                        <div class="nic-row-bottom">
                            <label>NIC #:</label>
                            <div class="cnic-boxes">
                                @for($i=0;$i<5;$i++)<div class="cnic-box"></div>@endfor
                                <span class="cnic-separator">-</span>
                                @for($i=0;$i<7;$i++)<div class="cnic-box"></div>@endfor
                                <span class="cnic-separator">-</span>
                                <div class="cnic-box"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /app-form-body --}}

            {{-- Footer --}}
            <div class="app-footer">
                <div class="footer-logos">
                    <div class="footer-logo-img">LOGO</div>
                    <div class="footer-logo-img">LOGO</div>
                </div>
                <div class="footer-address">
                    4th floor, Syedda Chamber, SB-04, Main University Road,<br>
                    Block 13-C, Gulshan-e-Iqbal, Karachi, 75300.<br>
                    PH: +92 21 34820600 &nbsp; Email: lakhani.group@yahoo.com
                </div>
            </div>

            {{-- Submit --}}
            <div class="submit-area">
                <button type="submit" class="btn btn-success px-4">
                    <i class="bx bx-check me-1"></i> {{ __('Submit Application') }}
                </button>
                <a href="{{ route('dashboard.customers.index') }}" class="btn btn-outline-secondary px-4" style="color:#ccc; border-color:#666;">
                    {{ __('Cancel') }}
                </a>
            </div>

        </div>{{-- /app-form-wrapper --}}
    </form>
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {

    // Photo preview
    window.previewPhoto = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#photoPreview').attr('src', e.target.result).show();
                $(input).closest('.photo-box').find('i, span').hide();
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // CNIC box auto-advance
    function setupCnicBoxes(boxes, hiddenId) {
        boxes.each(function(i) {
            $(this).on('input', function() {
                if (this.value.length >= 1) {
                    var next = boxes.eq(i + 1);
                    if (next.length) next.focus();
                }
                // Assemble hidden CNIC
                var vals = [];
                boxes.each(function() { vals.push($(this).val() || ' '); });
                var joined = vals.join('');
                // Reformat: 5-7-1
                var d = joined.replace(/\s/g,'');
                if (d.length >= 13) {
                    $('#'+hiddenId).val(d.substring(0,5)+'-'+d.substring(5,12)+'-'+d.substring(12,13));
                }
            });
            $(this).on('keydown', function(e) {
                if (e.key === 'Backspace' && !this.value) {
                    boxes.eq(i - 1).focus();
                }
            });
        });
    }

    setupCnicBoxes($('input[name="cnic_d[]"]'), 'cnicHidden');
    setupCnicBoxes($('input[name="nominee_cnic_d[]"]'), 'nomineeCnicHidden');

    // Plot selection → show file details
    $('#plot_id').on('change', function () {
        var selected = $(this).find('option:selected');
        var price = selected.data('price');

        if ($(this).val()) {
            $('#plotFileDetails').slideDown('fast');
            $('#total_cost').val(price);
            calculateRemaining();
        } else {
            $('#plotFileDetails').slideUp('fast');
            $('#file_no, #booked_by').val('');
            $('#total_cost, #discount, #remaining_amount').val(0);
            $('#booking_date').val('');
        }
    });

    function calculateRemaining() {
        var total    = parseFloat($('#total_cost').val()) || 0;
        var discount = parseFloat($('#discount').val()) || 0;
        $('#remaining_amount').val((total - discount).toFixed(2));
    }

    $('#discount').on('input', calculateRemaining);

    // Restore on validation error
    @if(old('plot_id'))
        $('#plot_id').trigger('change');
        $('#file_no').val('{{ old('file_no') }}');
        $('#booked_by').val('{{ old('booked_by') }}');
        $('#discount').val('{{ old('discount', 0) }}');
        $('#booking_date').val('{{ old('booking_date', date('Y-m-d')) }}');

        // Restore CNIC boxes
        var cnic = '{{ old('cnic', '') }}'.replace(/-/g,'');
        $('input[name="cnic_d[]"]').each(function(i) {
            $(this).val(cnic[i] || '');
        });
    @endif
});
</script>
@endsection
