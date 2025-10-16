@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h4 class="fw-semibold text-dark mb-0">Income Records</h4>
            <div class="d-flex gap-2">
                <a href="" class="btn btn-outline-success">
                    <i class="fas fa-file-excel me-1"></i> Export Excel
                </a>
                <button class="btn text-white" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#addIncomeModal">
                    <i class="fas fa-plus me-1"></i> Add Income
                </button>
            </div>
        </div>

        <div class="card-body">

            <!-- Search Bar -->
            <form method="GET" class="row g-2 mb-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary">Search</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by source or description...">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">From Date</label>
                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary">To Date</label>
                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control">
                </div>

                <div class="col-md-2">
                    <button class="btn btn-success w-100" style="background-color:#064e3b;">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('income.index') }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Source</th>
                            <th>Amount</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($incomes as $income)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $income->source }}</td>
                            <td>{{ number_format($income->amount, 2) }}</td>
                            <td>{{ $income->date }}</td>
                            <td>{{ $income->description ?? '-' }}</td>
                            <td>
                                <form action="{{ route('income.destroy', $income->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">No income records found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $incomes->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Add Income Modal -->
<div class="modal fade" id="addIncomeModal" tabindex="-1" aria-labelledby="addIncomeLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route('income.store') }}" method="POST">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Add New Income</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Source</label>
                    <input type="text" name="source" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Amount</label>
                    <input type="number" name="amount" step="0.01" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Date</label>
                    <input type="date" name="date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
