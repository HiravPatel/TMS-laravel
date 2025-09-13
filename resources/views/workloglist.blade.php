@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-bold mb-0">Daily Work Logs</p>

                <div class="d-flex align-items-center">
                    <form action="{{ route('workloglist') }}" method="GET" class="me-2">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-secondary">Search</button>
                        </div>
                    </form>
                      @if (Auth::user()->role->role == 'Admin')
                    <a href="{{ route('worklogsexport') }}" class="btn btn-success"> <i class="fa fa-download" aria-hidden="true"></i> Export to Excel</a>
                    @endif
                </div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Project</th>
                            <th>User</th>
                            <th>Description</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->project->name }}</td>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">No work logs found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3" style="display: flex; justify-content: flex-end;">
                    {{ $logs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
