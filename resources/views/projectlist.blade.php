@extends('layout')
@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0"> <i class="fa fa-folder-open m-2 text-primary" aria-hidden="true"></i>Project Management</h5>

                    <div class="d-flex align-items-center">
                        <!-- Search -->
                        <form action="{{ route('projectlist') }}" method="GET" class="me-2">
                            <div class="input-group input-group-sm">
                                <input type="text" name="search" class="form-control" placeholder="Search..."
                                    value="{{ request('search') }}">
                                <input type="hidden" name="status" value="{{ request('status') }}">
                                <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                            </div>
                        </form>

                      @if (Auth::user()->role->role == 'Admin')
                            <a href="{{ route('storeproject') }}" class="btn btn-primary">
                                <i class="fa fa-plus" aria-hidden="true"></i> Add Project
                            </a>
                        @endif
                    </div>
                </div>

                @php
                    $colorClasses = ['card-color-1', 'card-color-2', 'card-color-3', 'card-color-4', 'card-color-5'];
                @endphp

                <div class="row">
                    @forelse ($projects as $project)
                        @php
                            $colorClass = $colorClasses[$loop->index % count($colorClasses)];
                        @endphp
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="card shadow-sm border-0 rounded-3 {{ $colorClass }}">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="mb-0 fw-bold">
                                            {{ strtoupper(collect(explode(' ', $project->name))->take(4)->map(fn($word) => substr($word, 0, 1))->implode('')) }}
                                            - {{ $project->id }}
                                        </h6>
                                        <button class="btn btn-sm btn-light toggle-details" data-bs-toggle="collapse"
                                            data-bs-target="#projectDetails{{ $project->id }}">
                                            <i class="fa fa-chevron-down"></i>
                                        </button>
                                    </div>
                                    <div class="collapse mt-2" id="projectDetails{{ $project->id }}">
                                        <p><strong>Leader:</strong> {{ $project->leader->name }}</p>
                                        <div class="mb-2">
                                            <strong>Members:</strong>
                                            <div class="d-flex mt-1">
                                                @foreach ($project->members->take(3) as $member)
                                                    <div class="rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center me-1"
                                                        style="width:35px; height:35px; font-size:14px; font-weight:bold; border:2px solid #fff; cursor:pointer;"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#userModal{{ $project->id }}_{{ $member->id }}">
                                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                                        @if (str_contains($member->name, ' '))
                                                            {{ strtoupper(substr(explode(' ', $member->name)[1], 0, 1)) }}
                                                        @endif
                                                    </div>
                                                    <div class="modal fade"
                                                        id="userModal{{ $project->id }}_{{ $member->id }}"
                                                        tabindex="-1" aria-hidden="true">
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
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#moreUsersModal{{ $project->id }}">
                                                        +{{ $project->members->count() - 3 }}
                                                    </div>

                                                    <div class="modal fade" id="moreUsersModal{{ $project->id }}"
                                                        tabindex="-1" aria-hidden="true">
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
                                                                                <small>Email:
                                                                                    {{ $member->email }}</small><br>
                                                                                <small>Phone:
                                                                                    {{ $member->cno }}</small><br>
                                                                                <small>Role:
                                                                                    {{ $member->role->role }}</small>
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                        <p><strong>Dates:</strong> {{ $project->start_date }} - {{ $project->due_date }}
                                        </p>

                                            <div class="d-flex justify-content-end">
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
                                            </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <div class="col-12 text-center">
                            <p>No projects found.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-3" style="display: flex; justify-content: flex-end;">
                    {{ $projects->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-details').forEach(button => {
                button.addEventListener('click', function() {
                    let icon = this.querySelector('i');
                    setTimeout(() => {
                        icon.classList.toggle('fa-chevron-down');
                        icon.classList.toggle('fa-chevron-up');
                    }, 200);
                });
            });
        });
    </script>

@endsection
