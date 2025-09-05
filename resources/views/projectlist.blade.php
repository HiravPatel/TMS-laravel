@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <p class="fw-bold mb-0">List of all projects in the system.</p>

                    <div class="d-flex align-items-center">
                        <form action="{{ route('projectlist') }}" method="GET" class="me-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">

                                <input type="hidden" name="status" value="{{ request('status') }}">

                                <button type="submit" class="btn btn-secondary">Search</button>
                            </div>
                        </form>

                        <form action="{{ route('projectlist') }}" method="GET" class="me-2">
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">All Status</option>
                                <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In
                                    Progress</option>
                                <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed
                                </option>
                                <option value="To Do" {{ request('status') == 'To Do' ? 'selected' : '' }}>To Do</option>
                            </select>
                        </form>

                        <a href="{{ route('storeproject') }}" class="btn btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Project
                        </a>
                    </div>
                </div>
                
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
                            @foreach ($projects as $project)
                                <tr>
                                    <td>{{ $project->name }}-{{ $project->id }}</td>
                                    <td>{{ $project->leader->name }}</td>
                                    <td>
                                        <span
                                            class="badge 
                                    @if ($project->status == 'Completed') bg-success 
                                    @elseif($project->status == 'In Progress') bg-info 
                                    @else bg-secondary @endif">
                                            {{ $project->status }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex">
                                            @foreach ($project->members->take(3) as $member)
                                                <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-1"
                                                    style="width:35px; height:35px; font-size:14px; font-weight:bold; border:2px solid #fff; cursor:pointer;"
                                                    data-bs-toggle="modal" data-bs-target="#userModal{{ $member->id }}">
                                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                                    @if (str_contains($member->name, ' '))
                                                        {{ strtoupper(substr(explode(' ', $member->name)[1], 0, 1)) }}
                                                    @endif
                                                </div>

                                                <div class="modal fade" id="userModal{{ $member->id }}" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">{{ $member->name }}</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p><strong>Email:</strong> {{ $member->email }}</p>
                                                                <p><strong>Phone:</strong> {{ $member->cno }}</p>
                                                                <p><strong>Role:</strong> {{ $member->role->role }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach

                                            @if ($project->members->count() > 3)
                                                <div class="rounded-circle bg-light text-dark d-flex align-items-center justify-content-center"
                                                    style="width:35px; height:35px; font-size:14px; font-weight:bold; border:2px solid #fff; cursor:pointer;"
                                                    data-bs-toggle="modal" data-bs-target="#moreUsersModal">
                                                    +{{ $project->members->count() - 3 }}
                                                </div>

                                                <div class="modal fade" id="moreUsersModal" tabindex="-1"
                                                    aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Other Members</h5>
                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <ul class="list-group">
                                                                    @foreach ($project->members->skip(3) as $member)
                                                                        <li class="list-group-item">
                                                                            <strong>{{ $member->name }}</strong><br>
                                                                            <small>Email: {{ $member->email }}</small><br>
                                                                            <small>Phone: {{ $member->cno }}</small><br>
                                                                            <small>Role: {{ $member->role->role }}</small>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <small>{{ $project->start_date }}</small>
                                        <span class="mx-1">-</span>
                                        <small>{{ $project->due_date }}</small>
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('editproject', $project->id) }}"
                                            class="btn btn-sm btn-success me-1">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <form action="{{ route('deleteproject', $project->id) }}" method="POST"
                                            class="d-inline">
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
