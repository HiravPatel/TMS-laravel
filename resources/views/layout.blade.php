<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TaskFlow Dashboard - Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-light">
    {{-- sidebar --}}
    <div class="d-flex min-vh-100">
        <aside class="sidebar bg-dark">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-decoration-none bg-white">
                <img src="{{ asset('images/logo2.png') }}" alt="TaskFlow Logo" class="img-fluid"
                    style="max-height: 60px; width: auto;">
            </a>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link text-light {{ request()->routeIs('dashboard') ? 'active bg text-light' : '' }}">
                        <i class="fa fa-tachometer m-2" aria-hidden="true"></i>
                        <span class="nav-text">Dashboard</span>
                    </a>
                </li>

                <li class="nav-item">

                    @if (Auth::user()->role->role == 'Admin')
                        <a href="{{ route('employeelist') }}"
                            class="nav-link text-light {{ request()->routeIs('employeelist') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-users m-2" aria-hidden="true"></i>
                            <span class="nav-text">Team Members</span>
                        </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('projectlist') }}"
                        class="nav-link text-light {{ request()->routeIs('projectlist') ? 'active bg text-light' : '' }}">
                        <i class="fa fa-folder m-2" aria-hidden="true"></i>
                        <span class="nav-text">Projects</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('tasklist') }}"
                        class="nav-link text-light {{ request()->routeIs('tasklist') ? 'active bg text-light' : '' }}">
                        <i class="fa fa-tasks m-2" aria-hidden="true"></i>
                        <span class="nav-text">Tasks</span>
                    </a>
                </li>

                @if (in_array(Auth::user()->role->role, ['Backened Developer', 'Tester']))
                    <li class="nav-item">
                        <a href="{{ route('buglist') }}"
                            class="nav-link text-light {{ request()->routeIs('buglist') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-bug m-2" aria-hidden="true"></i>
                            <span class="nav-text">Bugs</span>
                        </a>
                    </li>
                @endif


                @if (Auth::user()->role->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('workloglist') }}"
                            class="nav-link text-light {{ request()->routeIs('workloglist') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-calendar-check-o m-2" aria-hidden="true"></i>
                            <span class="nav-text">Work Logs</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('addemployee') }}"
                            class="nav-link text-light {{ request()->routeIs('addemployee') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-user-plus m-2" aria-hidden="true"></i>
                            <span class="nav-text">Add Employee</span>
                        </a>
                    </li>
                @endif

                @if (in_array(Auth::user()->role->role, ['Backened Developer', 'Admin']))
                    <li class="nav-item">
                        <a href="{{ route('storeproject') }}"
                            class="nav-link text-light {{ request()->routeIs('storeproject') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-plus-circle m-2" aria-hidden="true"></i>
                            <span class="nav-text">Create Project</span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('storetask') }}"
                        class="nav-link text-light {{ request()->routeIs('storetask') ? 'active bg text-light' : '' }}">
                        <i class="fa fa-plus m-2" aria-hidden="true"></i>
                        <span class="nav-text">Create Task</span>
                    </a>
                </li>

                @if (Auth::user()->role->role == 'Tester')
                    <li class="nav-item">
                        <a href="{{ route('storebug') }}"
                            class="nav-link text-light {{ request()->routeIs('storebug') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-plus m-2" aria-hidden="true"></i>
                            <span class="nav-text">Add Bug</span>
                        </a>
                    </li>
                @endif

                @if (in_array(Auth::user()->role->role, ['Backened Developer', 'Tester']))
                    <li class="nav-item">
                        <a href="{{ route('storeworklog') }}" class="nav-link text-light">
                            <i class="fa fa-calendar-check-o m-2" aria-hidden="true"></i>
                            <span class="nav-text">Work Log</span>
                        </a>
                    </li>
                @endif

            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="flex-grow-1 d-flex flex-column">

            {{-- header --}}
            <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 py-3">
                <div class="container-fluid d-flex justify-content-end">
                    {{-- <i class="fa fa-bell fa-2x me-4" aria-hidden="true"></i> --}}
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="dropdown-item text-center">
                                <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
                                <small class="text-muted">{{ Auth::user()->role->role ?? 'Role' }}</small>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="background: red;color:white">
                                        <i class="fa fa-sign-out me-2"></i> Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-grow-1 p-2">
                @yield('content')
            </main>

            {{-- footer --}}
            <footer class="text-muted text-center py-2 mt-auto shadow-sm" style="background-color: #DFD9D8">
                <small><i class="fa fa-copyright" aria-hidden="true"></i> TaskFlow. All Rights Reserved.</small>
            </footer>
        </div>
    </div>

</body>
<script>
    @if (session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if (session('error'))
        toastr.error("{{ session('error') }}");
    @endif
</script>

</html>
