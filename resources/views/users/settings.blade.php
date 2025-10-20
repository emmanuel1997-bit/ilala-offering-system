@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">

        <!-- Sidebar -->
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-body p-0">
                    @php
                        $tabs = [
                            ['id' => 'ministries', 'icon' => 'church', 'label' => 'Ministries'],
                            ['id' => 'contribution', 'icon' => 'hand-holding-usd', 'label' => 'Contribution Settings'],
                            ['id' => 'messages', 'icon' => 'envelope', 'label' => 'Messages'],
                            ['id' => 'receipts', 'icon' => 'file-signature', 'label' => 'Receipt Settings'],
                            ['id' => 'spending', 'icon' => 'wallet', 'label' => 'Spending / Expenses'],
                        ];
                    @endphp
                    <ul class="nav flex-column nav-pills py-3" id="settingsTab" role="tablist">
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
                    <h4 class="fw-semibold text-dark mb-1">Church Management Settings</h4>
                    <p class="text-muted mb-0">
                        Manage ministries, contributions, messages, receipts, and spending.
                    </p>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="settingsTabContent">
                     @include('users.components.contribution')
                     @include('users.components.message')
                     @include('users.components.receipt')
                     @include('users.components.spending')
                     
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- toast_message --}}
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
     <div id="messageToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body" id="messageToast"></div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
            </div>
 </div>



 



<script>
document.addEventListener('DOMContentLoaded', function() {
    @if(session('success'))
        showToast("{{ session('success') }}", 'success');
    @elseif(session('error'))
        showToast("{{ session('error') }}", 'danger');
    @elseif($errors->any())
        showToast("{{ $errors->first() }}", 'danger');
    @endif
});

function showToast(message, type = 'success') {
    const toastEl = document.getElementById('messageToast');
    const messageEl = document.getElementById('messageToast');

    messageEl.textContent = message;

    
    toastEl.classList.remove('bg-success', 'bg-danger', 'bg-warning');
    toastEl.classList.add(type === 'success' ? 'bg-success' : 'bg-danger');

    const toast = new bootstrap.Toast(toastEl);
    toast.show();
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll('#settingsTab .nav-link');
    const savedTab = localStorage.getItem('activeSettingsTab');

    if (savedTab) {
        const targetTab = document.querySelector(`#${savedTab}-tab`);
        const targetSection = document.querySelector(`#${savedTab}-section`);
        if (targetTab && targetSection) {
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-pane').forEach(pane => {
                pane.classList.remove('show', 'active');
            });
            targetTab.classList.add('active');
            targetSection.classList.add('show', 'active');
        }
    }

    tabButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            const id = this.id.replace('-tab', '');
            localStorage.setItem('activeSettingsTab', id);
        });
    });
});
</script>


@endsection
