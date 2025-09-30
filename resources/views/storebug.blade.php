@extends('layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow-sm w-100" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="card-title mb-2 fw-bold">
                {{ isset($bug) ? 'Edit Bug' : 'Add New Bug' }}
            </h3>
            <p class="text-muted mb-4">
                {{ isset($bug) ? 'Update the details of the Bug' : 'Fill in the details for the new Bug' }}
            </p>

            <form method="POST" 
                action="{{ isset($bug) ? route('updatebug', $bug->id) : route('storebugform') }}" enctype="multipart/form-data">
                @csrf
                @if(isset($bug))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Title</label>
                        <input type="text" name="bug_name" class="form-control @error('bug_name') is-invalid @enderror" 
                            value="{{ old('bug_name', $bug->bug_name ?? '') }}" placeholder="Enter bug name">
                            @error('bug_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <label>Description</label>
                        <textarea name="bug_desc" class="form-control @error('bug_desc') is-invalid @enderror" placeholder="Enter bug description">{{ old('bug_desc', $bug->bug_desc ?? '') }}</textarea>
                          @error('bug_desc')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label>Select Task</label>
                        <select name="task_id" id="task_id" class="form-control @error('task_id') is-invalid @enderror">
                            <option value="">Select Task</option>
                            @foreach($tasks as $task)
                                <option value="{{ $task->id }}" 
                                    {{ old('task_id', $bug->task_id ?? '') == $task->id ? 'selected' : '' }}>
                                    {{ $task->task_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('task_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>

                    <div class="col-md-6">
                        <label>Select User</label>
                        <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                            <option value="">Select User</option>
                            @if(isset($bug))
                                <option value="{{ $bug->user_id }}" selected>{{ $bug->user->name }}</option>
                            @endif
                        </select>
                         @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label>Priority</label>
                        <select name="priority" class="form-control @error('priority') is-invalid @enderror">
                             <option value="">Select priority</option>
                            @foreach(['High','Medium','Low'] as $priority)
                                <option value="{{ $priority }}" 
                                    {{ old('priority', $bug->priority ?? '') == $priority ? 'selected' : '' }}>
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
                            @foreach(['Todo','In Progress','QA Tester','Completed','Reopened'] as $status)
                                <option value="{{ $status }}" 
                                    {{ old('status', $bug->status ?? '') == $status ? 'selected' : '' }}
                                     @if(auth()->user()->role->role == 'Tester' && in_array($status, ['In Progress', 'QA Tester'])) disabled @endif>
                                    {{ $status }}
                                </option>
                            @endforeach
                        </select>
                          @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                    </div>
                </div>

                <div class="mb-3">
    <label for="image" class="form-label">Bug Image</label>
    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
    @if(isset($bug) && $bug->image)
        <img src="{{ asset($bug->image) }}" alt="Bug Image" class="mt-2" width="120">
    @endif
     @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
</div>


                <div class="d-flex justify-content-end">
                    <a href="{{ route('buglist') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($bug) ? 'Update Bug' : 'Add Bug' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $('#task_id').on('change', function () {
        var taskId = $(this).val();
        if (taskId) {
            $.ajax({
                url: '/tasks/' + taskId + '/members',
                type: 'GET',
                success: function (data) {
                    $('#user_id').empty().append('<option value="">Select User</option>');
                    if (data.id) {
                        $('#user_id').append('<option value="' + data.id + '" selected>' + data.name + '</option>');
                    }
                }
            });
        } else {
            $('#user_id').empty().append('<option value="">Select User</option>');
        }
    });
</script>
@endsection
