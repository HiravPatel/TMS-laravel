@extends('layout')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold mb-0"> <i class="fa fa-tasks m-2 text-primary" aria-hidden="true"></i>Task Management</h5>

            <div class="d-flex align-items-center gap-2">
                {{-- Search Box --}}
                <form action="{{ route('tasklist') }}" method="GET" class="me-2">
                    <div class="input-group input-group-sm">
                        <input type="text" name="search" class="form-control" placeholder="Search..."
                            value="{{ request('search') }}">
                        <input type="hidden" name="status" value="{{ request('status') }}">
                        <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                    </div>
                </form>

                {{-- Status Filter Dropdown --}}
                <form action="{{ route('tasklist') }}" method="GET">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Todo" {{ request('status') == 'Todo' ? 'selected' : '' }}>To Do</option>
                        <option value="In progress" {{ request('status') == 'In progress' ? 'selected' : '' }}>In Progress
                        </option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="QA Tester" {{ request('status') == 'QA Tester' ? 'selected' : '' }}>QA Tester</option>
                        <option value="Reopened" {{ request('status') == 'Reopened' ? 'selected' : '' }}>Reopened</option>
                    </select>
                </form>

                @if (Auth::user()->role->role == 'Admin')
                    <a href="{{ route('storetask') }}" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Task
                    </a>
                @endif
            </div>
        </div>

        @forelse ($tasks as $task)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div>
                        <p class="mb-2 fw-bold">{{ $task->task_name }}</p>
                        <p class="text-muted mb-2">{{ $task->description }}</p>
                    </div>

                    <div class="d-flex gap-4 text-muted small mt-2">
                        <span><i class="fa fa-folder-open text-warning"></i>
                            {{ $task->project->name }}-{{ $task->project->id }} </span>
                        <span><i class="fa fa-user text-primary"></i> {{ $task->assignedTo->name }}</span>
                        <span><i class="fa fa-calendar text-danger"></i> Due: {{ $task->due_date }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="mt-2 d-flex align-items-center gap-3">
                            {{-- Priority --}}
                            <span>
                                @if ($task->priority == 'High')
                                    <span class="badge bg-danger px-3 py-2 rounded-4">
                                        <i class="fa fa-exclamation-circle me-1"></i> High
                                    </span>
                                @elseif ($task->priority == 'Medium')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-4">
                                        <i class="fa fa-exclamation-triangle me-1"></i> Medium
                                    </span>
                                @else
                                    <span class="badge bg-success px-3 py-2 rounded-4">
                                        <i class="fa fa-minus-circle me-1"></i> Low
                                    </span>
                                @endif
                            </span>



                            {{-- Status Dropdown --}}
                            <form action="{{ route('updateTaskStatus', $task->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="Todo" {{ $task->status == 'Todo' ? 'selected' : '' }}
                                        @if (Auth::user()->role->role == 'Tester') disabled @endif>To Do</option>
                                    <option value="In progress" {{ $task->status == 'In progress' ? 'selected' : '' }}
                                        @if (Auth::user()->role->role == 'Tester') disabled @endif>In Progress</option>
                                    <option value="QA Tester" {{ $task->status == 'QA Tester' ? 'selected' : '' }}
                                        @if (Auth::user()->role->role == 'Tester') disabled @endif>QA Tester</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}
                                        @if (Auth::user()->role->role == 'Backened Developer') disabled @endif>Completed</option>
                                    <option value="Reopened" {{ $task->status == 'Reopened' ? 'selected' : '' }}
                                        @if (Auth::user()->role->role == 'Backened Developer') disabled @endif>Reopened</option>
                                </select>
                            </form>
                        </div>

                        @if (Auth::user()->role->role == 'Admin')
                            <div class="btn-group">
                                <a href="{{ route('updatetask', $task->id) }}" class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('deletetask', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        @endif
                    </div>


                </div>
            </div>
        @empty
            <tr>
                <td colspan="6" class="text-center">
                    No tasks found.
                </td>
            </tr>
        @endforelse

        <div class="mt-3" style="display: flex; justify-content: flex-end;">
            {{ $tasks->appends(request()->query())->links() }}
        </div>


    </div>
@endsection
