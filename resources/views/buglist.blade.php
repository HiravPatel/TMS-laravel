@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="fw-bold mb-0">List of all bugs in the system.</p>
                    <div class="d-flex align-items-center">
                        <form action="{{ route('buglist') }}" method="GET" class="me-2" enctype="multipart/form-data">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">

                                <input type="hidden" name="status" value="{{ request('status') }}">

                                <button type="submit" class="btn btn-secondary">Search</button>
                            </div>
                        </form>
                        <form action="{{ route('buglist') }}" method="GET" class="me-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="To Do" {{ request('status') == 'To Do' ? 'selected' : '' }}>To Do</option>
                            </select>
                        </form>
                         @if (Auth::user()->role->role !== 'Backened Developer')
                        <a href="{{ route('storebug') }}" class="btn btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add bug
                        </a>
                        @endif
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Image</th>
                                <th>Name</th>
                                <th>Decsription</th>
                                <th>Task</th>
                                <th>Assigned User</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bugs as $bug)
                                <tr>
                                    <td>
                                        @if ($bug->image)
                                            <img src="{{ asset($bug->image) }}" alt="Bug Image" width="60">
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>
                                    <td>{{ $bug->bug_name }}</td>
                                    <td>{{ $bug->bug_desc }}</td>
                                    <td>{{ $bug->task->task_name }}</td>
                                    <td>{{ $bug->User->name }}</td>
                                    <td>
                                        <span
                                            class="badge rounded-pill 
                            @if ($bug->priority == 'High') bg-danger 
                            @elseif($bug->priority == 'Medium') bg-warning 
                            @else bg-secondary @endif">
                                            {{ $bug->priority }}
                                        </span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge 
                                    @if ($bug->status == 'Completed') bg-success 
                                    @elseif($bug->status == 'In Progress') bg-info 
                                    @else bg-secondary @endif">
                                            {{ $bug->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('editbug', $bug->id) }}" class="btn btn-sm btn-success me-1">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('deletebug', $bug->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Are you sure you want to delete this bug?');">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                </div>
                </tr>
                @endforeach
                </tbody>
                </table>
                <div class="mt-3" style="display: flex; justify-content: flex-end;">
                    {{ $bugs->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
