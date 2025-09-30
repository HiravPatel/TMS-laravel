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

                                <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                            </div>
                        </form>
                        <form action="{{ route('buglist') }}" method="GET" class="me-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="Todo" {{ request('status') == 'Todo' ? 'selected' : '' }}>To Do</option>
                                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="QA Tester" {{ request('status') == 'QA Tester' ? 'selected' : '' }}>QA Tester
                                </option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="Reopened" {{ request('status') == 'Reopened' ? 'selected' : '' }}>Reopened

                                </option>
                            </select>
                        </form>
                        @if (Auth::user()->role->role !== 'Developer')
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
                                @if (Auth::user()->role->role == 'Tester')
                                    <th class="text-center">Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($bugs as $bug)
                                <tr>
                                    <td>
                                        @if ($bug->image)
                                            <img src="{{ asset($bug->image) }}" alt="Bug Image" width="60"
                                                data-bs-toggle="modal" data-bs-target="#imageModal{{ $bug->id }}"
                                                style="cursor:pointer;">
                                            <div class="modal fade" id="imageModal{{ $bug->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-body text-center">
                                                            <img src="{{ asset($bug->image) }}" class="img-fluid rounded"
                                                                alt="Bug Image">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    <td>{{ $bug->bug_name }}</td>
                                    <td>{{ $bug->bug_desc }}</td>
                                    <td>{{ $bug->task->task_name }}</td>
                                    <td>{{ $bug->user->name }}</td>
                                    <td>
                                        @if ($bug->priority == 'High')
                                            <i class="fa fa-exclamation-circle text-danger px-3 py-2"></i>
                                        @elseif ($bug->priority == 'Medium')
                                            <i class="fa fa-exclamation-triangle text-warning px-3 py-2"></i>
                                        @else
                                            <i class="fa fa-minus-circle text-secondary px-3 py-2"></i>
                                        @endif
                                    </td>

                                    <td>
                                        <form action="{{ route('updateBugStatus', $bug->id) }}" method="POST">
                                            @csrf
                                            @method('PATCH')
                                            <select name="status" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                <option value="Todo" {{ $bug->status == 'Todo' ? 'selected' : '' }}
                                                    @if (Auth::user()->role->role == 'Tester') disabled @endif>To Do</option>
                                                <option value="In Progress"
                                                    {{ $bug->status == 'In Progress' ? 'selected' : '' }}
                                                    @if (Auth::user()->role->role == 'Tester') disabled @endif>In Progress</option>
                                                <option value="QA Tester"
                                                    {{ $bug->status == 'QA Tester' ? 'selected' : '' }}
                                                    @if (Auth::user()->role->role == 'Tester') disabled @endif>QA Tester</option>
                                                <option value="Completed"
                                                    {{ $bug->status == 'Completed' ? 'selected' : '' }}
                                                    @if (Auth::user()->role->role == 'Developer') disabled @endif>
                                                    Completed
                                                </option>
                                                <option value="Reopened" {{ $bug->status == 'Reopened' ? 'selected' : '' }}
                                                    @if (Auth::user()->role->role != 'Tester') disabled @endif>
                                                    Reopened
                                                </option>

                                            </select>
                                        </form>
                                    </td>

                                    @if (Auth::user()->role->role == 'Tester')
                                        <td class="text-center">
                                            <a href="{{ route('editbug', $bug->id) }}" class="btn btn-sm btn-success me-1">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('deletebug', $bug->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Are you sure you want to delete this bug?');">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">
                                        No bugs found.
                                    </td>
                                </tr>
                            @endforelse
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
