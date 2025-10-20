


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
                    <th>Church %</th>
                    <th>Conference %</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contributions as $type)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $type->contribution_name }}</td>
                    <td>{{ $type->church_percentage }}%</td>
                    <td>{{ $type->conference_percentage }}%</td>
                    <td>{{ $type->description }}</td>
                    <td>
                        <!-- Edit Button -->
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editContributionModal-{{ $type->id }}">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Delete Form -->
                        <form action="{{ route('contributions.destroy', $type->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                        </form>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editContributionModal-{{ $type->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form action="{{ route('contributions.update', $type->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Contribution Type</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Type Name</label>
                                        <input type="text" name="contribution_name" value="{{ $type->contribution_name }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Church Percentage</label>
                                        <input type="number" name="church_percentage" value="{{ $type->church_percentage }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Conference Percentage</label>
                                        <input type="number" name="conference_percentage" value="{{ $type->conference_percentage }}" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control">{{ $type->description }}</textarea>
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

                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Modal -->
    <div class="modal fade" id="createContributionModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('contributions.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Add Contribution Type</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Type Name</label>
                            <input type="text" name="contribution_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Church Percentage</label>
                            <input type="number" name="church_percentage" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Conference Percentage</label>
                            <input type="number" name="conference_percentage" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Add Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endif
</div>