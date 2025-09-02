@extends('layout')

@section('content')
    <div class="container mt-4">
<div class="d-flex justify-content-between align-items-center mb-3">
    <p class="fw-bold mb-0">List of all tasks in the system.</p>

    <div class="d-flex align-items-center gap-2">
        {{-- Search Box --}}
<form action="{{ route('tasklist') }}" method="GET" class="me-2">
    <div class="input-group input-group-sm">
        <input type="text" name="search" class="form-control"
               placeholder="Search..." value="{{ request('search') }}">
        
        {{-- Keep status filter when searching --}}
        <input type="hidden" name="status" value="{{ request('status') }}">
        
        <button type="submit" class="btn btn-secondary">Search</button>
    </div>
</form>
        {{-- Status Filter Dropdown --}}
        <form action="{{ route('tasklist') }}" method="GET">
            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                <option value="">All Status</option>
                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                <option value="To Do" {{ request('status') == 'To Do' ? 'selected' : '' }}>To Do</option>
            </select>
        </form>

        {{-- Add Task Button --}}
        <a href="{{ route('storetask') }}" class="btn btn-primary">
            <i class="fa fa-plus" aria-hidden="true"></i> Add Task
        </a>
    </div>
</div>


        @foreach ($tasks as $task)
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-body">

                    <div>
                        <p class="mb-2 fw-bold">{{ $task->task_name }}</p>
                        <p class="text-muted mb-2">{{ $task->description }}</p>
                    </div>


                    <div class="d-flex gap-4 text-muted small mt-2">
                        <span><i class="fa fa-folder text-warning"></i> {{ $task->project->name }}</span>
                        <span><i class="fa fa-user text-primary"></i> {{ $task->assignedTo->name }}</span>
                        <span><i class="fa fa-calendar text-danger"></i> Due: {{ $task->due_date }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-start">
                        <div class="mt-2">
                            <span
                                class="badge rounded-pill 
                            @if ($task->priority == 'High') bg-danger 
                            @elseif($task->priority == 'Medium') bg-warning 
                            @else bg-secondary @endif">
                                {{ $task->priority }}
                            </span>

                            <span
                                class="badge rounded-pill 
                            @if ($task->status == 'Completed') bg-success 
                            @elseif($task->status == 'In Progress') bg-info 
                            @else bg-secondary @endif">
                                {{ $task->status }}
                            </span>
                        </div>
                        <div class="btn-group">
                            <div>
                                <a href="{{ route('updatetask', $task->id) }}" class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-pencil"></i>
                                </a>
                            </div>
                            <div>
                                <form action="{{ route('deletetask', $task->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this task?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @endforeach
        <div class="mt-3" style="display: flex; justify-content: flex-end;">
    {{ $tasks->appends(request()->query())->links() }}
</div>

    </div>
@endsection
