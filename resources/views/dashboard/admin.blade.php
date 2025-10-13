@extends('layouts.app')

@section('content')
<style>
    .dashboard {
        padding: 20px;
        background: #f5f5f5;
        min-height: 100vh;
    }
    .dashboard .card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .card-title {
        font-weight: 700;
    }
    .bg-primary-green {
        background-color: #157347;
        color: #fff;
    }
    .table thead {
        background-color: #157347;
        color: #fff;
    }
</style>

<div class="d-flex">
    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="dashboard flex-grow-1">
        <h3 class="mb-4">Dashboard</h3>

        <!-- Stats -->
        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card p-3 bg-primary-green">
                    <div class="card-body">
                        <h5 class="card-title">Total Offerings</h5>
                        <p class="card-text fs-3">{{ rand(5000, 20000) }} TZS</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-3 bg-primary-green">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text fs-3">{{ rand(50, 200) }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card p-3 bg-primary-green">
                    <div class="card-body">
                        <h5 class="card-title">Pending Approvals</h5>
                        <p class="card-text fs-3">{{ rand(0, 20) }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Offerings Table -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-3">Recent Offerings</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Member</th>
                                <th>Amount (TZS)</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i=1; $i<=5; $i++)
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>Member {{ rand(1,50) }}</td>
                                    <td>{{ rand(500,5000) }}</td>
                                    <td>{{ \Carbon\Carbon::now()->subDays(rand(0,10))->format('d/m/Y') }}</td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
