@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
            <h4 class="fw-bold text-dark mb-0">Ministries Overview</h4>

            <!-- Year Filter -->
            <form method="GET" class="d-flex align-items-center gap-2">
                <label for="year" class="fw-semibold text-secondary mb-0">Year:</label>
                <select name="year" id="year" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                    @for($y = date('Y'); $y >= date('Y') - 5; $y--)
                        <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endfor
                </select>
            </form>
        </div>

        <div class="card-body">
            @if($ministries->isEmpty())
                <div class="alert alert-info text-center mb-0">
                    <i class="bi bi-info-circle me-2"></i>No ministries found for {{ $year }}.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle">
                        <thead class="table-light">
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ministry Name</th>
                                <th scope="col">Chairman</th>
                                <th scope="col">Secretary</th>
                                <th scope="col">Treasurer</th>
                                <th scope="col">Budget ({{ $year }})</th>
                                <th scope="col">Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ministries as $ministry)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="fw-semibold">{{ $ministry->name }}</td>
                                    <td>{{ $ministry->chairman }}</td>
                                    <td>{{ $ministry->secretary }}</td>
                                    <td>{{ $ministry->treasurer }}</td>
                                    <td>${{ number_format($ministry->budget, 2) }}</td>
                                    <td>{{ $ministry->description }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Optional Pagination --}}
                {{-- <div class="mt-3">
                    {{ $ministries->links() }}
                </div> --}}
            @endif
        </div>
    </div>
</div>
@endsection
