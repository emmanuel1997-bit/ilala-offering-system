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