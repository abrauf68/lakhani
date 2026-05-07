@extends('layouts.master')

@section('title', __('Customer Details'))

@section('css')
<link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
    /* Professional Corporate Design */
    body {
        background: #f5f7fa;
    }
    
    /* Back Button */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        color: #475569;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
        margin-bottom: 20px;
    }
    
    .back-btn:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        text-decoration: none;
        color: #1e293b;
    }
    
    /* Cards */
    .card-custom {
        background: white;
        border-radius: 8px;
        border: 1px solid #e2e8f0;
        overflow: hidden;
        margin-bottom: 24px;
    }
    
    .card-header-custom {
        padding: 16px 24px;
        background: white;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .card-header-custom h5 {
        margin: 0;
        font-size: 16px;
        font-weight: 600;
        color: #1e293b;
    }
    
    .card-body-custom {
        padding: 24px;
    }
    
    /* Info Grid */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 0;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
    }
    
    .info-item {
        padding: 16px 20px;
        background: white;
        border-right: 1px solid #e2e8f0;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .info-item:nth-child(4n) {
        border-right: none;
    }
    
    .info-item:nth-last-child(-n+4) {
        border-bottom: none;
    }
    
    .info-label {
        font-size: 11px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #64748b;
        margin-bottom: 6px;
    }
    
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    
    /* Status Badges */
    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: 500;
        border-radius: 4px;
    }
    
    .badge-active, .badge-booked {
        background: #e6f4ea;
        color: #1e7e34;
    }
    
    .badge-inactive, .badge-cancelled {
        background: #fef2f0;
        color: #dc3545;
    }
    
    /* Plot Table */
    .plot-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .plot-table th {
        text-align: left;
        padding: 12px 16px;
        background: #f8fafc;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .plot-table td {
        padding: 16px;
        font-size: 13px;
        color: #334155;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: top;
    }
    
    .plot-row {
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .plot-row:hover {
        background: #fafbfc;
    }
    
    /* Details Panel */
    .details-panel {
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
        padding: 20px 24px;
    }
    
    .details-panel.hide {
        display: none;
    }
    
    .detail-section {
        margin-bottom: 24px;
    }
    
    .detail-section:last-child {
        margin-bottom: 0;
    }
    
    .detail-title {
        font-size: 13px;
        font-weight: 600;
        color: #1e293b;
        margin-bottom: 12px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .detail-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    
    .detail-label {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 4px;
    }
    
    .detail-value {
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
    }
    
    /* Financial Cards */
    .financial-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    
    .financial-box {
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 12px 16px;
    }
    
    .financial-box .label {
        font-size: 11px;
        color: #64748b;
        margin-bottom: 6px;
    }
    
    .financial-box .amount {
        font-size: 18px;
        font-weight: 600;
        color: #1e293b;
    }
    
    /* Payment Table */
    .payment-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }
    
    .payment-table th {
        text-align: left;
        padding: 10px 12px;
        background: white;
        font-weight: 600;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
    }
    
    .payment-table td {
        padding: 10px 12px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
    }
    
    .method-badge {
        display: inline-block;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 500;
        border-radius: 3px;
        background: #f1f5f9;
        color: #475569;
    }
    
    /* Expand Icon */
    .expand-icon {
        transition: transform 0.2s;
        color: #94a3b8;
    }
    
    .rotate {
        transform: rotate(90deg);
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .info-item:nth-child(4n) {
            border-right: 1px solid #e2e8f0;
        }
        .info-item:nth-child(2n) {
            border-right: none;
        }
        .financial-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .detail-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
@endsection

@section('breadcrumb-items')
    <li class="breadcrumb-item"><a href="{{ route('dashboard.customers.index') }}">{{ __('Customers') }}</a></li>
    <li class="breadcrumb-item active">{{ __('Customer Details') }}</li>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <!-- Back Button -->
        <a href="{{ route('dashboard.customers.index') }}" class="back-btn">
            <i class="fas fa-arrow-left" style="font-size: 12px;"></i>
            Back to Customers
        </a>

        <!-- Customer Info Card -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-user" style="margin-right: 8px; color: #64748b;"></i> Customer Information</h5>
            </div>
            <div class="card-body-custom">
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $customer->name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">S/o D/o W/o</div>
                        <div class="info-value">{{ $customer->father_husband_name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">CNIC</div>
                        <div class="info-value">{{ $customer->cnic ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Status</div>
                        <div class="info-value">
                            <span class="badge-status {{ $customer->is_active == 'active' ? 'badge-active' : 'badge-inactive' }}">
                                <i class="fas {{ $customer->is_active == 'active' ? 'fa-check' : 'fa-times' }}" style="font-size: 10px;"></i>
                                {{ ucfirst($customer->is_active) }}
                            </span>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $customer->email ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Phone</div>
                        <div class="info-value">{{ $customer->phone ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Nominee</div>
                        <div class="info-value">{{ $customer->nominee ?? '—' }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Member Since</div>
                        <div class="info-value">{{ $customer->created_at ? $customer->created_at->format('d M, Y') : '—' }}</div>
                    </div>
                    <div class="info-item" style="grid-column: span 2;">
                        <div class="info-label">Address</div>
                        <div class="info-value">{{ $customer->address ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Plot Files Card -->
        <div class="card-custom">
            <div class="card-header-custom">
                <h5><i class="fas fa-folder" style="margin-right: 8px; color: #64748b;"></i> Plot Files</h5>
            </div>
            <div class="card-body-custom" style="padding: 0;">
                @if($customer->customerPlotFiles && $customer->customerPlotFiles->count() > 0)
                    <table class="plot-table">
                        <thead>
                            <tr>
                                <th style="width: 40px;"></th>
                                <th>File No.</th>
                                <th>Project</th>
                                <th>Plot No.</th>
                                <th>Booking Date</th>
                                <th>Total Cost</th>
                                <th>Paid</th>
                                <th>Remaining</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($customer->customerPlotFiles as $plotFile)
                                @php
                                    $totalPaid = $plotFile->payments->sum('amount');
                                @endphp
                                <tr class="plot-row" data-id="{{ $plotFile->id }}">
                                    <td><i class="fas fa-chevron-right expand-icon" style="font-size: 12px;"></i></td>
                                    <td><strong>{{ $plotFile->file_no }}</strong></td>
                                    <td>{{ $plotFile->projectPlot->project->name ?? '—' }}</td>
                                    <td>{{ $plotFile->projectPlot->plot_no ?? '—' }}</td>
                                    <td>{{ $plotFile->booking_date ? date('d-m-Y', strtotime($plotFile->booking_date)) : '—' }}</td>
                                    <td>Rs. {{ number_format($plotFile->total_cost, 0) }}</td>
                                    <td>Rs. {{ number_format($totalPaid, 0) }}</td>
                                    <td>Rs. {{ number_format($plotFile->remaining_amount, 0) }}</td>
                                    <td>
                                        <span class="badge-status {{ $plotFile->status == 'booked' ? 'badge-booked' : 'badge-cancelled' }}">
                                            {{ ucfirst($plotFile->status) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr class="details-row" data-id="{{ $plotFile->id }}" style="display: none;">
                                    <td colspan="9" style="padding: 0;">
                                        <div class="details-panel">
                                            <!-- Financial Summary -->
                                            <div class="financial-grid">
                                                <div class="financial-box">
                                                    <div class="label">Total Cost</div>
                                                    <div class="amount">Rs. {{ number_format($plotFile->total_cost, 0) }}</div>
                                                </div>
                                                <div class="financial-box">
                                                    <div class="label">Discount</div>
                                                    <div class="amount">Rs. {{ number_format($plotFile->discount, 0) }}</div>
                                                </div>
                                                <div class="financial-box">
                                                    <div class="label">Net Amount</div>
                                                    <div class="amount">Rs. {{ number_format($plotFile->total_cost - $plotFile->discount, 0) }}</div>
                                                </div>
                                                <div class="financial-box">
                                                    <div class="label">Remaining</div>
                                                    <div class="amount">Rs. {{ number_format($plotFile->remaining_amount, 0) }}</div>
                                                </div>
                                            </div>
                                            
                                            <!-- Plot Details -->
                                            <div class="detail-section">
                                                <div class="detail-title">Plot Details</div>
                                                <div class="detail-grid">
                                                    <div>
                                                        <div class="detail-label">Project</div>
                                                        <div class="detail-value">{{ $plotFile->projectPlot->project->name ?? '—' }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Plot No.</div>
                                                        <div class="detail-value">{{ $plotFile->projectPlot->plot_no ?? '—' }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Block</div>
                                                        <div class="detail-value">{{ $plotFile->projectPlot->block ?? '—' }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Size</div>
                                                        <div class="detail-value">{{ $plotFile->projectPlot->size ?? '—' }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Category</div>
                                                        <div class="detail-value">{{ ucfirst($plotFile->projectPlot->category ?? '—') }}</div>
                                                    </div>
                                                    <div>
                                                        <div class="detail-label">Booked By</div>
                                                        <div class="detail-value">{{ $plotFile->booked_by ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- Payment History -->
                                            <div class="detail-section">
                                                <div class="detail-title">Payment History</div>
                                                @if($plotFile->payments && $plotFile->payments->count() > 0)
                                                    <table class="payment-table">
                                                        <thead>
                                                            <tr>
                                                                <th>Date</th>
                                                                <th>Type</th>
                                                                <th>Reference</th>
                                                                <th>Amount</th>
                                                                <th>Method</th>
                                                                <th>Received By</th>
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($plotFile->payments as $payment)
                                                                动态
                                                                    <td>{{ date('d-m-Y', strtotime($payment->payment_date)) }}</td>
                                                                    <td>{{ ucfirst($payment->payment_type) }}</td>
                                                                    <td>{{ $payment->ref_no ?? '—' }}</td>
                                                                    <td><strong>Rs. {{ number_format($payment->amount, 0) }}</strong></td>
                                                                    <td><span class="method-badge">{{ str_replace('_', ' ', ucfirst($payment->payment_method)) }}</span></td>
                                                                    <td>{{ $payment->received_by ?? '—' }}</td>
                                                                    <td>{{ $payment->remarks ?? '—' }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @else
                                                    <div style="padding: 20px; text-align: center; color: #94a3b8;">
                                                        <i class="fas fa-receipt" style="margin-bottom: 8px; display: block;"></i>
                                                        No payment records found
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding: 40px; text-align: center; color: #94a3b8;">
                        <i class="fas fa-folder-open" style="font-size: 40px; margin-bottom: 12px; display: block;"></i>
                        No plot files found for this customer
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>
    $(document).ready(function() {
        // Toggle details on row click
        $('.plot-row').on('click', function() {
            var id = $(this).data('id');
            var detailsRow = $('.details-row[data-id="' + id + '"]');
            var icon = $(this).find('.expand-icon');
            
            if (detailsRow.is(':visible')) {
                detailsRow.hide();
                icon.removeClass('rotate');
            } else {
                // Hide all other open details
                $('.details-row').hide();
                $('.expand-icon').removeClass('rotate');
                
                // Show this one
                detailsRow.show();
                icon.addClass('rotate');
            }
        });
    });
</script>
@endsection