@extends('layout')
@section('content')
    <div class="container d-flex justify-content-center align-items-center mt-4">
        <div class="card shadow-sm w-100" style="max-width: 700px;">
            <div class="card-body">
                <h3 class="card-title mb-2 fw-bold">
                    {{ isset($project) ? 'Edit Project' : 'Add New Project' }}
                </h3>
                <p class="text-muted mb-4">
                    {{ isset($project) ? 'Update the details of the project' : 'Fill in the details for the new project' }}
                </p>

                <form method="POST" action="{{ isset($project) ? route('updateproject', $project->id) : route('storeprojectform') }}">
                    @csrf
                    @if(isset($project))
                        @method('PUT')
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control  @error('name') is-invalid @enderror" id="name" name="name"
                                value="{{ old('name', $project->name ?? '') }}" placeholder="Enter project name">
                                 @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="desc" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="desc" rows="3" name="description" placeholder="Enter description">{{ old('description', $project->description ?? '') }}</textarea>
                        @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-3">

                        <div class="col-md-12">
                            <label for="leader" class="form-label">Leader</label>
                            <select class="form-select @error('leader_id') is-invalid @enderror" id="leader" name="leader_id">
                                <option disabled {{ !isset($project) ? 'selected' : '' }}>Select leader</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}"
                                        {{ old('leader_id', $project->leader_id ?? '') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                              @error('leader_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>


                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" id="startDate" name="start_date"
                                value="{{ old('start_date', $project->start_date ?? '') }}">
                                 @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="duedate" class="form-label">Due Date</label>
                            <input type="date" class="form-control @error('due_date') is-invalid @enderror" id="duedate" name="due_date"
                                value="{{ old('due_date', $project->due_date ?? '') }}">
                                 @error('due_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Members</label>
                        @foreach ($users as $user)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" id="member{{ $user->id }}"
                                    name="members[]" value="{{ $user->id }}"
                                    @if(isset($project) && $project->members->contains($user->id)) checked @endif>
                                <label class="form-check-label" for="member{{ $user->id }}">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-end">
                        <a href="{{ route('projectlist') }}" class="btn btn-secondary me-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            {{ isset($project) ? 'Update Project' : 'Add Project' }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
