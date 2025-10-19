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

                            <form id="registerMemberForm" action="{{ route('members.store') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                @csrf

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Full Name</label>
                                        <input type="text" name="full_name" class="form-control" required>
                                        <div class="invalid-feedback">Full Name is required.</div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Phone Number</label>
                                        <div class="input-group">
                                            <input type="text" id="phone_number" name="phone_number" class="form-control" required>
                                            <div class="invalid-feedback">Phone Number is required.</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label class="form-label">Membership Number</label>
                                        <input type="text" name="membership_number" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Marital Status</label>
                                        <select name="marital_status" class="form-select" >
                                            <option value="">Select Marital Status</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Divorced">Divorced</option>
                                        </select>
                                        <div class="invalid-feedback">Marital Status is required.</div>
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
                                        <div class="invalid-feedback">Gender is required.</div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Date of Baptism</label>
                                        <input type="date" name="baptism_date" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Baptism Status</label>
                                        <select name="baptism_status" class="form-select">
                                            <option value="Active">Active</option>
                                            <option value="Inactive">Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Address</label>
                                    <textarea name="address" rows="2" class="form-control" ></textarea>
                                    <div class="invalid-feedback">Address is required.</div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Member Photo</label>
                                    <input type="file" name="photo" class="form-control" accept="image/*">
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn text-white px-4" style="background-color:#064e3b;">
                                        <i class="fas fa-save me-1"></i> Save Member
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- ====================== ALL MEMBERS SECTION ====================== --}}
                       <div class="tab-pane fade" id="members-section" role="tabpanel" aria-labelledby="members-tab">
    <h5 class="fw-bold text-dark mb-3">All Registered Members</h5>
    <div class="d-flex mb-2">
        <div class="ms-auto">
            <button id="exportExcelBtn" class="btn btn-success btn-sm me-2">
                <i class="fas fa-file-excel"></i> Export Excel
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="membersTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Membership ID</th>
                    <th>Gender</th>
                    <th>Photo</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($members as $member)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>  <div> {{ $member->full_name }}</div><div>{{ $member->phone_number }}</div></td>
                    <td>{{ $member->membership_number }}</td>
                    <td>{{ $member->gender }}</td>

                    <td>
                        @if($member->photo)
                            <img src="{{ Storage::url($member->photo) }}" width="50" height="50" class="rounded-circle border" style="cursor:pointer;"
                                 data-bs-toggle="modal" data-bs-target="#photoModal{{ $member->id }}">

                            <div class="modal fade" id="photoModal{{ $member->id }}" tabindex="-1" aria-labelledby="photoModalLabel{{ $member->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="photoModalLabel{{ $member->id }}">{{ $member->full_name }}'s Photo</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ Storage::url($member->photo) }}" class="img-fluid rounded">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <span class="text-muted">No Photo</span>
                        @endif
                    </td>

                    <!-- Actions -->
                    <td>
                        <!-- View -->
                        <button type="button" class="btn btn-info btn-sm mb-1 view-member" data-member='@json($member)'>
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Edit -->
                        <button type="button" class="btn btn-primary btn-sm mb-1 edit-member" data-member='@json($member)'>
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Reset PIN -->
                        <button type="button" class="btn btn-secondary btn-sm mb-1 reset-pin" data-member-id="{{ $member->id }}">
                            <i class="fas fa-key"></i>
                        </button>

                        <!-- Delete -->
                       <form action="{{ route('members.destroy', $member->id) }}" method="POST" class="d-inline delete-member-form" data-member-id="{{ $member->id }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-1">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>


                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>





{{-- Toast container --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="memberToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="memberToastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>


{{-- JS --}}

@include('member.sabath-school')
<script>

    $(document).ready(function() {
    $('#membersTable').DataTable({
        responsive: true,
        pageLength: 10,
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: [4,5] } // Photo and Action columns
        ]
    });
});



    // Sabbath School members load
    $('#ssSelect').change(function() {
        let ssId = $(this).val();
        $('#modalSsId').val(ssId);
        let tbody = $('#ssMembersTable tbody').empty();

        if(ssId) {
            $.get(`/sabbath-school/${ssId}/members`, function(data) {
                data.forEach((member, index) => {
                    tbody.append(`
                        <tr>
                            <td>${index + 1}</td>
                            <td>${member.full_name}</td>
                            <td>${member.phone_number}</td>
                            <td>${member.gender}</td>
                            <td>${member.photo ? '<img src="'+member.photo+'" width="50" height="50" class="rounded-circle">' : '<span class="text-muted">No Photo</span>'}</td>
                            <td>${member.role || '-'}</td>
                            <td><button class="btn btn-danger btn-sm remove-member" data-member-id="${member.id}">Remove</button></td>
                        </tr>
                    `);
                });
            });
        }
    });

    // Register member form AJAX
    $('#registerMemberForm').submit(function(e){
        e.preventDefault();
        let formData = new FormData(this);
        $.ajax({
            url: $(this).attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response){
                window.showMemberToast(response.message || 'Saved', 'success');
                $('#registerMemberForm')[0].reset();
                $('#registerMemberForm').removeClass('was-validated');
            },
            error: function(xhr){
                let msg = 'Failed to save member.';
                if(xhr.responseJSON && xhr.responseJSON.errors){
                    msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                }
                window.showMemberToast(msg, 'danger');
            }
        });
    });

    // expose a global toast helper so all scripts can use it
    window.showMemberToast = function(message, type){
        let toastEl = $('#memberToast');
        toastEl.removeClass('bg-success bg-danger');
        toastEl.addClass(type === 'success' ? 'bg-success' : 'bg-danger');
        $('#memberToastMessage').text(message);
        let toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
    }

</script>
<!-- Consolidated scripts: form validation, phone init, and persistent tab handling -->
<script>
// Bootstrap form validation (unchanged)
(function () {
  'use strict'
  var forms = document.querySelectorAll('.needs-validation')
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }
        form.classList.add('was-validated')
      }, false)
    })
})();

// Phone number initializer (if available)
setTimeout(() => {
    if (typeof initiatePhoneNumber === 'function') {
        initiatePhoneNumber("#phone_number");
    }
}, 1000);

// Persist active member tab using Bootstrap tab API
document.addEventListener('DOMContentLoaded', function () {
    const tabButtons = document.querySelectorAll('#memberTab .nav-link');
    const savedTab = localStorage.getItem('activeMemberTab');

    // Restore saved tab (saved key is stored without the '-tab' suffix)
    if (savedTab) {
        const tabBtn = document.getElementById(`${savedTab}-tab`);
        if (tabBtn) {
            try {
                // Use Bootstrap's Tab API to show the tab properly
                new bootstrap.Tab(tabBtn).show();
            } catch (e) {
                // fallback: toggle classes
                tabButtons.forEach(btn => btn.classList.remove('active'));
                document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('show', 'active'));
                tabBtn.classList.add('active');
                const pane = document.getElementById(`${savedTab}-section`);
                if (pane) { pane.classList.add('show', 'active'); }
            }
        }
    }

    // Save tab to localStorage when shown (store id without '-tab')
    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function (event) {
            const id = event.target.id.replace('-tab', '');
            localStorage.setItem('activeMemberTab', id);
        });
    });
});
</script>
<!-- View Member Modal -->
<div class="modal fade" id="viewMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="viewMemberPhoto" src="" class="rounded-circle" width="120" height="120">
                </div>
                <p><strong>Name:</strong> <span id="viewName"></span></p>
                <p><strong>Phone:</strong> <span id="viewPhone"></span></p>
                <p><strong>Email:</strong> <span id="viewEmail"></span></p>
                <p><strong>Gender:</strong> <span id="viewGender"></span></p>
                <p><strong>Address:</strong> <span id="viewAddress"></span></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Member Modal -->
<!-- Edit Member Modal -->
<div class="modal fade" id="editMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editMemberForm" method="POST" enctype="multipart/form-data" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Member</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="member_id" id="editMemberId">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="full_name" id="editFullName" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="editPhone" class="form-control" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Membership Number</label>
                            <input type="text" name="membership_number" id="editMembershipNumber" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Marital Status</label>
                            <select name="marital_status" id="editMaritalStatus" class="form-select">
                                <option value="">Select Marital Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" id="editEmail" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" id="editDOB" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Gender</label>
                            <select name="gender" id="editGender" class="form-select" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Date of Baptism</label>
                            <input type="date" name="baptism_date" id="editBaptismDate" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Baptism Status</label>
                            <select name="baptism_status" id="editBaptismStatus" class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" id="editAddress" rows="2" class="form-control"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Member Photo</label>
                        <input type="file" name="photo" id="editPhoto" class="form-control" accept="image/*">
                        <div class="mt-2">
                            <img id="currentPhotoPreview" src="" width="80" height="80" class="rounded-circle">
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Image preview modal -->
<div class="modal fade" id="imagePreviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="previewImageLarge" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
        // View member
        $(document).on('click', '.view-member', function(){
                let m = $(this).data('member');
                $('#viewName').text(m.full_name || '-');
                $('#viewPhone').text(m.phone_number || '-');
                $('#viewEmail').text(m.email || '-');
                $('#viewGender').text(m.gender || '-');
                $('#viewAddress').text(m.address || '-');
                if(m.photo){
                        $('#viewMemberPhoto').attr('src', m.photo.startsWith('http') ? m.photo : ('/storage/' + m.photo));
                } else {
                        $('#viewMemberPhoto').attr('src', '/storage/images/default-avatar.png');
                }
                new bootstrap.Modal(document.getElementById('viewMemberModal')).show();
        });

        // Edit member (open modal and populate)
      $(document).on('click', '.edit-member', function() {
    let member = $(this).data('member');

    $('#editMemberId').val(member.id);
    $('#editFullName').val(member.full_name);
    $('#editPhone').val(member.phone_number);
    $('#editMembershipNumber').val(member.membership_number);
    $('#editMaritalStatus').val(member.marital_status);
    $('#editEmail').val(member.email);
    $('#editDOB').val(member.dob);
    $('#editGender').val(member.gender);
    $('#editBaptismDate').val(member.baptism_date);
    $('#editBaptismStatus').val(member.baptism_status);
    $('#editAddress').val(member.address);
    $('#currentPhotoPreview').attr('src', member.photo ? member.photo : '');

    // Update form action
    $('#editMemberForm').attr('action', `/members/${member.id}`);

    // Show modal
    $('#editMemberModal').modal('show');
});


        // Submit edit form via AJAX
        $('#editMemberForm').submit(function(e){
                e.preventDefault();
                let form = this;
                let action = $(form).attr('action');
                let data = new FormData(form);
                $.ajax({
                        url: action,
                        method: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                success: function(res){
                    window.showMemberToast(res.message || 'Member updated', 'success');
                    setTimeout(function(){ location.reload(); }, 900);
                },
                error: function(xhr){
                    let msg = 'Failed to update member.';
                    if(xhr && xhr.responseJSON && xhr.responseJSON.errors){
                        msg = Object.values(xhr.responseJSON.errors).flat().join(' ');
                    }
                    window.showMemberToast(msg, 'danger');
                }
                });
        });

        // Reset PIN
        $(document).on('click', '.reset-pin', function(){
                let memberId = $(this).data('member-id');
                if(!confirm('Reset PIN for this member?')) return;
        $.post(`/members/${memberId}/reset-pin`, {_token: '{{ csrf_token() }}'}, function(res){
            window.showMemberToast(res.message || 'PIN reset', 'success');
        }).fail(function(xhr){
            let msg = 'Failed to reset PIN';
            if(xhr && xhr.responseJSON && xhr.responseJSON.message) msg = xhr.responseJSON.message;
            window.showMemberToast(msg, 'danger');
        });
        });

        // Image click -> preview
        $(document).on('click', 'td img', function(){
                let src = $(this).attr('src');
                if(src){
                        $('#previewImageLarge').attr('src', src);
                        new bootstrap.Modal(document.getElementById('imagePreviewModal')).show();
                }
        });
});


</script>


<script>
$(document).ready(function() {
    function showToast(message, type = 'success') {
        let toastEl = $('#memberToast');
        toastEl.removeClass('bg-success bg-danger');
        toastEl.addClass(type === 'success' ? 'bg-success' : 'bg-danger');
        $('#memberToastMessage').text(message);
        let toast = new bootstrap.Toast(toastEl[0]);
        toast.show();
    }

    // AJAX delete
    $('.delete-member-form').submit(function(e) {
        e.preventDefault();
        if (!confirm('Delete this member?')) return;

        let form = $(this);
        let url = form.attr('action');

        $.ajax({
            url: url,
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                showToast('Member deleted successfully', 'success');
                // Remove the deleted row from the table
                form.closest('tr').fadeOut(500, function() { $(this).remove(); });
            },
            error: function(xhr) {
                let msg = 'Failed to delete member.';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                showToast(msg, 'danger');
            }
        });
    });
});
</script>


@endsection
