@extends('layout')
@section('content')

    <body class="bg-light">

        <div class="container mt-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                 <h5 class="fw-bold mb-0"> <i class="fa fa-users m-2 text-primary" aria-hidden="true"></i>Users Management</h5>
                <div class="d-flex justify-content-between align-items-center">
                    <div class="d-flex">
                        <form action="{{ route('employeelist') }}" method="GET" class="input-group me-2">
                            <input type="text" name="search" class="form-control" placeholder="Search..."
                                value="{{ request('search') }}">
                            <button type="submit" class="btn btn-dark"><i class="fa fa-search"></i></button>
                        </form>

                    </div>
                    @if (Auth::user()->role->role == 'Admin')
                        <a href="{{ route('addemployee') }}" class="btn btn-primary">
                            <i class="fa fa-plus" aria-hidden="true"></i> Add Member
                        </a>
                    @endif
                </div>
            </div>

            <div class="row g-3">
                @foreach ($users as $index => $user)
                    <div class="col-md-4">
                        <div class="team-card p-3 bg-white rounded-4 shadow-sm text-center">
                            <div class="avatar-circle"
                                style="background-color: {{ ['#F5276C', '#f6c23e', '#C81CDE', '#5EA529'][$index % 4] }};">
                                {{ strtoupper(substr($user->name, 0, 1) . (str_contains($user->name, ' ') ? substr(explode(' ', $user->name)[1], 0, 1) : '')) }}
                            </div>



                            <h6 class="mb-0 fw-bold">{{ $user->name }}</h6>
                            <div class="mt-2">
                                <span class="badge bg-primary">{{ $user->role->role ?? 'No Role' }}</span>
                            </div>
                            <div class="mt-2 text-muted">
                                <i class="fa fa-envelope text-warning m-1" aria-hidden="true"></i> {{ $user->email }}
                            </div>
                            <div class="mt-2 text-muted">
                                <i class="fa fa-phone m-1 text-success" aria-hidden="true"></i> {{ $user->cno }}
                            </div>


                            <div class="mt-3 d-flex justify-content-center">
                                <a href="{{ route('editemployee', $user->id) }}" class="btn btn-sm btn-success me-1">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <form action="{{ route('deleteemployee', $user->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-3" style="display: flex; justify-content: flex-end;">
                {{ $users->appends(request()->query())->links() }}
            </div>
        </div>
    @endsection
