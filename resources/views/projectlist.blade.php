@extends('layout')
@section('content')
<div class="container mt-4">
    <div class="card shadow-sm rounded-4 border-0">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <p class="fw-bold mb-0">List of all projects in the system.</p>

               <div class="d-flex align-items-center">
{{-- Search Box --}}
<form action="{{ route('projectlist') }}" method="GET" class="me-2">
    <div class="input-group input-group-sm">
        <input type="text" name="search" class="form-control"
               placeholder="Search..." value="{{ request('search') }}">
        
        {{-- Keep status filter when searching --}}
        <input type="hidden" name="status" value="{{ request('status') }}">
        
        <button type="submit" class="btn btn-secondary">Search</button>
    </div>
</form>

                    {{-- Status Filter Dropdown --}}
                    <form action="{{ route('projectlist') }}" method="GET" class="me-2">
                        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">All Status</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                            <option value="To Do" {{ request('status') == 'To Do' ? 'selected' : '' }}>To Do</option>
                        </select>
                    </form>

                    {{-- Add Project Button --}}
                    <a href="{{ route('storeproject') }}" class="btn btn-primary">
                        <i class="fa fa-plus" aria-hidden="true"></i> Add Project
                    </a>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table align-middle table-hover">
                    <thead class="table-success">
                        <tr>
                            <th>Name</th>
                            <th>Leader</th>
                            <th>Status</th>
                            <th>Members</th>
                            <th>Dates</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{ $project->name }}</td>
                            <td>{{ $project->leader->name }}</td>
                            <td>
                                <span class="badge 
                                    @if($project->status == 'Completed') bg-success 
                                    @elseif($project->status == 'In Progress') bg-info 
                                    @else bg-secondary 
                                    @endif">
                                    {{ $project->status }}
                                </span>
                            </td>
                            <td>
                                @foreach($project->members as $member)
                                    <span class="badge bg-warning text-dark">{{ $member->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <small>{{ $project->start_date }}</small> 
                                <span class="mx-1">-</span> 
                                <small>{{ $project->due_date }}</small>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('editproject', $project->id) }}" class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('deleteproject', $project->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Are you sure you want to delete this project?');">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3" style="display: flex; justify-content: flex-end;">
    {{ $projects->appends(request()->query())->links() }}
</div>

            </div>
        </div>
    </div>
</div>
@endsection
