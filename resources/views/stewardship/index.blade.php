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
                            <button class="nav-link w-100 text-start" id="contributions-tab" data-bs-toggle="pill" data-bs-target="#contributions-section" type="button" role="tab" aria-controls="contributions-section" aria-selected="false">
                                <i class="fas fa-list me-2" style="color:#064e3b;"></i>Contributions
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
                            <form method="POST" action="{{ route('stewardship.store') }}" class="needs-validation" novalidate>
                                @csrf

                                {{-- Select or Add Member --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Member</label><br>
                                    <button type="button" class="btn text-white" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#memberModal">
                                        Select or Add Member
                                    </button>
                                    <input type="hidden" name="member_id" id="selectedMemberId">
                                    <div id="selectedMemberInfo" class="mt-2 text-muted small"></div>
                                </div>

                                {{-- Modal for Selecting / Adding Member --}}
                                <div class="modal fade" id="memberModal" tabindex="-1" aria-labelledby="memberModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                        <div class="modal-content">
                                            <div class="modal-header" style="background-color:#064e3b;">
                                                <h5 class="modal-title text-white" id="memberModalLabel">Select or Add Member</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                {{-- Search --}}
                                                <div class="mb-3">
                                                    <input type="text" id="memberSearch" class="form-control" placeholder="Search member by name or phone...">
                                                </div>

                                                {{-- Member List --}}
                                                <div id="memberList">
                                                    @foreach($members as $member)
                                                        <div class="d-flex justify-content-between align-items-center border p-2 rounded mb-2 member-item">
                                                            <div>
                                                                <strong>{{ $member->full_name }}</strong><br>
                                                                <small>{{ $member->phone_number }}</small>
                                                            </div>
                                                            <button type="button" class="btn btn-sm text-white select-member-btn"
                                                                style="background-color:#064e3b;"
                                                                data-id="{{ $member->id }}"
                                                                data-name="{{ $member->full_name }}"
                                                                data-phone="{{ $member->phone_number }}">
                                                                Select
                                                            </button>
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <hr>

                                                {{-- Add New Member --}}
                                                <h6 class="fw-semibold mb-2">Add New Member</h6>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Full Name</label>
                                                        <input type="text" id="new_full_name" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Phone Number</label>
                                                        <input type="text" id="new_phone_number" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <label class="form-label">Email</label>
                                                        <input type="email" id="new_email" class="form-control">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label class="form-label">Date of Birth</label>
                                                        <input type="date" id="new_dob" class="form-control">
                                                    </div>
                                                </div>
                                                <button type="button" id="saveNewMember" class="btn text-white" style="background-color:#064e3b;">
                                                    Use This Member
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Contribution types --}}
                                <div class="mb-3">
                                    <label class="form-label">Contribution Types</label>
                                    <div id="contributionTypes">
                                        @foreach($contributionTypes as $type)
                                            <div class="form-check mb-2">
                                                <input class="form-check-input contribution-checkbox" type="checkbox"
                                                    id="type_{{ $type->id }}" name="types[]" value="{{ $type->id }}">
                                                <label class="form-check-label" for="type_{{ $type->id }}">
                                                    {{ $type->contribution_name }}
                                                </label>
                                                <div class="mt-2 ms-4 amount-field" id="amount_{{ $type->id }}" style="display:none;">
                                                    <input type="number" name="amounts[{{ $type->id }}]" class="form-control"
                                                        placeholder="Enter amount for {{ $type->contribution_name }}">
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                {{-- Payment Method & Reference --}}
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Payment Method</label>
                                        <select name="payment_method" class="form-select" required>
                                            <option value="Cash" selected>Cash</option>
                                            <option value="Bank">Bank</option>
                                            <option value="Mobile Money">Mobile Money</option>
                                            <option value="Cheque">Cheque</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Reference Number</label>
                                        <input type="text" name="transaction_reference" class="form-control" placeholder="Enter reference number">
                                    </div>
                                </div>

                                {{-- Date and Notes --}}
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
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">
                                        Save Contribution
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- ================= CONTRIBUTIONS LIST ================= --}}
<div class="tab-pane fade" id="contributions-section" role="tabpanel" aria-labelledby="contributions-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark">All Contributions</h5>

        {{-- 🔎 Date Filter --}}
        <form method="GET" action="{{ route('stewardship.index') }}" class="d-flex align-items-center gap-2">
            <div>
                <label class="form-label small mb-0">From</label>
                <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control form-control-sm">
            </div>
            <div>
                <label class="form-label small mb-0">To</label>
                <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control form-control-sm">
            </div>
            <div class="mt-3">
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
            </div>
        </form>
    </div>

    {{-- 🧾 Totals Summary --}}
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

                // track totals
                $typeTotals[$type->id] += $amount;
                $churchTotal += $amount * ($type->church_percentage / 100);
                $conferenceTotal += $amount * ($type->conference_percentage / 100);
                $grandTotal += $amount;
            @endphp
        @endforeach
    @endforeach

    {{-- 🧮 Display Church & Conference Totals --}}
    <div class="alert alert-light border rounded-3 mb-4 p-3">
        <div class="row text-center">
            <div class="col-md-4 mb-2 mb-md-0">
                <h6 class="text-muted mb-1">Church Total</h6>
                <h5 class="fw-bold text-success">{{ number_format($churchTotal, 2) }}</h5>
            </div>
            <div class="col-md-4 mb-2 mb-md-0">
                <h6 class="text-muted mb-1">Conference Total</h6>
                <h5 class="fw-bold text-primary">{{ number_format($conferenceTotal, 2) }}</h5>
            </div>
            <div class="col-md-4">
                <h6 class="text-muted mb-1">Overall Total</h6>
                <h5 class="fw-bold text-dark">{{ number_format($grandTotal, 2) }}</h5>
            </div>
        </div>
    </div>

    {{-- 📊 Main Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Member</th>
                    @foreach($contributionTypes as $type)
                        <th>{{ $type->contribution_name }}</th>
                    @endforeach
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($stewardships as $index => $stewardship)
                    @php $rowTotal = 0; @endphp
                    <tr>
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
</div>



                    </div> {{-- End tab content --}}
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= SCRIPTS ================= --}}
<script>
document.addEventListener("DOMContentLoaded", function () {
    const memberList = document.getElementById("memberList");
    const searchInput = document.getElementById("memberSearch");

    // ✅ Real-time search
    searchInput.addEventListener("input", function () {
        const term = this.value.toLowerCase().trim();
        const members = memberList.querySelectorAll(".member-item");
        let anyVisible = false;

        members.forEach(member => {
            const name = member.querySelector("strong")?.textContent.toLowerCase() || "";
            const phone = member.querySelector("small")?.textContent.toLowerCase() || "";
            const visible = name.includes(term) || phone.includes(term);
            member.style.display = visible ? "flex" : "none";
            if (visible) anyVisible = true;
        });

        const noResult = document.getElementById("noResultMsg");
        if (!anyVisible && !noResult) {
            const msg = document.createElement("div");
            msg.id = "noResultMsg";
            msg.className = "text-muted text-center mt-3";
            msg.textContent = "No member found. Add a new one below.";
            memberList.appendChild(msg);
        } else if (anyVisible && noResult) {
            noResult.remove();
        }
    });

    // ✅ Select member
    memberList.addEventListener("click", function (e) {
        if (e.target.classList.contains("select-member-btn")) {
            const id = e.target.dataset.id;
            const name = e.target.dataset.name;
            const phone = e.target.dataset.phone;

            document.getElementById("selectedMemberId").value = id;
            document.getElementById("selectedMemberInfo").innerHTML = `<strong>${name}</strong> (${phone})`;
            closeModal();
        }
    });

    // ✅ Add new member
    document.getElementById("saveNewMember").addEventListener("click", function () {
        const fullName = document.getElementById("new_full_name").value.trim();
        const phone = document.getElementById("new_phone_number").value.trim();
        const email = document.getElementById("new_email").value.trim();
        const dob = document.getElementById("new_dob").value;

        if (!fullName || !phone) {
            alert("Please enter full name and phone number.");
            return;
        }

        document.getElementById("selectedMemberId").value = "new";
        document.getElementById("selectedMemberInfo").innerHTML = `<strong>${fullName}</strong> (${phone})`;

        // Remove old hidden fields
        document.querySelectorAll('input[name^="new_"]').forEach(el => el.remove());

        // Add hidden inputs
        const form = document.querySelector("form");
        form.insertAdjacentHTML("beforeend", `
            <input type="hidden" name="new_full_name" value="${fullName}">
            <input type="hidden" name="new_phone_number" value="${phone}">
            <input type="hidden" name="new_email" value="${email}">
            <input type="hidden" name="new_dob" value="${dob}">
        `);

        closeModal();
    });

    // ✅ Toggle amount fields
    document.querySelectorAll(".contribution-checkbox").forEach(cb => {
        cb.addEventListener("change", function () {
            const field = document.getElementById("amount_" + this.value);
            field.style.display = this.checked ? "block" : "none";
            if (!this.checked) field.querySelector("input").value = "";
        });
    });

   function closeModal() {
    const modalElement = document.getElementById('memberModal');
    const modalInstance = bootstrap.Modal.getInstance(modalElement);
    modalInstance.hide();

    // Wait a bit for animation, then clean up classes
    setTimeout(() => {
        document.body.classList.remove('modal-open');
        document.body.style.overflow = ''; // restore scrolling
        document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
    }, 400);
}

});
</script>
@endsection
