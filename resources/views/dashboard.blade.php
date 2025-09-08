@extends('layout')

@section('content')
    <div class="container mt-4">
        <h3 class="fw-bold mb-4">Dashboard</h3>

        {{-- Top Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3" style="background-color: #F1C40F">
                    <h6 class="text-light">Projects</h6>
                    <h3 class="fw-bold text-light">{{ $projectsCount }}</h3>
                    <a href="{{ route('projectlist') }}" class="small text-decoration-none text-light">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3" style="background-color: #7D3C98">
                    <h6 class="text-light">Tasks</h6>
                    <h3 class="fw-bold text-light">{{ $tasksCount }}</h3>
                    <a href="{{ route('tasklist') }}" class="small text-decoration-none text-light">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3" style="background-color:#52BE80">
                    <h6 class="text-light">Bugs</h6>
                    <h3 class="fw-bold text-light">{{ $bugsCount }}</h3>
                    <a href="{{ route('buglist') }}" class="small text-decoration-none text-light">View All</a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center p-3" style="background-color:#CD6155">
                    <h6 class="text-light">Users</h6>
                    <h3 class="fw-bold text-light">{{ $usersCount }}</h3>
                    <a href="{{ route('employeelist') }}" class="small text-decoration-none text-light">View All</a>
                </div>
            </div>
        </div>

        {{-- Latest Projects --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">Recent Projects</h6>
                <a href="{{ route('projectlist') }}" class="btn btn-sm btn-secondary">See All</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table align-middle table-hover">
                        <thead class="table-success">
                            <tr>
                                <th>Name</th>
                                <th>Leader</th>
                                <th>Status</th>
                                <th>Due Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentProjects as $project)
                                <tr>
                                    <td>{{ $project->name }}</td>
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
                                    <td>{{ $project->due_date }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">No recent projects</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        {{-- Latest Users --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">New Members</h6>
                <a href="{{ route('employeelist') }}" class="btn btn-sm btn-secondary">See All</a>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($recentUsers as $user)
                        <div class="col-md-3 text-center">
                            <div class="avatar-circle mx-auto mb-2 bg-warning text-dark d-flex align-items-center justify-content-center"
                                style="width:50px; height:50px; border-radius:50%; font-weight:bold;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                @if (str_contains($user->name, ' '))
                                    {{ strtoupper(substr(explode(' ', $user->name)[1], 0, 1)) }}
                                @endif
                            </div>
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->role->role ?? 'No Role' }}</small>
                        </div>
                    @empty
                        <p class="text-muted">No recent members</p>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
@endsection
