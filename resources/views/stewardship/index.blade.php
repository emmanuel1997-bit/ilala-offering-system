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
                            <form method="POST" action="{{ route('contributions.store') }}" class="needs-validation" novalidate>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const memberList = document.getElementById("memberList");
    const searchInput = document.getElementById("memberSearch");
    const memberModalEl = document.getElementById("memberModal");
    const memberModal = new bootstrap.Modal(memberModalEl);

    // ✅ Search function — always active
    if (searchInput) {
        searchInput.addEventListener("input", function () {
            const term = this.value.toLowerCase().trim();
            const members = memberList.querySelectorAll(".member-item");

            members.forEach(member => {
                const name = member.querySelector("strong")?.textContent.toLowerCase() || "";
                const phone = member.querySelector("small")?.textContent.toLowerCase() || "";
                member.style.display = (name.includes(term) || phone.includes(term)) ? "flex" : "none";
            });
        });
    }

    // ✅ Focus input when modal opens
    memberModalEl.addEventListener("shown.bs.modal", () => {
        searchInput.focus();
    });

    // ✅ Select member from list
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

        // Add hidden inputs to form
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

    // ✅ Close modal properly
    function closeModal() {
        memberModal.hide();
        setTimeout(() => {
            document.body.classList.remove("modal-open");
            document.querySelectorAll(".modal-backdrop").forEach(el => el.remove());
        }, 300);
    }
});
</script>






@endsection
