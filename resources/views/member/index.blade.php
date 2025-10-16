@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    <ul class="nav flex-column nav-pills py-3" id="memberTab" role="tablist">
                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start active"
                                id="register-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#register-section"
                                type="button"
                                role="tab"
                                aria-controls="register-section"
                                aria-selected="true">
                                <i class="fas fa-user-plus me-2" style="color:#064e3b;"></i>
                                Register Member
                            </button>
                        </li>

                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start"
                                id="members-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#members-section"
                                type="button"
                                role="tab"
                                aria-controls="members-section"
                                aria-selected="false">
                                <i class="fas fa-users me-2" style="color:#064e3b;"></i>
                                All Members
                            </button>
                        </li>

                        <li class="nav-item mb-1">
                            <button class="nav-link w-100 text-start"
                                id="ss-tab"
                                data-bs-toggle="pill"
                                data-bs-target="#ss-section"
                                type="button"
                                role="tab"
                                aria-controls="ss-section"
                                aria-selected="false">
                                <i class="fas fa-school me-2" style="color:#064e3b;"></i>
                                Sabbath School
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-12 col-md-8 col-lg-9">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-header bg-white border-bottom-0 pb-0">
                    <h4 class="fw-semibold text-dark mb-1">Church Member Management</h4>
                    <p class="text-muted mb-0">Manage members and Sabbath School classes.</p>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="memberTabContent">

                        {{-- ====================== REGISTER MEMBER SECTION ====================== --}}
                        <div class="tab-pane fade show active" id="register-section" role="tabpanel" aria-labelledby="register-tab">
                            <h5 class="fw-bold text-dark mb-3">Register New Member</h5>

                            <form action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <input type="text" name="phone_number" class="form-control" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Date of Birth</label>
                                        <input type="date" name="dob" class="form-control">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Gender</label>
                                        <select name="gender" class="form-select" required>
                                            <option value="">Select Gender</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Ministry</label>
                                        <select name="ministry_id" class="form-select">
                                            <option value="">Select Ministry</option>
                                            @foreach($ministries as $ministry)
                                                <option value="{{ $ministry->id }}">{{ $ministry->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Sabbath School Class</label>
                                        <select name="sabbath_school_id" class="form-select">
                                            <option value="">Select SS Class</option>
                                            @foreach($sabbathSchools as $ss)
                                                <option value="{{ $ss->id }}">{{ $ss->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="2" class="form-control" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Member Photo</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">
                                        <i class="fas fa-save me-1"></i> Save Member
                                    </button>
                                </div>
                            </form>
                        </div>

                       {{-- ====================== ALL MEMBERS SECTION ====================== --}}
<div class="tab-pane fade" id="members-section" role="tabpanel" aria-labelledby="members-tab">
    <h5 class="fw-bold text-dark mb-3">All Registered Members</h5>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="membersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Ministry</th>
                    <th>Sabbath School</th>
                    <th>Gender</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $member->full_name }}</td>
                    <td>{{ $member->email ?? '-' }}</td>
                    <td>{{ $member->phone_number }}</td>
                    <td>{{ $member->ministry->name ?? '-' }}</td>
                    <td>{{ $member->sabbathSchool->name ?? '-' }}</td>
                    <td>{{ $member->gender }}</td>
                    <td>
                        @if($member->photo)
                            <img src="{{ asset($member->photo) }}" alt="Photo" width="50" height="50" class="rounded-circle">
                        @else
                            <span class="text-muted">No Photo</span>
                        @endif
                    </td>
                    <td>
                        <button class="btn btn-warning btn-sm"><i class="fas fa-edit"></i></button>
                        <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this member?')">
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
</div>
{{-- ====================== SABBATH SCHOOL SECTION ====================== --}}
<div class="tab-pane fade" id="ss-section" role="tabpanel" aria-labelledby="ss-tab">

    <h5 class="fw-bold text-dark mb-3">Sabbath School Classes</h5>

    {{-- Select Sabbath School --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label class="form-label">Select Sabbath School Class</label>
            <select id="ssSelect" class="form-select">
                <option value="">-- Select Class --</option>
                @foreach($sabbathSchools as $ss)
                    <option value="{{ $ss->id }}">{{ $ss->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 d-flex align-items-end">
            <button class="btn text-white ms-auto" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#addMemberToSSModal">
                <i class="fas fa-user-plus me-1"></i> Add Member to Class
            </button>
        </div>
    </div>

    {{-- Members Table --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="ssMembersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Ministry</th>
                    <th>Photo</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- Members will be dynamically populated via JS --}}
            </tbody>
        </table>
    </div>

</div>

{{-- ====================== ADD MEMBER TO SABBATH SCHOOL MODAL ====================== --}}
<div class="modal fade" id="addMemberToSSModal" tabindex="-1" aria-labelledby="addMemberToSSModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="addMemberToSSForm" method="POST" action="">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="addMemberToSSModalLabel">Add Member to Sabbath School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" name="ss_id" id="modalSsId">

                    <div class="mb-3">
                        <label class="form-label">Select Member</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Select Member --</option>
                            @foreach($members as $member)
                                <option value="{{ $member->id }}">{{ $member->full_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Assign Role</label>
                        <select name="role" class="form-select">
                            <option value="">-- None --</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>

                    </div> <!-- end tab content -->
                </div>
            </div>
        </div>

    </div>
</div>

<script>
$('#ssSelect').change(function() {
    let ssId = $(this).val();
    $('#modalSsId').val(ssId); // update modal hidden input
    let tbody = $('#ssMembersTable tbody');
    tbody.empty();

    if(ssId) {
        $.get(`/sabbath-school/${ssId}/members`, function(data) {
            data.forEach((member, index) => {
                tbody.append(`
                    <tr>
                        <td>${index + 1}</td>
                        <td>${member.full_name}</td>
                        <td>${member.phone_number}</td>
                        <td>${member.gender}</td>
                        <td>${member.ministry?.name || '-'}</td>
                        <td>${member.photo ? '<img src="/'+member.photo+'" width="50" height="50" class="rounded-circle">' : '<span class="text-muted">No Photo</span>'}</td>
                        <td>${member.role || '-'}</td>
                        <td>
                            <button class="btn btn-danger btn-sm remove-member" data-member-id="${member.id}">Remove</button>
                        </td>
                    </tr>
                `);
            });
        });
    }
});
</script>
<script>
$(document).ready(function() {
    $('#membersTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']], // default sort by Name
        columnDefs: [
            { orderable: false, targets: [7,8] } // disable sorting for Photo and Action columns
        ]
    });
});
</script>
@endsection
