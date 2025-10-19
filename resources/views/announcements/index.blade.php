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
                        @if($announcement->image_url)
                        <img src="{{ asset('storage/'.$announcement->image_url) }}" class="card-img-top" style="height:200px; object-fit:cover;" alt="Announcement Image">
                        @else
                        <img src="https://via.placeholder.com/400x200?text=No+Image" class="card-img-top" style="height:200px; object-fit:cover;" alt="Placeholder Image">
                        @endif

                        <div class="card-body">
                            <h5 class="card-title">{{ $announcement->title }}</h5>
                            <p class="card-text">{{ $announcement->content }}</p>
                            <p class="text-muted mb-0"><strong>Publish Date:</strong> {{ optional($announcement->publish_date)->format('Y-m-d') }}</p>
                            @if($announcement->expiry_date)
                            <p class="text-muted mb-0"><strong>Expires:</strong> {{ optional($announcement->expiry_date)->format('Y-m-d') }}</p>
                            @endif
                            <p class="text-muted mb-0"><strong>Status:</strong>
                                <span class="{{ $announcement->is_published ? 'text-success' : 'text-danger' }}">
                                    {{ $announcement->is_published ? 'Published' : 'Unpublished' }}
                                </span>
                            </p>
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <button
                                class="btn btn-warning btn-sm edit-btn"
                                data-id="{{ $announcement->id }}"
                                data-title="{{ $announcement->title }}"
                                data-content="{{ $announcement->content }}"
                                data-category="{{ $announcement->category }}"
                                data-publish_date="{{ optional($announcement->publish_date)->format('Y-m-d') }}"
                                data-expiry_date="{{ optional($announcement->expiry_date)->format('Y-m-d') }}"
                                data-is_published="{{ $announcement->is_published }}"
                                data-image="{{ $announcement->image_url ? asset('storage/'.$announcement->image_url) : '' }}">
                                <i class="fas fa-edit"></i> Edit
                            </button>

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
                    <label class="form-label">Category</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g. General, Event, Update">
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" class="form-control" rows="4" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="date" name="publish_date" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date (optional)</label>
                        <input type="date" name="expiry_date" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image (optional)</label>
                    <input type="file" name="image_url" class="form-control" accept="image/*">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="isPublishedSwitch" checked>
                    <label class="form-check-label" for="isPublishedSwitch">Publish Immediately</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn text-white" style="background-color:#064e3b;">Publish</button>
            </div>
        </form>
    </div>
  </div>
</div>

<!-- Edit Announcement Modal -->
<div class="modal fade" id="editAnnouncementModal" tabindex="-1" aria-labelledby="editAnnouncementLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <form id="editAnnouncementForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="modal-header">
                <h5 class="modal-title">Edit Announcement</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editAnnouncementId">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <input type="text" name="category" id="editCategory" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Content</label>
                    <textarea name="content" id="editContent" class="form-control" rows="4" required></textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Publish Date</label>
                        <input type="date" name="publish_date" id="editPublishDate" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Expiry Date (optional)</label>
                        <input type="date" name="expiry_date" id="editExpiryDate" class="form-control">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Current Image</label>
                    <img id="editImagePreview" src="#" alt="Current Image" class="img-fluid rounded mb-2" style="display:none; height:200px; object-fit:cover;">
                </div>
                <div class="mb-3">
                    <label class="form-label">Change Image</label>
                    <input type="file" name="image_url" id="editImage" class="form-control" accept="image/*" onchange="previewEditImage(event)">
                </div>
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="is_published" id="editIsPublished">
                    <label class="form-check-label" for="editIsPublished">Published</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Changes</button>
            </div>
        </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const editButtons = document.querySelectorAll('.edit-btn');

    editButtons.forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            document.getElementById('editAnnouncementId').value = id;
            document.getElementById('editTitle').value = this.dataset.title;
            document.getElementById('editContent').value = this.dataset.content;
            document.getElementById('editCategory').value = this.dataset.category;
            document.getElementById('editPublishDate').value = this.dataset.publish_date;
            document.getElementById('editExpiryDate').value = this.dataset.expiry_date || '';
            document.getElementById('editIsPublished').checked = this.dataset.is_published == 1;

            const image = this.dataset.image;
            const preview = document.getElementById('editImagePreview');
            if (image) {
                preview.src = image;
                preview.style.display = 'block';
            } else {
                preview.style.display = 'none';
            }

            document.getElementById('editAnnouncementForm').action = `/announcements/edit/${id}`;
            new bootstrap.Modal(document.getElementById('editAnnouncementModal')).show();
        });
    });
});

function previewEditImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
        const output = document.getElementById('editImagePreview');
        output.src = reader.result;
        output.style.display = 'block';
    };
    reader.readAsDataURL(event.target.files[0]);
}
</script>
@endsection
