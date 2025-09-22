@extends('layout')

@section('content')
    <div class="container mt-4">
        <h3 class="fw-bold mb-4"><i class="fa fa-home m-2 text-primary" aria-hidden="true"></i>Dashboard</h3>
        <div class="row g-3 mb-4">
            {{-- Projects --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 p-3 bg-warning text-light">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">Projects</h6>
                            <h3 class="fw-bold">{{ $projectsCount }}</h3>
                            @if (Auth::user()->role->role == 'Admin')
                                <a href="{{ route('projectlist') }}" class="small text-decoration-none text-light">View
                                    All</a>
                            @endif
                        </div>
                        <div>
                            <i class="fa fa-folder-open fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tasks --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center text-light p-3" style="background-color: #721378">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-light">Tasks</h6>
                            <h3 class="fw-bold text-light">{{ $tasksCount }}</h3>
                            @if (Auth::user()->role->role == 'Admin')
                                <a href="{{ route('tasklist') }}" class="small text-decoration-none text-light">View All</a>
                            @endif
                        </div>
                        <div>
                            <i class="fa fa-tasks fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Bugs --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center text-light p-3 bg-success">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-light">Bugs</h6>
                            <h3 class="fw-bold text-light">{{ $bugsCount }}</h3>
                            @if (Auth::user()->role->role == 'Admin')
                                <a href="{{ route('buglist') }}" class="small text-decoration-none text-light">View All</a>
                            @endif
                        </div>
                        <div>
                            <i class="fa fa-bug fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Users --}}
            <div class="col-md-3">
                <div class="card shadow-sm border-0 rounded-4 text-center text-light p-3" style="background-color:#C11007">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-light">Users</h6>
                            <h3 class="fw-bold text-light">{{ $usersCount }}</h3>
                            @if (Auth::user()->role->role == 'Admin')
                                <a href="{{ route('employeelist') }}" class="small text-decoration-none text-light">View
                                    All</a>
                            @endif
                        </div>
                        <div>
                            <i class="fa fa-users fa-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mb-4">
            {{-- Chart --}}
            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Project Task Status Overview</h6>
                    </div>
                    <div class="card-body">
                        {{-- Project Dropdown --}}
                        <form method="GET" action="{{ route('dashboard') }}">
                            <div class="row g-3 mb-3">
                                <div class="col-md-12">
                                    <select name="project_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">Select Project</option>
                                        @foreach ($projects as $project)
                                            <option value="{{ $project->id }}"
                                                {{ request('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </form>

                        {{-- Chart Area --}}
                        @if (isset($selectedProject))
                            <h6 class="fw-bold mb-3 text-center">Tasks for: {{ $selectedProject->name }}</h6>

                            @php
                                $completed = $selectedProject->tasks->where('status', 'Completed')->count();
                                $qa = $selectedProject->tasks->where('status', 'QA Tester')->count();
                                $progress = $selectedProject->tasks->where('status', 'In progress')->count();
                                $todo = $selectedProject->tasks->where('status', 'To do')->count();
                                $total = $completed + $qa + $progress + $todo;
                            @endphp

                            @if ($total > 0)
                                <div style="max-width: 400px; margin: 0 auto;">
                                    <canvas id="taskChart" height="220"></canvas>
                                </div>

                                <script>
                                    var ctx = document.getElementById('taskChart').getContext('2d');

                                    new Chart(ctx, {
                                        type: 'doughnut',
                                        data: {
                                            labels: ['Completed', 'QA Tester', 'In Progress', 'To Do'],
                                            datasets: [{
                                                data: [{{ $completed }}, {{ $qa }}, {{ $progress }},
                                                    {{ $todo }}
                                                ],
                                                backgroundColor: [
                                                    '#198754',
                                                    '#E7180B',
                                                    '#0D6EFD',
                                                    '#FFC107',
                                                ],
                                                borderWidth: 2,
                                                borderColor: '#fff',
                                                hoverOffset: 12,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            cutout: '50%',
                                            plugins: {
                                                legend: {
                                                    position: 'bottom',
                                                    labels: {
                                                        font: {
                                                            size: 13,
                                                            weight: 'bold'
                                                        },
                                                        usePointStyle: true,
                                                        padding: 20
                                                    }
                                                },
                                                datalabels: {
                                                    color: '#fff',
                                                    font: {
                                                        weight: 'bold'
                                                    },
                                                    formatter: (value, ctx) => {
                                                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                                        let percentage = (value * 100 / sum).toFixed(1) + "%";
                                                        return percentage;
                                                    }
                                                },
                                                tooltip: {
                                                    callbacks: {
                                                        label: function(context) {
                                                            let value = context.raw;
                                                            let label = context.label;
                                                            return label + ": " + value;
                                                        }
                                                    }
                                                }
                                            }
                                        },
                                        plugins: [ChartDataLabels]
                                    });
                                </script>
                            @else
                                <p class="text-muted text-center">No tasks available for this project.</p>
                            @endif
                        @else
                            <p class="text-muted">Select a project from the dropdown to see its task chart.</p>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0 rounded-4 h-100">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold mb-0">Recent Projects</h6>
                        @if (Auth::user()->role->role == 'Admin')
                            <a href="{{ route('projectlist') }}" class="btn btn-sm btn-secondary">See All</a>
                        @endif
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead class="table-success">
                                    <tr>
                                        <th>Name</th>
                                        <th>Leader</th>
                                        <th>Due Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($recentProjects as $project)
                                        <tr>
                                            <td>{{ strtoupper(collect(explode(' ', $project->name))->take(4)->map(fn($word) => substr($word, 0, 1))->implode('')) }}
                                                - {{ $project->id }}</td>
                                            <td>{{ $project->leader->name }}</td>
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
            </div>

        </div>



        {{-- Latest Users --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="fw-bold mb-0">New Members</h6>
                @if (Auth::user()->role->role == 'Admin')
                    <a href="{{ route('employeelist') }}" class="btn btn-sm btn-secondary">See All</a>
                @endif
            </div>
            <div class="card-body">
                <div class="row g-3">
                    @forelse($recentUsers as $user)
                        <div class="col-md-3 text-center">
                            <div class="avatar-circle mx-auto mb-2 text-light d-flex align-items-center justify-content-center"
                                style="width:50px; height:50px; border-radius:50%; font-weight:bold;background-color:#721378">
                                {{ strtoupper(substr($user->name, 0, 1) . (str_contains($user->name, ' ') ? substr(explode(' ', $user->name)[1], 0, 1) : '')) }}
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
