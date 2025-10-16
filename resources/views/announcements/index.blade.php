@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-header d-flex justify-content-between align-items-center bg-white">
            <h4 class="fw-semibold text-dark mb-0">Announcements Dashboard</h4>
            <button class="btn text-white" style="background-color:#064e3b;" data-bs-toggle="modal" data-bs-target="#addAnnouncementModal">
                <i class="fas fa-plus me-1"></i> Add Announcement
            </button>
        </div>
        <div class="card-body">

            <!-- Existing Announcements List -->
            <div class="row g-4">
                @forelse($announcements as $announcement)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 h-100">
                        <!-- Image or Placeholder -->
                        @if($announcement->image)
                        <img src="{{ asset('storage/'.$announcement->image) }}" class="card-img-top" style="height:200px; object-fit:cover;" alt="Announcement Image">
                        @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" style="height:200px; object-fit:cover;" alt="Placeholder Image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $announcement->title }}</h5>
                            <p class="card-text">{{ $announcement->description }}</p>
                            <p class="text-muted mb-0"><strong>Publish Date:</strong> {{ $announcement->publish_date }}</p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <a href="" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <form action="{{ route('announcements.destroy', $announcement->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">No announcements found.</div>
                </div>
                @endforelse
            </div>

        </div>
    </div>
</div>

<!-- Add Announcement Modal -->
<div class="modal fade" id="addAnnouncementModal" tabindex="-1" aria-labelledby="addAnnouncementLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form action="{{ route('announcements.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title">New Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Publish Date</label>
                    <input type="date" name="publish_date" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image (optional)</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn text-white" style="background-color:#064e3b;">Publish</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection
