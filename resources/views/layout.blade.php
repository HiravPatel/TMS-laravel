<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>TaskFlow Dashboard - Bootstrap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet"/>
    <!-- jQuery (Toastr depends on jQuery) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="bg-light">
    {{-- sidebar --}}
    <div class="d-flex min-vh-100">
        <aside class="sidebar bg-dark">
            <a href="{{ route('dashboard') }}" class="d-flex align-items-center mb-3 text-decoration-none bg-white">
                <img src="{{ asset('images/logo2.png') }}" alt="TaskFlow Logo" class="img-fluid"
                    style="max-height: 60px; width: auto;">
            </a>
            <h6 class="text-light text-uppercase small p-1">Main</h6>
            <ul class="nav flex-column mb-2">
                <li class="nav-item"><a href="{{ route('dashboard') }}"
                        class="nav-link text-light {{ request()->routeIs('dashboard') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-tachometer m-2" aria-hidden="true"></i></span> Dashboard</a></li>
                <li class="nav-item"><a href="{{ route('employeelist') }}"
                        class="nav-link text-light {{ request()->routeIs('employeelist') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-users m-2" aria-hidden="true"></i></span> Team Members</a></li>
                <li class="nav-item"><a href="{{ route('projectlist') }}"
                        class="nav-link text-light {{ request()->routeIs('projectlist') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-folder m-2" aria-hidden="true"></i></span> Projects</a></li>
                <li class="nav-item"><a href="{{ route('tasklist') }}"
                        class="nav-link text-light {{ request()->routeIs('tasklist') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-tasks m-2" aria-hidden="true"></i></span> Tasks</a></li>
                <li class="nav-item"><a href="{{ route('buglist') }}"
                        class="nav-link text-light {{ request()->routeIs('buglist') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-bug m-2" aria-hidden="true"></i></span>Bugs</a></li>
            </ul>

            <h6 class="text-light text-uppercase small mt-4 p-1">Management</h6>
            <ul class="nav flex-column">
                <li class="nav-item bg"><a href="{{ route('addemployee') }}"
                        class="nav-link text-light {{ request()->routeIs('addemployee') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-user-plus m-2" aria-hidden="true"></i></span> Add Employee</a></li>
                <li class="nav-item bg"><a href="{{ route('storeproject') }}"
                        class="nav-link text-light {{ request()->routeIs('storeproject') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-plus-circle m-2" aria-hidden="true"></i></span> Create Project</a></li>
                <li class="nav-item bg"><a href="{{ route('storetask') }}"
                        class="nav-link text-light {{ request()->routeIs('storetask') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-plus m-2" aria-hidden="true"></i></span> Create Task</a></li>
                <li class="nav-item bg"><a href="{{ route('storebug') }}"
                        class="nav-link text-light {{ request()->routeIs('storebug') ? 'active bg text-light' : '' }}"><span><i
                                class="fa fa-plus m-2" aria-hidden="true"></i></span> Add Bug</a></li>
               </ul>
        </aside>

        {{-- Main Content --}}
        <div class="flex-grow-1 d-flex flex-column">

            {{-- header --}}
            <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3 py-3">
    <div class="container-fluid d-flex justify-content-end">
          {{-- <i class="fa fa-bell fa-2x me-4 text-secondary" aria-hidden="true"></i> --}}
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle" id="userDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-user-circle fa-2x" aria-hidden="true"></i>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                <li class="dropdown-item text-center">
                    <strong>{{ Auth::user()->name ?? 'Admin' }}</strong><br>
                    <small class="text-muted">{{ Auth::user()->role->role ?? 'Role' }}</small>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="dropdown-item" style="background: red;color:white">
                            <i class="fa fa-power-off me-2"></i> Logout
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
                <small><i class="fa fa-copyright" aria-hidden="true"></i>TaskFlow. All Rights Reserved.</small>
            </footer>
        </div>
    </div>
    {{-- sidebar --}}
</body>
    <script>
        $(document).ready(function() {
            @if(Session::has('success'))
                toastr.success("{{ Session::get('success') }}");
            @endif

            @if(Session::has('error'))
                toastr.error("{{ Session::get('error') }}");
            @endif

            @if(Session::has('warning'))
                toastr.warning("{{ Session::get('warning') }}");
            @endif

            @if(Session::has('info'))
                toastr.info("{{ Session::get('info') }}");
            @endif
        });
    </script>
</html>
