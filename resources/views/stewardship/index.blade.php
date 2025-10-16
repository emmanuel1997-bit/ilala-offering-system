@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar -->
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    <ul class="nav flex-column nav-pills py-3" id="contributionTab" role="tablist">
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start active" id="create-tab" data-bs-toggle="pill" data-bs-target="#create-section" type="button" role="tab" aria-controls="create-section" aria-selected="true">
                                <i class="fas fa-plus me-2" style="color:#064e3b;"></i>Create Contribution
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="offering-tab" data-bs-toggle="pill" data-bs-target="#offering-section" type="button" role="tab" aria-controls="offering-section" aria-selected="false">
                                <i class="fas fa-hand-holding-dollar me-2" style="color:#064e3b;"></i>Offering
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="tithe-tab" data-bs-toggle="pill" data-bs-target="#tithe-section" type="button" role="tab" aria-controls="tithe-section" aria-selected="false">
                                <i class="fas fa-coins me-2" style="color:#064e3b;"></i>Tithe
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="thanks-tab" data-bs-toggle="pill" data-bs-target="#thanks-section" type="button" role="tab" aria-controls="thanks-section" aria-selected="false">
                                <i class="fas fa-gift me-2" style="color:#064e3b;"></i>Thanks Giving
                            </button>
                        </li>
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start" id="other-tab" data-bs-toggle="pill" data-bs-target="#other-section" type="button" role="tab" aria-controls="other-section" aria-selected="false">
                                <i class="fas fa-donate me-2" style="color:#064e3b;"></i>Other Offering
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
                    <h4 class="fw-semibold text-dark mb-1">Contribution Management</h4>
                    <p class="text-muted mb-0">Create and view contributions by type.</p>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="contributionTabContent">

                    {{-- ================= CREATE CONTRIBUTION ================= --}}
<div class="tab-pane fade show active" id="create-section" role="tabpanel" aria-labelledby="create-tab">
    <h5 class="fw-bold text-dark mb-3">Create New Contribution</h5>
    <form method="POST" action="#" class="needs-validation" novalidate>
        @csrf

        {{-- Select or Add Member --}}
        <div class="mb-3">
            <label class="form-label">Select Member</label>
            <select name="member_id" id="memberSelect" class="form-select" required>
                <option value="">-- Select Member --</option>
                @foreach($members as $member)
                    <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                @endforeach
                <option value="new">+ Add New Member</option>
            </select>
        </div>

        {{-- New Member Form (hidden by default) --}}
        <div id="newMemberForm" style="display:none; border:1px solid #ddd; padding:15px; margin-bottom:15px; border-radius:5px;">
            <h6 class="fw-semibold mb-2">Add New Member</h6>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Full Name</label>
                    <input type="text" name="new_full_name" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Phone Number</label>
                    <input type="text" name="new_phone_number" class="form-control">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Email</label>
                    <input type="email" name="new_email" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="new_dob" class="form-control">
                </div>
            </div>
        </div>

        {{-- Contribution Details --}}
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Type</label>
                <select name="type" class="form-select" required>
                    <option value="">-- Select Type --</option>
                    <option value="Offering">Offering</option>
                    <option value="Tithe">Tithe</option>
                    <option value="Thanks Giving">Thanks Giving</option>
                    <option value="Other">Other Offering</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label">Amount</label>
                <input type="number" name="amount" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label">Notes</label>
                <textarea name="notes" class="form-control" rows="2"></textarea>
            </div>
        </div>

        <div class="d-flex justify-content-end">
            <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Contribution</button>
        </div>
    </form>
</div>

                        {{-- ================= OFFERING TABLE ================= --}}
                        <div class="tab-pane fade" id="offering-section" role="tabpanel" aria-labelledby="offering-tab">
                            <h5 class="fw-bold text-dark mb-3">Offering Contributions</h5>
                            <button class="btn btn-success mb-2">Export to Excel</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($offerings as $offering)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $offering->member->full_name }}</td>
                                                <td>{{ $offering->amount }}</td>
                                                <td>{{ $offering->date }}</td>
                                                <td>{{ $offering->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= TITHE TABLE ================= --}}
                        <div class="tab-pane fade" id="tithe-section" role="tabpanel" aria-labelledby="tithe-tab">
                            <h5 class="fw-bold text-dark mb-3">Tithe Contributions</h5>
                            <button class="btn btn-success mb-2">Export to Excel</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($tithes as $tithe)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tithe->member->full_name }}</td>
                                                <td>{{ $tithe->amount }}</td>
                                                <td>{{ $tithe->date }}</td>
                                                <td>{{ $tithe->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= THANKS GIVING TABLE ================= --}}
                        <div class="tab-pane fade" id="thanks-section" role="tabpanel" aria-labelledby="thanks-tab">
                            <h5 class="fw-bold text-dark mb-3">Thanks Giving Contributions</h5>
                            <button class="btn btn-success mb-2">Export to Excel</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($thanksGiving as $tg)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $tg->member->full_name }}</td>
                                                <td>{{ $tg->amount }}</td>
                                                <td>{{ $tg->date }}</td>
                                                <td>{{ $tg->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- ================= OTHER OFFERING TABLE ================= --}}
                        <div class="tab-pane fade" id="other-section" role="tabpanel" aria-labelledby="other-tab">
                            <h5 class="fw-bold text-dark mb-3">Other Contributions</h5>
                            <button class="btn btn-success mb-2">Export to Excel</button>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Member</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($otherOfferings as $other)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $other->member->full_name }}</td>
                                                <td>{{ $other->amount }}</td>
                                                <td>{{ $other->date }}</td>
                                                <td>{{ $other->notes }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    document.getElementById('memberSelect').addEventListener('change', function() {
        let newMemberForm = document.getElementById('newMemberForm');
        if(this.value === 'new') {
            newMemberForm.style.display = 'block';
        } else {
            newMemberForm.style.display = 'none';
        }
    });
</script>
@endsection
