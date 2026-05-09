<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plot Record — {{ $customerPlotFile->file_no ?? 'N/A' }} | {{ $project->name ?? '' }} | {{ \App\Helpers\Helper::getCompanyName() }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Raleway', Arial, sans-serif;
            background: #ffffff;
            color: #0f0f0f;
            min-height: 100vh;
            padding: 28px 24px 32px;
            position: relative;
            overflow-x: hidden;
        }

        /* ─── WATERMARK ─── */
        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-32deg);
            font-family: 'Raleway', Arial, sans-serif;
            font-size: clamp(80px, 16vw, 150px);
            font-weight: 900;
            color: #1a6b3a;
            opacity: 0.09;
            letter-spacing: 0.12em;
            white-space: nowrap;
            pointer-events: none;
            user-select: none;
            text-transform: uppercase;
            z-index: 0;
        }

        /* ─── WRAPPER ─── */
        .wrapper {
            max-width: 860px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }

        /* ─── TOP BAR ─── */
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            margin-bottom: 7px;
        }

        .org-name {
            font-size: 12px;
            font-weight: 900;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #0f0f0f;
        }

        .org-sub {
            font-size: 8.5px;
            font-weight: 500;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: #666;
            margin-top: 2px;
        }

        .scheme-name {
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #0f0f0f;
            text-align: right;
        }

        .scheme-sub {
            font-size: 8px;
            font-weight: 500;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #888;
            margin-top: 2px;
            text-align: right;
        }

        /* ─── RULES ─── */
        .rule-bold { width: 100%; height: 3px; background: #0f0f0f; }
        .rule-thin  { width: 100%; height: 1px; background: #d0d0d0; margin-top: 2px; margin-bottom: 16px; }

        /* ─── HERO ─── */
        .hero {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 14px;
            border-bottom: 1px solid #e0e0e0;
            margin-bottom: 14px;
        }

        .file-label {
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: #888;
            margin-bottom: 2px;
        }

        .file-number {
            font-size: 44px;
            font-weight: 900;
            letter-spacing: 0.03em;
            color: #0f0f0f;
            line-height: 1;
        }

        .hero-right {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 7px;
        }

        .status-badge {
            display: inline-block;
            background: #0f0f0f;
            color: #ffffff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            padding: 6px 16px;
        }

        .plot-meta {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: #555;
            text-align: right;
            line-height: 1.75;
        }

        /* ─── TWO-COLUMN INFO ─── */
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            border: 1px solid #e0e0e0;
            margin-bottom: 14px;
        }

        .info-panel { padding: 16px 18px; }
        .info-panel + .info-panel { border-left: 1px solid #e0e0e0; }

        .panel-title {
            font-size: 8px;
            font-weight: 900;
            letter-spacing: 0.34em;
            text-transform: uppercase;
            color: #0f0f0f;
            border-bottom: 2px solid #0f0f0f;
            padding-bottom: 8px;
            margin-bottom: 13px;
        }

        .field { margin-bottom: 10px; }
        .field:last-child { margin-bottom: 0; }

        .field-label {
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.26em;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 2px;
        }

        .field-value {
            font-size: 13px;
            font-weight: 600;
            color: #0f0f0f;
            line-height: 1.35;
        }

        .field-value.sm {
            font-size: 12px;
            font-weight: 500;
            color: #222;
            line-height: 1.5;
        }

        .field-value.mono {
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.07em;
        }

        .tag-row { display: flex; gap: 5px; flex-wrap: wrap; margin-top: 3px; }

        .tag {
            border: 1px solid #c0c0c0;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            padding: 3px 8px;
            color: #444;
        }

        /* ─── FINANCIAL STRIP ─── */
        .fin-strip {
            border: 1px solid #e0e0e0;
            border-top: 3px solid #0f0f0f;
            margin-bottom: 14px;
        }

        .fin-header {
            padding: 8px 18px;
            font-size: 8px;
            font-weight: 900;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: #0f0f0f;
            border-bottom: 1px solid #e0e0e0;
            background: #f6f6f6;
        }

        .fin-cells {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
        }

        .fin-cell {
            padding: 14px 18px;
            border-right: 1px solid #e0e0e0;
        }

        .fin-cell:last-child { border-right: none; }

        .fin-cell-label {
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #999;
            margin-bottom: 5px;
        }

        .fin-cell-value {
            font-size: 19px;
            font-weight: 900;
            color: #0f0f0f;
            line-height: 1;
            letter-spacing: -0.01em;
        }

        .fin-cell.col-balance { background: #0f0f0f; }
        .fin-cell.col-balance .fin-cell-label { color: #aaa; }
        .fin-cell.col-balance .fin-cell-value { color: #fff; }

        /* ─── TRANSACTION TABLE ─── */
        .txn-header {
            font-size: 8px;
            font-weight: 900;
            letter-spacing: 0.32em;
            text-transform: uppercase;
            color: #0f0f0f;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .txn-header::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        table.txn {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #e0e0e0;
        }

        table.txn thead tr { background: #0f0f0f; }

        table.txn thead th {
            padding: 9px 12px;
            text-align: left;
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.24em;
            text-transform: uppercase;
            color: #cccccc;
            white-space: nowrap;
        }

        table.txn tbody tr { border-bottom: 1px solid #eeeeee; }
        table.txn tbody tr:last-child { border-bottom: none; }
        table.txn tbody tr:hover { background: #fafafa; }

        table.txn tbody td {
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 500;
            color: #222;
            vertical-align: middle;
        }

        .slot-label {
            font-size: 8.5px;
            font-weight: 800;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #0f0f0f;
        }

        .slot-time {
            font-size: 9px;
            color: #999;
            font-weight: 500;
            margin-top: 1px;
        }

        td.trans-no {
            font-weight: 800;
            font-size: 12px;
            letter-spacing: 0.06em;
            color: #0f0f0f;
        }

        td.amount {
            font-weight: 900;
            font-size: 13px;
            color: #0f0f0f;
            white-space: nowrap;
        }

        .type-badge {
            border: 1px solid #c8c8c8;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            padding: 2px 8px;
            color: #444;
        }

        /* ─── FOOTER ─── */
        .footer {
            margin-top: 14px;
            padding-top: 12px;
            border-top: 1px solid #e0e0e0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 16px;
        }

        .footer-note {
            font-size: 9px;
            font-weight: 400;
            color: #aaa;
            font-style: italic;
            line-height: 1.65;
            max-width: 420px;
        }

        .footer-agent {
            font-size: 9px;
            font-weight: 800;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: #444;
            text-align: right;
            white-space: nowrap;
            line-height: 1;
        }

        .footer-agent span {
            display: block;
            font-size: 8px;
            font-weight: 500;
            color: #aaa;
            letter-spacing: 0.16em;
            margin-top: 3px;
            text-transform: uppercase;
        }

        /* ─── BOTTOM ─── */
        .bottom { margin-top: 14px; }

        .verified-line {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 6px;
        }

        .verified-line::before,
        .verified-line::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e0e0e0;
        }

        .verified-text {
            font-size: 7.5px;
            font-weight: 700;
            letter-spacing: 0.28em;
            text-transform: uppercase;
            color: #bbb;
            white-space: nowrap;
        }

        /* ─── ANIMATIONS ─── */
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes riseUp {
            from { opacity: 0; transform: translateY(14px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .top-bar    { animation: fadeDown 0.45s ease both; }
        .hero       { animation: fadeDown 0.45s ease 0.06s both; }
        .info-grid  { animation: riseUp  0.5s  ease 0.1s  both; }
        .fin-strip  { animation: riseUp  0.5s  ease 0.15s both; }
        .txn-wrap   { animation: riseUp  0.5s  ease 0.2s  both; }
        .footer     { animation: riseUp  0.5s  ease 0.25s both; }

        /* ─── MOBILE ─── */
        @media (max-width: 600px) {
            body { padding: 20px 12px 28px; }

            .top-bar { flex-direction: column; align-items: flex-start; gap: 4px; }
            .scheme-name, .scheme-sub { text-align: left; }

            .hero { flex-direction: column; align-items: flex-start; gap: 10px; }
            .hero-right { align-items: flex-start; }
            .file-number { font-size: 32px; }

            .info-grid { grid-template-columns: 1fr; }
            .info-panel + .info-panel { border-left: none; border-top: 1px solid #e0e0e0; }

            .fin-cells { grid-template-columns: 1fr 1fr; }
            .fin-cell { border-bottom: 1px solid #e0e0e0; }
            .fin-cell.col-balance { border-bottom: none; }
            .fin-cell-value { font-size: 16px; }

            table.txn thead th:nth-child(5),
            table.txn tbody td:nth-child(5) { display: none; }

            .footer { flex-direction: column; gap: 8px; }
            .footer-agent { text-align: left; }
            .verified-text { font-size: 7px; }
        }
    </style>
</head>

<body>

    <div class="watermark">Verified</div>

    <div class="wrapper">

        {{-- ── TOP BAR ── --}}
        <div class="top-bar">
            <div>
                <div class="org-name">{{ \App\Helpers\Helper::getCompanyName() }}</div>
                <div class="org-sub">Registered Real Estate Developer</div>
            </div>
            <div>
                <div class="scheme-name">{{ $project->name ?? 'N/A' }}</div>
                <div class="scheme-sub">Official Plot Record</div>
            </div>
        </div>

        <div class="rule-bold"></div>
        <div class="rule-thin"></div>

        {{-- ── HERO ── --}}
        <div class="hero">
            <div>
                <div class="file-label">File Number</div>
                <div class="file-number">{{ $customerPlotFile->file_no ?? 'N/A' }}</div>
            </div>
            <div class="hero-right">
                <div class="status-badge">&#10003;&ensp;{{ ucfirst($customerPlotFile->status ?? 'Booked') }}</div>
                <div class="plot-meta">
                    Plot No.&ensp;{{ $plot->block ?? 'N/A' }} — {{ $plot->plot_no ?? 'N/A' }}<br>
                    {{ $plot->size ?? 'N/A' }}
                </div>
            </div>
        </div>

        {{-- ── INFO GRID ── --}}
        <div class="info-grid">

            <div class="info-panel">
                <div class="panel-title">Owner Information</div>

                <div class="field">
                    <div class="field-label">Full Name</div>
                    <div class="field-value">{{ $customer->name ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Father / Husband</div>
                    <div class="field-value">{{ $customer->father_husband_name ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">CNIC Number</div>
                    <div class="field-value mono">{{ $customer->cnic ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Mobile</div>
                    <div class="field-value mono">{{ $customer->phone ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Nominee</div>
                    <div class="field-value">{{ $customer->nominee ?? 'N/A' }}
                        <span style="font-weight:500; color:#999; font-size:11px;">(Nominee)</span>
                    </div>
                </div>
                <div class="field">
                    <div class="field-label">Residential Address</div>
                    <div class="field-value sm">{{ $customer->address ?? 'N/A' }}</div>
                </div>
            </div>

            <div class="info-panel">
                <div class="panel-title">Plot Information</div>

                <div class="field">
                    <div class="field-label">Plot Number</div>
                    <div class="field-value">{{ $plot->block ?? 'N/A' }} — {{ $plot->plot_no ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Plot Size</div>
                    <div class="field-value">{{ $plot->size ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Special Features</div>
                    <div class="tag-row">
                        @php $features = $plot->extra ? json_decode($plot->extra, true) : []; @endphp
                        @if (!empty($features))
                            @foreach ($features as $feature)
                                <span class="tag">{{ $feature }}</span>
                            @endforeach
                        @else
                            <span class="tag">No Feature</span>
                        @endif
                    </div>
                </div>
                <div class="field" style="margin-top:10px;">
                    <div class="field-label">Booking Agent</div>
                    <div class="field-value">{{ $customerPlotFile->booked_by ?? 'N/A' }}</div>
                </div>
                <div class="field">
                    <div class="field-label">Current Status</div>
                    <div class="field-value" style="font-weight:900; letter-spacing:0.1em;">
                        {{ strtoupper($customerPlotFile->status ?? 'N/A') }}
                    </div>
                </div>
            </div>

        </div>

        {{-- ── FINANCIAL STRIP ── --}}
        <div class="fin-strip">
            <div class="fin-header">Financial Summary</div>
            <div class="fin-cells">
                <div class="fin-cell">
                    <div class="fin-cell-label">Total Cost</div>
                    <div class="fin-cell-value">{{ \App\Helpers\Helper::formatCurrency($totalCost) }}</div>
                </div>
                <div class="fin-cell">
                    <div class="fin-cell-label">Discount</div>
                    <div class="fin-cell-value">{{ \App\Helpers\Helper::formatCurrency($discount) }}</div>
                </div>
                <div class="fin-cell">
                    <div class="fin-cell-label">Paid Amount</div>
                    <div class="fin-cell-value">{{ \App\Helpers\Helper::formatCurrency($paidAmount) }}</div>
                </div>
                <div class="fin-cell col-balance">
                    <div class="fin-cell-label">Balance Due</div>
                    <div class="fin-cell-value">{{ \App\Helpers\Helper::formatCurrency($balanceDue) }}</div>
                </div>
            </div>
        </div>

        {{-- ── TRANSACTIONS ── --}}
        <div class="txn-wrap">
            <div class="txn-header">Transaction History</div>
            <table class="txn">
                <thead>
                    <tr>
                        <th>Mode</th>
                        <th>Trans #</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Reference</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments ?? [] as $transaction)
                        <tr>
                            <td>
                                <div class="slot-label">{{ ucfirst($transaction->payment_type) }}</div>
                                <div class="slot-time">Slot {{ $loop->iteration }} &nbsp;·&nbsp; {{ $transaction->created_at->format('H:i') }}</div>
                            </td>
                            <td class="trans-no">#{{ $transaction->id }}</td>
                            <td><span class="type-badge">{{ ucfirst($transaction->payment_method) }}</span></td>
                            <td class="amount">{{ \App\Helpers\Helper::formatCurrency($transaction->amount) }}</td>
                            <td style="font-size:11px; color:#999; letter-spacing:0.04em;">{{ $transaction->ref_no ?? 'N/A' }}</td>
                            <td style="font-size:11px; white-space:nowrap; font-weight:700;">{{ \Carbon\Carbon::parse($transaction->payment_date)->format('d M, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding:28px; color:#aaa; font-size:12px; font-weight:500; letter-spacing:0.1em;">
                                No transactions found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── FOOTER ── --}}
        <div class="footer">
            <div class="footer-note">
                This record was retrieved upon QR code verification. All details are subject to the official records maintained by {{ \App\Helpers\Helper::getCompanyName() }}.
            </div>
            <div class="footer-agent">
                {{ $customerPlotFile->booked_by ?? 'N/A' }}
                <span>Authorised Booking Agent</span>
            </div>
        </div>

        {{-- ── BOTTOM ── --}}
        <div class="bottom">
            <div class="rule-bold" style="height:2px;"></div>
            <div class="verified-line">
                <span class="verified-text">
                    QR-Verified Document &nbsp;·&nbsp; {{ \App\Helpers\Helper::getCompanyName() }} &nbsp;·&nbsp; {{ $project->name ?? '' }}
                </span>
            </div>
        </div>

    </div>
</body>
</html>
