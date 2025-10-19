@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-dark">{{ $school->name }} - Details</h4>
        <a href="{{ route('members.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <h5 class="fw-bold mb-3 text-success">Class Information</h5>
            <div class="row">
                <div class="col-md-4"><strong>Sabbath school name:</strong> {{ $school->name ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Division:</strong> {{ $school->division ?? 'N/A' }}</div>
                <div class="col-md-4"><strong>Status:</strong>
                    <span class="badge bg-{{ $school->is_active ? 'success' : 'secondary' }}">
                        {{ $school->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6"><strong>Meeting Time:</strong> {{ $school->meeting_time ?? 'N/A' }}</div>
                <div class="col-md-6"><strong>Location:</strong> {{ $school->meeting_location ?? 'N/A' }}</div>
            </div>
            <div class="mt-3"><strong>Description:</strong> {{ $school->description ?? 'No description provided.' }}</div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="fw-bold text-dark mb-0">Members in this Class</h5>
        <button class="btn text-white btn-sm" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#addMemberModal">
            <i class="fas fa-user-plus me-1"></i> Add Member
        </button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Full Name</th>
                    <th>Phone</th>
                    <th>Gender</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $member->full_name }}</td>
                        <td>{{ $member->phone_number }}</td>
                        <td>{{ $member->gender }}</td>
                        <td>{{ $member->pivot->role ?? 'Member' }}</td>
                        <td>
                            <form action="{{ route('sabbath-schools.removeMember', [$school->id, $member->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Remove this member?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted">No members in this class yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Add Member Modal -->
<div class="modal fade" id="addMemberModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="POST" action="{{ route('sabbath-schools.addMember', $school->id) }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Member to {{ $school->name }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <!-- Select Member -->
                    <div class="mb-3">
                        <label class="form-label">Select Member</label>
                        <select name="member_id" class="form-select" required>
                            <option value="">-- Select Member --</option>
                            @foreach($allMembers as $m)
                                <option value="{{ $m->id }}">{{ $m->full_name }} ({{ $m->phone_number }})</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select Role -->
                    <div class="mb-3">
                        <label class="form-label">Assign Role</label>
                        <select name="role" class="form-select" required>
                            <option value="">-- Select Role --</option>
                            <option value="Chairman">Chairman</option>
                            <option value="Secretary">Secretary</option>
                            <option value="Spiritual Leader">Spiritual Leader</option>
                            <option value="Treasurer">Treasurer</option>
                            <option value="Member">Member</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-success" type="submit">Add Member</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

