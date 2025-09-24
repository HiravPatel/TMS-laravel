@extends('layout')

@section('content')
<div class="container d-flex justify-content-center align-items-center mt-4">
    <div class="card shadow-sm w-100" style="max-width: 700px;">
        <div class="card-body">
            <h3 class="card-title mb-2 fw-bold">
                {{ isset($log) ? 'Edit Work Log' : 'Add Daily Work' }}
            </h3>
            <p class="text-muted mb-4">
                {{ isset($log) ? 'Update your work log details.' : 'Fill in the details for adding daily work.' }}
            </p>

            <form id="worklogForm" 
                  action="{{ isset($log) ? route('updateworklog', $log->id) : route('storeworklogform') }}" 
                  method="POST">
                @csrf
                @if(isset($log))
                    @method('PUT')
                @endif

                {{-- Project Dropdown --}}
                <div class="mb-3">
    <label for="project_id" class="form-label">Project</label>

    
    <select name="project_id" id="project" class="form-select @error('project_id') is-invalid @enderror">
    <option value="">Select Project</option>
    @foreach ($projects as $project)
        <option value="{{ $project->id }}" 
            {{ (old('project_id', $log->project_id ?? '') == $project->id) ? 'selected' : '' }}>
            {{ (old('project_id', $log->project_id ?? '') == $project->id) ? 'selected ' . $project->name : $project->name }}
        </option>
    @endforeach
</select>
    @error('project_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
</div>


                {{-- Description --}}
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" rows="3" 
                        class="form-control @error('description') is-invalid @enderror">{{ old('description', $log->description ?? '') }}</textarea>
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Date --}}
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" name="date" id="date" 
                        class="form-control @error('date') is-invalid @enderror"
                        value="{{ old('date', isset($log) ? $log->date : '') }}">
                    <div id="date-error" class="text-danger mt-1"></div>
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="d-flex justify-content-end">
                    <a href="{{ route('workloglist') }}" class="btn btn-secondary me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        {{ isset($log) ? 'Update Work' : 'Add Work' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$('#project').on('change', function() {
    var projectId = $(this).val();

    if(projectId){
        $.ajax({
            url: '/projects/' + projectId + '/dates',
            type: 'GET',
            success: function(data){
                if(data.start_date && data.due_date){
                    $('#date').attr('min', data.start_date).attr('max', data.due_date);
                    $('#date-error').text('');
                }
            },
            error: function(){
                $('#date-error').text('Could not fetch project dates.');
                $('#date').removeAttr('min max');
            }
        });
    } else {
        $('#date').removeAttr('min max');
        $('#date-error').text('');
    }
});
</script>
@endsection
