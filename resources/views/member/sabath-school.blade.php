{{-- ====================== SABBATH SCHOOL SECTION ====================== --}}
<div class="tab-pane fade" id="ss-section" role="tabpanel" aria-labelledby="ss-tab">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Sabbath School Classes</h5>
        <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#createSSModal">
            <i class="fas fa-plus me-1"></i> New Sabbath School
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle" id="ssTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Division</th>
                    <th>Teacher Name</th>
                    <th>Meeting Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($schools as $index => $ss)
                <tr id="ssRow{{ $ss->id }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ss->name }}</td>
                    <td>{{ $ss->division ?? '—' }}</td>
                    <td>{{ $ss->meeting_location ?? '—' }}</td>
                    <td>{{ $ss->meeting_time ?? '—' }}</td>
                    <td>
                        @if($ss->is_active)
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-secondary">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm edit-ss" data-ss='@json($ss)'>
                            <i class="fas fa-edit"></i>
                        </button>
                         <a href="{{ route('members.sabbath-schools.show', $ss->id) }}" class="btn btn-info btn-sm">
                         <i class="fas fa-eye"></i>
                         </a>
                        <button type="button" class="btn btn-danger btn-sm delete-ss" data-id="{{ $ss->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- 🟢 Toast for Feedback -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
    <div id="ssToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body" id="ssToastMessage"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

<!-- 🟢 Create Sabbath School Modal -->
<div class="modal fade" id="createSSModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="createSSForm" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Sabbath School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code</label>
                            <input type="text" name="code" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Division</label>
                            <input type="text" name="division" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meeting Location</label>
                            <input type="text" name="meeting_location" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Meeting Time</label>
                            <input type="text" name="meeting_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select name="is_active" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">
                        <i class="fas fa-save me-1"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- 🟢 Edit Sabbath School Modal -->
<div class="modal fade" id="editSSModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="editSSForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sabbath School</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <input type="hidden" id="editSsId" name="id">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" id="editSsName" name="name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Code</label>
                            <input type="text" id="editSsCode" name="code" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Division</label>
                            <input type="text" id="editSsDivision" name="division" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Meeting Location</label>
                            <input type="text" id="editSsLocation" name="meeting_location" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Meeting Time</label>
                            <input type="text" id="editSsTime" name="meeting_time" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status</label>
                            <select id="editSsStatus" name="is_active" class="form-select">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea id="editSsDescription" name="description" rows="2" class="form-control"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(function() {
    const toast = new bootstrap.Toast($('#ssToast')[0]);

    function showToast(message) {
        $('#ssToastMessage').text(message);
        toast.show();
    }

    // 🟢 CREATE Sabbath School
    $('#createSSForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('sabbath-schools.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                $('#createSSModal').modal('hide');
                showToast('Sabbath School created successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(xhr) {
                alert('Failed to create Sabbath School');
            }
        });
    });

    // 🟢 OPEN EDIT MODAL
    $(document).on('click', '.edit-ss', function() {
        let ss = $(this).data('ss');
        $('#editSsId').val(ss.id);
        $('#editSsName').val(ss.name);
        $('#editSsCode').val(ss.code);
        $('#editSsDivision').val(ss.division);
        $('#editSsLocation').val(ss.meeting_location);
        $('#editSsTime').val(ss.meeting_time);
        $('#editSsStatus').val(ss.is_active ? 1 : 0);
        $('#editSsDescription').val(ss.description);
        $('#editSSForm').attr('action', `/sabbath-schools/${ss.id}`);
        $('#editSSModal').modal('show');
    });

    // 🟢 UPDATE Sabbath School
    $('#editSSForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editSsId').val();
        $.ajax({
            url: `/sabbath-schools/edit/${id}`,
            method: "POST",
            data: $(this).serialize(),
            success: function(res) {
                $('#editSSModal').modal('hide');
                showToast('Sabbath School updated successfully!');
                setTimeout(() => location.reload(), 1000);
            },
            error: function() {
                alert('Failed to update Sabbath School');
            }
        });
    });

    // 🟢 DELETE Sabbath School
    $(document).on('click', '.delete-ss', function() {
        if (!confirm('Delete this Sabbath School?')) return;
        const id = $(this).data('id');
        $.ajax({
            url: `/sabbath-schools/delete/${id}`,
            method: "DELETE",
            data: { _token: "{{ csrf_token() }}" },
            success: function() {
                $(`#ssRow${id}`).remove();
                showToast('Sabbath School deleted successfully!');
            },
            error: function() {
                alert('Failed to delete Sabbath School');
            }
        });
    });
});
</script>
@endpush
