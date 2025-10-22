@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    <ul class="nav flex-column nav-pills py-3" id="receiptTab" role="tablist">
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start active" id="unchecked-tab" data-bs-toggle="pill" data-bs-target="#unchecked-section" type="button" role="tab" aria-controls="unchecked-section" aria-selected="true">
                                <i class="fas fa-clock me-2" style="color:#064e3b;"></i>Unchecked Receipts
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="today-tab" data-bs-toggle="pill" data-bs-target="#today-section" type="button" role="tab" aria-controls="today-section" aria-selected="false">
                                <i class="fas fa-calendar-day me-2" style="color:#064e3b;"></i>Today's Receipts
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="all-tab" data-bs-toggle="pill" data-bs-target="#all-section" type="button" role="tab" aria-controls="all-section" aria-selected="false">
                                <i class="fas fa-list me-2" style="color:#064e3b;"></i>All Receipts
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-9">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h4 class="fw-semibold text-dark mb-1">Receipt Management</h4>
                    <p class="text-muted mb-0">Manage, verify, and print receipts.</p>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="receiptTabContent">

                        {{-- ================= UNCHECKED RECEIPTS ================= --}}
                        <div class="tab-pane fade show active" id="unchecked-section" role="tabpanel" aria-labelledby="unchecked-tab">
                            <h5 class="fw-bold text-dark mb-3">Unchecked Receipts</h5>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($uncheckedReceipts as $receipt)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $receipt->member->full_name }}</td>
                                                <td>{{ $receipt->amount }}</td>
                                                <td>{{ $receipt->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <form action="{{ route('receipts.verify', $receipt->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-success btn-sm">Verify</button>
                                                    </form>
                                                    <form action="{{ route('receipts.unverify', $receipt->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button class="btn btn-warning btn-sm">Unverify</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $uncheckedReceipts->links() }} --}}
                            </div>
                        </div>

                        {{-- ================= TODAY'S RECEIPTS ================= --}}
       <div class="tab-pane fade" id="today-section" role="tabpanel" aria-labelledby="today-tab">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header bg-white border-bottom-0 pb-0">
            <h4 class="fw-semibold text-dark mb-1">Today's Receipts</h4>
            <p class="text-muted mb-0">View, print, and send messages for today's contributions.</p>
        </div>

        <div class="card-body">
            {{-- ✅ Main Form to send checked IDs --}}
            <form action="{{ route('receipts.sendMessage') }}" method="POST" id="todayForm">
                @csrf
                {{-- Action Buttons --}}
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <div>
                        <button type="submit" class="btn text-white" style="background-color:#064e3b;">
                            <i class="fas fa-paper-plane me-2"></i>Send Message
                        </button>

                        {{-- Print Selected --}}
                        <button type="button"
                            onclick="handlePrintSelected()"
                            class="btn btn-outline-dark ms-2">
                            <i class="fas fa-print me-2"></i>Print Selected PDF
                        </button>
                    </div>

                    {{-- Search Filter --}}
                    <div class="d-flex align-items-center">
                        <input type="text" id="searchToday" class="form-control form-control-sm"
                            placeholder="Search by name..." style="max-width: 250px;">
                    </div>
                </div>

                {{-- 🧾 Totals --}}
                @php
                    $churchTotal = 0;
                    $conferenceTotal = 0;
                    $typeTotals = array_fill_keys($contributionTypes->pluck('id')->toArray(), 0);
                    $grandTotal = 0;
                @endphp

                @foreach($stewardships as $stewardship)
                    @foreach($contributionTypes as $type)
                        @php
                            $transaction = $stewardship->transactions->firstWhere('contribution_type_id', $type->id);
                            $amount = $transaction->amount ?? 0;
                            $typeTotals[$type->id] += $amount;
                            $churchTotal += $amount * ($type->church_percentage / 100);
                            $conferenceTotal += $amount * ($type->conference_percentage / 100);
                            $grandTotal += $amount;
                        @endphp
                    @endforeach
                @endforeach

                {{-- 📊 Table --}}
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th><input type="checkbox" id="checkAllToday" class="form-check-input"></th>
                                <th>#</th>
                                <th>Member</th>
                                @foreach($contributionTypes as $type)
                                    <th>{{ $type->contribution_name }}</th>
                                @endforeach
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="todayTableBody">
                            @foreach($stewardships as $index => $stewardship)
                                @php $rowTotal = 0; @endphp
                                <tr>
                                    {{-- ✅ Use Stewardship ID for form submission --}}
                                                            <td>
                                    <input type="checkbox"
                                        name="receipts[]"
                                        value="{{ $stewardship->id }}"
                                        class="form-check-input receipt-checkbox">
                                </td>

                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $stewardship->member->full_name ?? 'N/A' }}</td>

                                    @foreach($contributionTypes as $type)
                                        @php
                                            $transaction = $stewardship->transactions->firstWhere('contribution_type_id', $type->id);
                                            $amount = $transaction->amount ?? 0;
                                            $rowTotal += $amount;
                                        @endphp
                                        <td>{{ $amount ? number_format($amount, 2) : '-' }}</td>
                                    @endforeach

                                    <td><strong>{{ number_format($rowTotal, 2) }}</strong></td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="2" class="text-end">Grand Total:</td>
                                @foreach($contributionTypes as $type)
                                    <td>{{ number_format($typeTotals[$type->id], 2) }}</td>
                                @endforeach
                                <td>{{ number_format($grandTotal, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </form>
        </div>
    </div>
</div>

                        {{-- ================= ALL RECEIPTS ================= --}}
                        <div class="tab-pane fade" id="all-section" role="tabpanel" aria-labelledby="all-tab">
                            <h5 class="fw-bold text-dark mb-3">All Receipts</h5>
                            <form method="GET" action="{{ route('receipts.index') }}" class="row g-2 mb-3">
                                <div class="col-md-4">
                                    <input type="text" name="search" class="form-control" placeholder="Search by Member or ID">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="from_date" class="form-control" placeholder="From">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" name="to_date" class="form-control" placeholder="To">
                                </div>
                                <div class="col-md-2">
                                    <button class="btn btn-primary w-100">Search</button>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($allReceipts as $receipt)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $receipt->member->full_name }}</td>
                                                <td>{{ $receipt->amount }}</td>
                                                <td>{{ $receipt->status }}</td>
                                                <td>{{ $receipt->created_at->format('Y-m-d') }}</td>
                                                <td>
                                                    <a href="{{ route('receipts.view', $receipt->id) }}" class="btn btn-info btn-sm">View</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- {{ $allReceipts->links() }} --}}
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    // Select All for Today's Receipts
    document.getElementById('checkAllToday').addEventListener('change', function() {
        document.querySelectorAll('input[name="receipts[]"]').forEach(cb => cb.checked = this.checked);
    });
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Get the saved tab ID from localStorage
    const activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        const tabElement = document.querySelector(`#${activeTab}-tab`);
        const tabContent = document.querySelector(`#${activeTab}-section`);
        if (tabElement && tabContent) {
            // Remove active from all tabs
            document.querySelectorAll(".nav-link").forEach(tab => tab.classList.remove("active"));
            document.querySelectorAll(".tab-pane").forEach(pane => pane.classList.remove("show", "active"));

            // Add active to the saved one
            tabElement.classList.add("active");
            tabContent.classList.add("show", "active");
        }
    }

    // When a tab is clicked, save its ID
    document.querySelectorAll('.nav-link').forEach(tab => {
        tab.addEventListener('click', function () {
            const id = this.getAttribute('id').replace('-tab', '');
            localStorage.setItem('activeTab', id);
        });
    });
});
</script>
<script>
    // Select/Deselect All
    document.getElementById('checkAllToday').addEventListener('change', function() {
        document.querySelectorAll('.receipt-checkbox').forEach(cb => cb.checked = this.checked);
    });

    // Handle Print Selected PDF
    function handlePrintSelected() {
        const form = document.getElementById('todayForm');
        const selected = Array.from(form.querySelectorAll('.receipt-checkbox:checked')).map(cb => cb.value);

        if (selected.length === 0) {
            alert("Please select at least one receipt to print.");
            return;
        }
        // Build URL with selected IDs as query parameters
        const url = `{{ route('receipts.printSelected') }}?ids=${selected.join(',')}`;
        window.open(url, '_blank');
    }
</script>

@endsection
