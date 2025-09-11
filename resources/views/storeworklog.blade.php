@extends('layout')

@section('content')

    <body class="bg-light">
        <div class="container d-flex justify-content-center align-items-center mt-4">
            <div class="card shadow-sm w-100" style="max-width: 700px;">
                <div class="card-body">
                    <h3 class="card-title mb-2 fw-bold">Add Daily Work</h3>
                    <p class="text-muted mb-4">Fill in the details for the adding daily work.</p>

                    <form action="{{ route('storeworklogform') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-12">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Enter title">
                                 @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="project_id" class="form-label">Project</label>
                                <select name="project_id" id="project_id" class="form-control @error('project_id') is-invalid @enderror">
                                    <option value="">Select Project</option>
                                    @foreach ($projects as $project)
                                        <option value="{{ $project->id }}">{{ $project->name }}</option>
                                    @endforeach
                                </select>
                                 @error('project_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="date" class="form-label">Date</label>
                                <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror">
                                                             @error('date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('storeworklog') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Work</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
