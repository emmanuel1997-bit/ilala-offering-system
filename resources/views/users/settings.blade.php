@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    @php
                        $tabs = [
                            ['id' => 'ministries', 'icon' => 'church', 'label' => 'Ministries'],
                            ['id' => 'contribution', 'icon' => 'hand-holding-usd', 'label' => 'Contribution Settings'],
                            ['id' => 'school', 'icon' => 'school', 'label' => 'Sabbath School (SS)'],
                            ['id' => 'messages', 'icon' => 'envelope', 'label' => 'Messages'],
                            ['id' => 'receipts', 'icon' => 'file-signature', 'label' => 'Receipt Settings'],
                            ['id' => 'spending', 'icon' => 'wallet', 'label' => 'Spending / Expenses'],
                        ];
                    @endphp
                    <ul class="nav flex-column nav-pills py-3" id="settingsTab" role="tablist">
                        @foreach($tabs as $i => $tab)
                        <li class="nav-item mb-1" role="presentation">
                            <button class="nav-link w-100 text-start {{ $i == 0 ? 'active' : '' }}"
                                id="{{ $tab['id'] }}-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#{{ $tab['id'] }}-section"
                                type="button"
                                role="tab"
                                aria-controls="{{ $tab['id'] }}-section"
                                aria-selected="{{ $i == 0 ? 'true' : 'false' }}">
                                <i class="fas fa-{{ $tab['icon'] }} me-2" style="color:#064e3b;"></i>
                                {{ $tab['label'] }}
                            </button>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-8 col-lg-9">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h4 class="fw-semibold text-dark mb-1">Church Management Settings</h4>
                    <p class="text-muted mb-0">
                        Manage ministries, contributions, messages, receipts, and spending.
                    </p>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">

                        {{-- ========================== MINISTRIES SECTION ========================== --}}
                        <div class="tab-pane fade show active" id="ministries-section" role="tabpanel" aria-labelledby="ministries-tab">
                            @if(auth()->user()->hasPermission('Ministries'))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Ministries</h5>
                                <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createMinistryModal">
                                    <i class="fas fa-plus me-1"></i> Add Ministry
                                </button>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Ministry Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ministries as $ministry)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ministry->name }}</td>
                                            <td>{{ $ministry->description }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMinistryModal-{{ $ministry->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('ministries.destroy', $ministry->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        {{-- ========================== SABBATH SCHOOL SECTION ========================== --}}
                        <div class="tab-pane fade" id="school-section" role="tabpanel" aria-labelledby="school-tab">
                            @if(auth()->user()->hasPermission('Sabbath School'))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Sabbath School (SS)</h5>
                                <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createSSModal">
                                    <i class="fas fa-plus me-1"></i> Add SS Class
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>SS Name</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($schools as $ss)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $ss->name }}</td>
                                            <td>{{ $ss->description }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editSSModal-{{ $ss->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        {{-- ========================== CONTRIBUTION SETTINGS ========================== --}}
                        <div class="tab-pane fade" id="contribution-section" role="tabpanel" aria-labelledby="contribution-tab">
                            @if(auth()->user()->hasPermission('Settings'))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Contribution Types</h5>
                                <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createContributionModal">
                                    <i class="fas fa-plus me-1"></i> Add Type
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($contributions as $type)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $type->name }}</td>
                                            <td>{{ $type->description }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editContributionModal-{{ $type->id }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="#" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>

                        {{-- ========================== MESSAGES SECTION ========================== --}}
                        <div class="tab-pane fade" id="messages-section" role="tabpanel" aria-labelledby="messages-tab">
                            @if(auth()->user()->hasPermission('Messages'))
                                <h5 class="fw-bold text-dark mb-3">Receipt Message Template</h5>
                                <div class="alert alert-info">
                                    <strong>Available placeholders:</strong>
                                    <code>{name}</code>, <code>{zaka}</code>, <code>{sadaka}</code>,
                                    <code>{makambi}</code>, <code>{shukrani}</code>, <code>{mchango}</code>
                                </div>
                                <form class="form-control" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="receipt_message" class="form-label">Receipt Message</label>
                                        <textarea name="receipt_message" id="receipt_message" class="form-control" rows="6" required
                                            style="color:#000 !important; background-color:#fff !important;">
                                            {{ $receiptMessage ?? "Shukrani {name} kwa mchango wako wa mwezi huu." }}
                                        </textarea>
                                    </div>
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Template</button>
                                </form>
                            @endif
                        </div>

                        {{-- ========================== RECEIPT SETTINGS ========================== --}}
                        <div class="tab-pane fade" id="receipts-section" role="tabpanel" aria-labelledby="receipts-tab">
                            @if(auth()->user()->hasPermission('Settings'))
                                <h5 class="fw-bold text-dark mb-3">Receipt Settings</h5>
                                <form method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Signature Image</label>
                                        <input type="file" name="signature" class="form-control">
                                    </div>
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Settings</button>
                                </form>
                                <hr class="my-4">
                                <h5 class="fw-bold text-dark mb-3">Receipt Preview</h5>
                                <a onclick="window.open('{{ route('receipts.printSelected') }}', '_blank')" target="_blank" class="btn btn-outline-success">
                                    View Receipt Format
                                </a>
                            @endif
                        </div>

                        {{-- ========================== SPENDING / EXPENSES ========================== --}}
                        <div class="tab-pane fade" id="spending-section" role="tabpanel" aria-labelledby="spending-tab">
                            @if(auth()->user()->hasPermission('Expenses'))
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Expenses</h5>
                                <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createExpenseModal">
                                    <i class="fas fa-plus me-1"></i> Add Expense
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Item</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($expenses as $expense)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $expense->item }}</td>
                                            <td>{{ number_format($expense->amount, 2) }}</td>
                                            <td>{{ $expense->date }}</td>
                                            <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editExpenseModal-{{ $expense->id }}"><i class="fas fa-edit"></i></button>
                                                <form action="{{ route('expenses.destroy', $expense->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ✅ Remember Active Tab Script -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll('#settingsTab .nav-link');
    const savedTab = localStorage.getItem('activeSettingsTab');

    if (savedTab) {
        const targetTab = document.querySelector(`#${savedTab}-tab`);
        const targetSection = document.querySelector(`#${savedTab}-section`);
        if (targetTab && targetSection) {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            targetTab.classList.add('active');
            targetSection.classList.add('show', 'active');
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.id.replace('-tab', '');
            localStorage.setItem('activeSettingsTab', id);
        });
    });
});
</script>
@endsection
