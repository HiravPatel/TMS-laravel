@extends('layout')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                 <h5 class="fw-bold mb-0">
                    <i class="fa fa-calendar-check-o m-2" aria-hidden="true"></i>Work Log Management
                 </h5>

                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('workloglist') }}" method="GET" class="d-flex">
                        <div class="input-group input-group-sm">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                        </div>
                    </form>

                      @if (Auth::user()->role->role !== 'Admin')
                    <a href="{{ route('storeworklog') }}" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Work Log
                    </a>
                @endif

                    @if (Auth::user()->role->role == 'Admin')
                        <a href="{{ route('worklogsexport') }}" class="btn btn-success btn-sm fw-bold shadow-sm">
                            <i class="fa fa-download me-2" aria-hidden="true"></i> Export To Excel
                        </a>
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
                               @if (Auth::user()->role->role !== 'Admin')
                            <th class="text-center">Actions</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>
                                    <span class="badge bg-warning-subtle text-dark px-3 py-2">
                                        {{ $log->project->name }} - {{ $log->project->id }}
                                    </span>
                                </td>
                                <td>{{ $log->user->name }}</td>
                                <td>{{ $log->description }}</td>
                                <td>
                                    <span class="badge text-light px-3 py-2" style="background-color: #68668e">
                                        {{ \Carbon\Carbon::parse($log->date)->format('d M, Y') }}
                                    </span>
                                </td>
                                
                                   @if (Auth::user()->role->role !== 'Admin')
                                <td class="text-center">
                                    <!-- Edit Button -->
                                    <a href="{{ route('updateworklog', $log->id) }}" 
                                       class="btn btn-sm btn-success">
                                        <i class="fa fa-pencil"></i>
                                    </a>

                                    <!-- Delete Button -->
                                    <form action="{{ route('deleteworklog', $log->id) }}" 
                                          method="POST" 
                                          style="display:inline-block;"
                                          onsubmit="return confirm('Are you sure you want to delete this log?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No work logs found.</td>
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
