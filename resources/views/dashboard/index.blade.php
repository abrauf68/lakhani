@extends('layouts.master')

@section('title', 'Dashboard')

@section('css')
<style>
    .stat-card {
        border-radius: 12px;
        padding: 20px;
        color: #fff;
        position: relative;
        overflow: hidden;
    }
    .stat-card h3 {
        font-size: 28px;
        margin: 0;
        color: #fff;
    }
    .stat-card p {
        margin: 0;
        opacity: 0.9;
    }
    .bg-gradient-blue { background: linear-gradient(135deg,#4e73df,#224abe); }
    .bg-gradient-green { background: linear-gradient(135deg,#1cc88a,#13855c); }
    .bg-gradient-yellow { background: linear-gradient(135deg,#f6c23e,#dda20a); }
    .bg-gradient-red { background: linear-gradient(135deg,#e74a3b,#be2617); }

    .card-shadow {
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        border: none;
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
<div class="row g-6">

    <!-- STATS CARDS -->
    <div class="col-md-3">
        <div class="stat-card bg-gradient-blue">
            <p>Total Customers</p>
            <h3>1,245</h3>
            <small>+12% this month</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-green">
            <p>Total Projects</p>
            <h3>58</h3>
            <small>+3 new</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-yellow">
            <p>Total Plots</p>
            <h3>3,890</h3>
            <small>Occupied & Available</small>
        </div>
    </div>

    <div class="col-md-3">
        <div class="stat-card bg-gradient-red">
            <p>Pending Payments</p>
            <h3>Rs 12.4M</h3>
            <small>Due invoices</small>
        </div>
    </div>

    <!-- CHARTS ROW -->
    <div class="col-md-8 mt-4">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">Payments Overview</h5>
            </div>
            <div class="card-body">
                <canvas id="paymentsChart" height="120"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4 mt-4">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">Plot Status</h5>
            </div>
            <div class="card-body">
                <canvas id="plotChart" height="200"></canvas>
            </div>
        </div>
    </div>

    <!-- SECOND ROW -->
    <div class="col-md-6 mt-4">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">Monthly Revenue</h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6 mt-4">
        <div class="card card-shadow">
            <div class="card-header">
                <h5 class="mb-0">Recent Invoices</h5>
            </div>
            <div class="card-body p-0">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Customer</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>INV-001</td>
                            <td>Ali Khan</td>
                            <td>Rs 120,000</td>
                            <td><span class="badge bg-success">Paid</span></td>
                        </tr>
                        <tr>
                            <td>INV-002</td>
                            <td>Ahmed Raza</td>
                            <td>Rs 85,000</td>
                            <td><span class="badge bg-warning">Pending</span></td>
                        </tr>
                        <tr>
                            <td>INV-003</td>
                            <td>Usman Tariq</td>
                            <td>Rs 200,000</td>
                            <td><span class="badge bg-danger">Overdue</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

// Payments Chart
new Chart(document.getElementById('paymentsChart'), {
    type: 'line',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul'],
        datasets: [{
            label: 'Payments (Rs)',
            data: [120000, 190000, 300000, 250000, 400000, 350000, 500000],
            borderColor: '#4e73df',
            fill: true,
            tension: 0.4
        }]
    }
});

// Plot Chart
new Chart(document.getElementById('plotChart'), {
    type: 'doughnut',
    data: {
        labels: ['Sold', 'Available', 'Reserved'],
        datasets: [{
            data: [60, 25, 15],
            backgroundColor: ['#1cc88a','#f6c23e','#e74a3b']
        }]
    }
});

// Revenue Chart
new Chart(document.getElementById('revenueChart'), {
    type: 'bar',
    data: {
        labels: ['Jan','Feb','Mar','Apr','May','Jun'],
        datasets: [{
            label: 'Revenue',
            data: [500000, 700000, 600000, 800000, 900000, 1000000],
            backgroundColor: '#36b9cc'
        }]
    }
});

</script>
@endsection
