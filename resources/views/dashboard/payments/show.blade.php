@extends('layouts.master')

@section('title', __('Payment Receipt'))

@section('css')
    <style>
        .receipt-wrapper {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 30px 0;
        }

        .receipt-actions {
            display: flex;
            justify-content: flex-end;
            max-width: 820px;
            margin: 0 auto 12px;
            gap: 10px;
        }

        .receipt-card {
            background: #fff;
            width: 820px;
            border: 1px solid #bbb;
            box-shadow: 0 4px 24px rgba(0, 0, 0, 0.13);
            font-family: Arial, sans-serif;
        }

        /* ── HEADER ── */
        .receipt-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px 12px;
            border-bottom: 2.5px solid #000;
        }

        .logo-box {
            width: 74px;
            height: 74px;
            border: 2px solid #1a3c6e;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 4px;
        }

        .logo-star {
            font-size: 30px;
            color: #1a3c6e;
            line-height: 1;
        }

        .logo-text {
            font-size: 8px;
            font-weight: bold;
            color: #1a3c6e;
            text-align: center;
            line-height: 1.3;
            margin-top: 3px;
        }

        .center-section {
            text-align: center;
            flex: 1;
            padding: 0 16px;
        }

        .project-of {
            font-size: 10px;
            color: #555;
            margin-bottom: 2px;
        }

        .urdu-title {
            font-size: 34px;
            color: #1a3c6e;
            font-family: 'Times New Roman', serif;
            letter-spacing: 2px;
            line-height: 1.1;
        }

        .eng-title {
            font-size: 19px;
            font-weight: bold;
            color: #1a3c6e;
            letter-spacing: 3px;
            margin-top: 2px;
        }

        .scheme-subtitle {
            font-size: 11px;
            color: #666;
        }

        .original-box {
            text-align: center;
        }

        .original-label {
            font-size: 11px;
            font-weight: bold;
            color: #333;
            border: 1.5px solid #333;
            padding: 2px 10px;
            display: inline-block;
            letter-spacing: 1px;
        }

        .receipt-label {
            font-size: 14px;
            font-weight: bold;
            color: #333;
            border: 2px solid #333;
            padding: 5px 20px;
            display: inline-block;
            margin-top: 8px;
            letter-spacing: 3px;
        }

        /* ── INFO ROWS ── */
        .info-row {
            display: flex;
            align-items: center;
            padding: 7px 18px;
            border-bottom: 1px solid #ddd;
            gap: 18px;
        }

        .info-field {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
        }

        .info-field .lbl {
            font-size: 12px;
            font-weight: bold;
            color: #222;
            white-space: nowrap;
        }

        .info-field .val {
            font-size: 12px;
            font-weight: bold;
            color: #111;
            border-bottom: 1px solid #444;
            flex: 1;
            padding-bottom: 1px;
            min-width: 60px;
        }

        .name-row {
            display: flex;
            align-items: center;
            padding: 7px 18px;
            border-bottom: 1px solid #ddd;
            gap: 10px;
        }

        .name-row .lbl {
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .name-row .val {
            font-size: 13px;
            font-weight: bold;
            flex: 1;
            border-bottom: 1px solid #444;
            padding-bottom: 1px;
        }

        .name-row .contact-lbl {
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
        }

        .name-row .contact-val {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #444;
            min-width: 120px;
            padding-bottom: 1px;
        }

        .father-row {
            display: flex;
            align-items: center;
            padding: 7px 18px;
            border-bottom: 1px solid #ddd;
            gap: 10px;
        }

        .father-row .lbl {
            font-size: 12px;
            font-weight: bold;
            white-space: nowrap;
            min-width: 110px;
        }

        .father-row .val {
            font-size: 13px;
            font-weight: bold;
            flex: 1;
            border-bottom: 1px solid #444;
            padding-bottom: 1px;
        }

        .father-row .meta-group {
            display: flex;
            gap: 20px;
            align-items: flex-start;
        }

        .meta-item {
            text-align: center;
            min-width: 80px;
        }

        .meta-item .meta-lbl {
            font-size: 10px;
            color: #666;
            line-height: 1.2;
        }

        .meta-item .meta-val {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #444;
            padding-bottom: 1px;
        }

        /* ── PLOT ROW ── */
        .plot-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 7px 18px;
            border-bottom: 2.5px solid #000;
            gap: 20px;
            border: 1px solid #000;
            margin: 5px;
        }

        .plot-field {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .plot-field .lbl {
            font-size: 12px;
            font-weight: bold;
        }

        .plot-field .val {
            font-size: 12px;
            font-weight: bold;
            border-bottom: 1px solid #444;
            min-width: 40px;
            padding-bottom: 1px;
        }

        /* ── PAYMENT TABLE ── */
        .pay-table-header {
            display: flex;
            background: #1a3c6e;
            color: #fff;
        }

        .pay-table-header .th {
            padding: 8px 18px;
            font-size: 12px;
            font-weight: bold;
        }

        .pay-table-header .th-amount {
            margin-left: auto;
            padding: 8px 18px;
            font-size: 12px;
            font-weight: bold;
            min-width: 130px;
            text-align: right;
        }

        .pay-table-body .tr {
            display: flex;
            border-bottom: 1px solid #eee;
        }

        .pay-table-body .td {
            padding: 9px 18px;
            font-size: 12px;
            flex: 1;
        }

        .pay-table-body .td-amount {
            padding: 9px 18px;
            font-size: 12px;
            font-weight: bold;
            min-width: 130px;
            text-align: right;
        }

        /* ── PAYMENT MODE SECTION ── */
        .mode-section {
            display: flex;
            border-top: 2px solid #000;
        }

        .mode-left {
            flex: 1;
            padding: 12px 18px;
            border-right: 1px solid #ccc;
        }

        .mode-title {
            font-size: 13px;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid #333;
            margin-bottom: 8px;
            padding-bottom: 4px;
        }

        .mode-line {
            font-size: 11.5px;
            color: #222;
            line-height: 2;
        }

        .mode-right {
            width: 250px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 12px;
        }

        .total-box {
            border: 2px solid #333;
            padding: 10px 20px;
            text-align: center;
            width: 100%;
            height: 100%;
        }

        .total-label {
            font-size: 11px;
            color: #666;
        }

        .total-value {
            font-size: 16px;
            font-weight: bold;
            color: #1a3c6e;
        }

        /* ── WORDS ROW ── */
        .words-row {
            border-top: 1px solid #ccc;
            padding: 7px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 11px;
            background: #fafafa;
        }

        .words-row .words-lbl {
            font-weight: bold;
        }

        .words-row .words-val {
            font-style: italic;
            font-weight: bold;
        }

        .words-row .printed-by {
            font-size: 10px;
            color: #777;
        }

        @media print {
            .receipt-actions {
                display: none;
            }

            body {
                background: #fff !important;
            }

            .receipt-card {
                box-shadow: none;
                border: 1px solid #ccc;
            }
        }

        /* ===== QR CODE SECTION ===== */
        .qr-section {
            margin: 8px 0 5px;
            text-align: center;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            margin: 0 auto 3px;
            border: 1px solid #000;
            padding: 2px;
            display: block;
        }

        .qr-label {
            font-size: 9px;
            font-weight: bold;
            margin: 2px 0;
        }

        .qr-url {
            font-size: 8px;
            color: #000;
            word-break: break-all;
            margin: 1px 0;
        }

        .payment-mode{
            display: flex;
            justify-content: space-between
        }
    </style>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.payments.index') }}">{{ __('Payments') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Payment Details') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <div class="receipt-actions">
            <a href="{{ route('dashboard.payments.index') }}" class="btn btn-secondary btn-sm">
                <i class="ti ti-arrow-left me-1"></i>{{ __('Back') }}
            </a>
            <button onclick="printReceipt()" class="btn btn-primary btn-sm">
                <i class="ti ti-printer me-1"></i>{{ __('Print Receipt') }}
            </button>
        </div>

        <div class="receipt-wrapper" id="receipt-container">
            <div class="receipt-card">

                {{-- ── HEADER ── --}}
                <div class="receipt-header">
                    <div class="logo-section">
                        {{-- <div class="logo-box">
                            <div class="logo-star">★</div>
                            <div class="logo-text">SHINE STAR<br>Builder &amp; Developer</div>
                        </div> --}}
                        <img height="40px" src="{{ asset(\App\Helpers\Helper::getLogoDark()) }}" alt="{{ env('APP_NAME') }}">
                    </div>

                    <div class="center-section">
                        <div class="project-of">The project of</div>
                        <div class="urdu-title">گلشن بهولاری</div>
                        <div class="eng-title">GULSHAN-E-BHOLARI</div>
                        <div class="scheme-subtitle">Housing Scheme</div>
                    </div>

                    <div class="original-box">
                        <div class="original-label">ORIGINAL</div><br>
                        <div class="receipt-label">RECEIPT</div>
                    </div>
                </div>

                {{-- ── RECEIPT NO / FILE NO / DATE ── --}}
                <div class="info-row">
                    <div class="info-field">
                        <span class="lbl">Receipt No:</span>
                        <span class="val">{{ $payment->id }}</span>
                    </div>
                    <div class="info-field">
                        <span class="lbl">File No:</span>
                        <span class="val">{{ $payment->customerPlotFile->file_no ?? 'N/A' }}</span>
                    </div>
                    <div class="info-field" style="flex:0.6;">
                        <span class="lbl">Date:</span>
                        <span class="val">{{ \Carbon\Carbon::parse($payment->payment_date)->format('d-M-Y') }}</span>
                    </div>
                </div>

                {{-- ── CUSTOMER NAME / CONTACT ── --}}
                <div class="name-row">
                    <span class="lbl">Mr./Mrs./Ms.:</span>
                    <span class="val">{{ strtoupper($payment->customerPlotFile->customer->name ?? 'N/A') }}</span>
                    <span class="contact-lbl">Contact:</span>
                    <span class="contact-val">{{ $payment->customerPlotFile->customer->phone ?? 'N/A' }}</span>
                </div>

                {{-- ── FATHER NAME / REC BY / BOOK BY ── --}}
                <div class="father-row">
                    <span class="lbl">S/o./D/o./W/o.:</span>
                    <span
                        class="val">{{ strtoupper($payment->customerPlotFile->customer->father_husband_name ?? 'N/A') }}</span>
                    <div class="meta-group">
                        <div class="meta-item">
                            <div class="meta-lbl">Rec By</div>
                            <div class="meta-val">{{ $payment->received_by ?? 'N/A' }}</div>
                        </div>
                        <div class="meta-item">
                            <div class="meta-lbl">Book By</div>
                            <div class="meta-val">{{ $payment->customerPlotFile->booked_by ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>

                {{-- ── PLOT INFO ── --}}
                <div class="plot-row">
                    <div class="plot-field">
                        <span class="lbl">Block:</span>
                        <span class="val">{{ $payment->customerPlotFile->projectPlot->block ?? 'N/A' }}</span>
                    </div>
                    <div class="plot-field">
                        <span class="lbl">Plot No:</span>
                        <span class="val">{{ $payment->customerPlotFile->projectPlot->plot_no ?? 'N/A' }}</span>
                    </div>
                    <div class="plot-field">
                        <span class="lbl">Size:</span>
                        <span class="val">{{ $payment->customerPlotFile->projectPlot->size ?? 'N/A' }}</span>
                    </div>
                    <div class="plot-field">
                        <span class="lbl">Category:</span>
                        <span class="val"
                            style="text-transform:capitalize;">{{ ucfirst($payment->customerPlotFile->projectPlot->category ?? 'N/A') }}</span>
                    </div>
                </div>

                {{-- ── PAYMENT TABLE ── --}}
                <div class="pay-table-header">
                    <div class="th" style="flex:1;">Payment Description</div>
                    <div class="th-amount">Amount</div>
                </div>
                <div class="pay-table-body">
                    <div class="tr">
                        <div class="td" style="flex:1;">{{ ucfirst($payment->payment_type) }}</div>
                        <div class="td-amount">{{ \App\Helpers\Helper::formatCurrency($payment->amount) }}</div>
                    </div>
                </div>

                {{-- ── MODE OF PAYMENT ── --}}
                <div class="mode-section">
                    <div class="mode-left">
                        <div class="mode-title">Mode of Payment</div>
                        <div class="payment-mode">
                            <div>
                                @if ($payment->payment_method === 'cash')
                                    <div class="mode-line"><strong>Cash</strong></div>
                                @elseif($payment->payment_method === 'cheque')
                                    <div class="mode-line"><strong>Cheque</strong></div>
                                    @if ($payment->bank_name)
                                        <div class="mode-line"><strong>Bank:</strong> {{ $payment->bank_name }}</div>
                                    @endif
                                    @if ($payment->bank_branch)
                                        <div class="mode-line"><strong>Branch:</strong> {{ $payment->bank_branch }}</div>
                                    @endif
                                    @if ($payment->cheque_no)
                                        <div class="mode-line"><strong>Cheque No:</strong> {{ $payment->cheque_no }}</div>
                                    @endif
                                @elseif($payment->payment_method === 'bank_transfer')
                                    <div class="mode-line"><strong>Bank Transfer</strong> &nbsp;<strong
                                            style="font-size:15px;">ONLINE</strong></div>
                                    @if ($payment->bank_name)
                                        <div class="mode-line"><strong>Bank:</strong> {{ $payment->bank_name }}</div>
                                    @endif
                                    @if ($payment->bank_branch)
                                        <div class="mode-line"><strong>Branch:</strong> {{ $payment->bank_branch }}</div>
                                    @endif
                                    <div class="mode-line"><strong>Date:</strong>
                                        {{ \Carbon\Carbon::parse($payment->payment_date)->format('d-m-Y') }}</div>
                                    @if ($payment->ref_no)
                                        <div class="mode-line"><strong>Reference No:</strong> {{ $payment->ref_no }}</div>
                                    @endif
                                @endif
                                @if ($payment->remarks)
                                    <div class="mode-line" style="margin-top:4px;"><strong>Remarks:</strong>
                                        {{ $payment->remarks }}</div>
                                @endif
                            </div>
                            <div>
                                <div class="qr-section">
                                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=80x80&data={{ urlencode(route('frontend.payment.verify', $payment->id ?? '00000')) }}&margin=0&ecc=H"
                                        alt="Verify Bill" class="qr-code">
                                    <div class="qr-label">SCAN TO VERIFY</div>
                                    {{-- <div class="qr-url blade-placeholder">
                                        {{ route('frontend.payment.verify', $payment->id ?? '00000') }}</div> --}}
                                    {{-- <div class="qr-label" style="font-weight:normal">Authenticity Check</div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mode-right">
                        <div class="total-box">
                            <div class="total-label">Total:</div>
                            <div class="total-value">{{ \App\Helpers\Helper::formatCurrency($payment->amount) }}</div>
                        </div>
                        <div class="total-box">
                        </div>
                    </div>
                </div>

                {{-- ── AMOUNT IN WORDS ── --}}
                <div class="words-row">
                    <span class="words-lbl">Amount in Words:</span>
                    <span class="words-val">
                        {{-- Pass $amountInWords from controller or use a helper --}}
                        {{ \App\Helpers\Helper::numberToWords($payment->amount ?? 0) }}
                    </span>
                    <span class="printed-by">
                        Printed By/Date: {{ auth()->user()->name ?? 'System' }} / {{ now()->format('Y/m-d H:i:s') }}
                    </span>
                </div>

            </div>{{-- end .receipt-card --}}
        </div>{{-- end .receipt-wrapper --}}

    </div>
@endsection

@section('script')
    <script>
    function printReceipt() {

        let printContents = document.getElementById('receipt-container').innerHTML;

        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();
    }
</script>
@endsection
