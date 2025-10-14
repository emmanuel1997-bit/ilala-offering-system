
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Sidebar Navigation -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    @php
                        $tabs = [
                            ['id' => 'roles', 'icon' => 'users-cog', 'label' => 'Role Management'],
                            ['id' => 'users', 'icon' => 'user', 'label' => 'User Management'],
                        ];
                    @endphp
                    <ul class="nav flex-column nav-pills py-3" id="userTab" role="tablist">
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
                    <h4 class="fw-semibold text-dark mb-1">User & Role Management</h4>
                    <p class="text-muted mb-0">
                        Manage system roles and user assignments efficiently.
                    </p>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="userTabContent">
                        {{-- ========================== ROLES SECTION ========================== --}}
                        <div class="tab-pane fade show active" id="roles-section" role="tabpanel" aria-labelledby="roles-tab">
                              


                            <div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="fw-bold text-dark">Roles</h5>
    <button 
        class="btn text-white btn-sm" 
        style="background-color: #064e3b; border-color: #064e3b;" 
        data-bs-toggle="modal" 
        data-bs-target="#createRoleModal"
    >
        <i class="fas fa-plus me-1"></i> Add Role
    </button>
</div>

                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Role Name</th>
                                            <th>Permissions</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($roles as $role)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                {{ $role->permissions->pluck('name')->join(', ') }}
                                            </td>
                                            <td>
                                               <td>
                                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->id }}">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{-- ========================== USERS SECTION ========================== --}}
                        <div class="tab-pane fade" id="users-section" role="tabpanel" aria-labelledby="users-tab">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark">Users</h5>
                                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
                                    <i class="fas fa-user-plus me-1"></i> Create User
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Roles</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                {{ 
                                            $user->roles->pluck('name')->join(', ') 
                                            }}
                                            </td>
                                           <td>
    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#assignRoleModal-{{ $user->id }}">
        <i class="fas fa-user-plus"></i> Assign/Unassign Roles
    </button>

    <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
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
                        </div>
                    </div> <!-- end tab-content -->
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ========================== MODALS ========================== --}}
<!-- Create Role Modal -->
<!-- Create/Edit Role Modal -->
<div class="modal fade" id="createRoleModal" tabindex="-1" aria-labelledby="createRoleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('roles.createRole') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createRoleModalLabel">Create Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Permissions</label>
                    <div class="d-flex flex-wrap gap-2">
                       
                   
                       @foreach(\App\Models\Permission::all() as $permission)
                        <label class="form-check-label border p-2 rounded">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="form-check-input me-1">
                            {{ $permission->name }}
                        </label>
                        @endforeach

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Create</button>
            </div>
        </form>
    </div>
</div>
//edit  role  model

@foreach($roles as $role)
<div class="modal fade" id="editRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('roles.update', $role->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Edit Role: {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Role Name</label>
                    <input type="text" name="name" value="{{ $role->name }}" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Permissions</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach(\App\Models\Permission::all() as $permission)
                        <label class="form-check-label border p-2 rounded">
                            <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                                class="form-check-input me-1"
                                {{ $role->permissions->contains($permission->id) ? 'checked' : '' }}>
                            {{ $permission->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Update</button>
            </div>
        </form>
    </div>
</div>
@endforeach


@foreach($users as $user)
<div class="modal fade" id="assignRoleModal-{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('roles.assignToUser', $user->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Assign Roles to: {{ $user->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-wrap gap-2">
                    @foreach($roles as $role)
                    <label class="form-check-label border p-2 rounded">
                        <input type="checkbox" name="roles[]" value="{{ $role->id }}"
                            class="form-check-input me-1"
                            {{ $user->roles->contains($role->id) ? 'checked' : '' }}>
                        {{ $role->name }}
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Update Roles</button>
            </div>
        </form>
    </div>
</div>
@endforeach


<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('users.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Assign Roles</label>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($roles as $role)
                        <label class="form-check-label border p-2 rounded">
                            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input me-1">
                            {{ $role->name }}
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Create</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="assignRoleModal-{{ $role->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('roles.assignToUser', $role->id) }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">Assign Role: {{ $role->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <label class="form-label">Select Users</label>
                <div class="d-flex flex-column gap-2">
                    @foreach($users as $user)
                    <label class="form-check-label border p-2 rounded">
                        <input type="checkbox" name="users[]" value="{{ $user->id }}" class="form-check-input me-1"
                            @if($user->roles->contains($role->id)) checked @endif>
                        {{ $user->name }} ({{ $user->email }})
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Assign</button>
            </div>
        </form>
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Assign Roles</label>
    <div class="d-flex flex-wrap gap-2">
        @foreach($roles as $role)
        <label class="form-check-label border p-2 rounded">
            <input type="checkbox" name="roles[]" value="{{ $role->id }}" class="form-check-input me-1"
                @if(old('roles') && in_array($role->id, old('roles'))) checked @endif>
            {{ $role->name }}
        </label>
        @endforeach
    </div>
</div>

<style>
/* Fix invisible input fields in modal */
.modal .form-control {
    background-color: #fff !important;
    color: #000 !important;
    border: 1px solid #ccc !important;
}

.modal label {
    color: #064e3b !important;
    font-weight: 500;
}

.modal-content {
    background-color: #fefefe !important;
    border-radius: 0.75rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.2);
}

.modal-backdrop.show {
    opacity: 0.7;
}
</style>


<style>
    .nav-pills .nav-link {
        font-weight: 400;
        font-size: 1rem;
        border-radius: 0.5rem;
        transition: background 0.2s;
        color: #222 !important;
        background: #fff;
    }
    .nav-pills .nav-link.active {
        background: #064e3b !important;
        color: #fff !important;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .card-header {
        background: #f8f9fa;
    }
    .btn-primary {
        background-color: #064e3b !important;
        border-color: #064e3b !important;
    }
</style>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const triggerTabList = [].slice.call(document.querySelectorAll('#userTab button'))
    triggerTabList.forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function (event) {
            localStorage.setItem('activeUserTab', event.target.id);
        });
    });

    const activeTab = localStorage.getItem('activeUserTab');
    if (activeTab) {
        const tabEl = document.getElementById(activeTab);
        const tab = new bootstrap.Tab(tabEl);
        tab.show();
    }
});
</script>

@endsection
