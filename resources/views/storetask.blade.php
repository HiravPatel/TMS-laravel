@extends('layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow-sm w-100" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="card-title mb-2 fw-bold">
                {{ isset($task) ? 'Edit Task' : 'Add New Task' }}
            </h3>
            <p class="text-muted mb-4">
                {{ isset($task) ? 'Update the task details.' : 'Fill in the details for the new Task.' }}
            </p>

            <form action="{{ isset($task) ? route('updatetask', $task->id) : route('storetaskform') }}" 
                  method="POST">
                @csrf
                @if(isset($task))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Task Name</label>
                        <input type="text" name="task_name" class="form-control @error('task_name') is-invalid @enderror"
                               placeholder="Enter task name"
                               value="{{ old('task_name', $task->task_name ?? '') }}">
                                @error('task_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Enter description">{{ old('description', $task->description ?? '') }}</textarea>
                                  @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label>Project</label>
                        <select name="project_id" id="project" class="form-control @error('project_id') is-invalid @enderror">
                            <option value="">Select Project</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">
                                    {{ old('project_id', $task->project_id ?? '') == $project->id ? 'selected' : '' }}
                                    {{ $project->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-control @error('assigned_to') is-invalid @enderror">
                            <option value="">Select Member</option>
                            @if(isset($task) && $task->assignedto)
                                <option value="{{ $task->assignedto->id }}" selected>
                                    {{ $task->assignedto->name }}
                                </option>
                            @endif
                        </select>
                        @error('assigned_to')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label>Priority</label>
                        <select name="priority" class="form-control @error('priority') is-invalid @enderror">
                            <option value="">Select Priority</option>
                            @foreach(['High', 'Medium', 'Low'] as $priority)
                                <option value="{{ $priority }}" 
                                    {{ old('priority', $task->priority ?? '') == $priority ? 'selected' : '' }}>
                                    {{ $priority }}
                                </option>
                            @endforeach
                        </select>
                        @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-control @error('status') is-invalid @enderror">
                            <option value="">Select Status</option>
                            @foreach(['To do', 'In progress', 'Completed'] as $status)
                                <option value="{{ $status }}" 
                                    {{ old('status', $task->status ?? '') == $status ? 'selected' : '' }}>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label>Start Date</label> 
                        <input type="date" name="start_date" class="form-control @error('start_date') is-invalid @enderror"
                               value="{{ old('start_date', $task->start_date ?? '') }}">
                               @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                    <div class="col-md-6">
                        <label>Due Date</label>
                        <input type="date" name="due_date" class="form-control @error('due_date') is-invalid @enderror"
                               value="{{ old('due_date', $task->due_date ?? '') }}">
                               @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('tasklist') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($task) ? 'Update Task' : 'Add Task' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script>
            $('#project').on('change', function() {
                var projectId = $(this).val();
                if (projectId) {
                    $.ajax({
                        url: '/projects/' + projectId + '/members',
                        type: 'GET',
                        success: function(data) {
                            $('#assigned_to').empty().append('<option value="">Select Member</option>');
                            $.each(data, function(key, member) {
                                $('#assigned_to').append('<option value="' + member.id + '">' +
                                    member.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#assigned_to').empty().append('<option value="">Select Member</option>');
                }
            });
        </script>
@endsection
