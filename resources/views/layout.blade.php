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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-light">
    {{-- sidebar --}}
    <div class="d-flex min-vh-100">
        <aside id="sidebar" class="sidebar bg-dark">
            <div class="d-flex justify-content-between align-items-center p-3">
                <p class="mb-0 fw-bold text-uppercase"
                    style="background: linear-gradient(90deg,#0dcaf0,#FFF085);
           -webkit-background-clip: text;
           -webkit-text-fill-color: transparent;
           letter-spacing: 1.5px;">
                    <i class="fa fa-signal m-2" aria-hidden="true"></i>
                     <span class="text-light nav-text ms-2">TASKFLOW</span>
            </p>



            </div>

            <ul class="nav flex-column mb-2">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link text-light {{ request()->routeIs('dashboard') ? 'active bg text-light' : '' }}">
                        <i class="fa fa-home m-2" aria-hidden="true"></i>
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
                         @endif
                </li>

                <li class="nav-item">
                    @if (Auth::user()->role->role == 'Admin')
                        <a href="{{ route('projectlist') }}"
                            class="nav-link text-light {{ request()->routeIs('projectlist') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-folder-open m-2" aria-hidden="true"></i>
                            <span class="nav-text">Projects</span>
                        </a>
                         @endif
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

                    <li class="nav-item">
                        <a href="{{ route('workloglist') }}"
                            class="nav-link text-light {{ request()->routeIs('workloglist') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-calendar-check-o m-2" aria-hidden="true"></i>
                            <span class="nav-text">Work Logs</span>
                        </a>
                    </li>

                @if (Auth::user()->role->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('addemployee') }}"
                            class="nav-link text-light {{ request()->routeIs('addemployee') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-user-plus m-2" aria-hidden="true"></i>
                            <span class="nav-text">Add Employee</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('storeproject') }}"
                            class="nav-link text-light {{ request()->routeIs('storeproject') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-plus-circle m-2" aria-hidden="true"></i>
                            <span class="nav-text">Create Project</span>
                        </a>
                    </li>
                @endif

                @if (Auth::user()->role->role == 'Admin')
                    <li class="nav-item">
                        <a href="{{ route('storetask') }}"
                            class="nav-link text-light {{ request()->routeIs('storetask') ? 'active bg text-light' : '' }}">
                            <i class="fa fa-plus m-2" aria-hidden="true"></i>
                            <span class="nav-text">Create Task</span>
                        </a>
                    </li>
                @endif

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
                            <i class="fa fa-plus m-2" aria-hidden="true"></i>
                            <span class="nav-text">Add Work Log</span>
                        </a>
                    </li>
                @endif

            </ul>
        </aside>

        {{-- Main Content --}}
        <div class="flex-grow-1 d-flex flex-column">

            {{-- header --}}
            <header class="navbar navbar-expand-lg navbar-light bg-white shadow-sm px-3">
                 <button class="btn border-0 me-3 shadow-sm" id="sidebarToggle">
            <i class="fa fa-bars fa-lg text-dark"></i>
        </button>
                <div class="container-fluid d-flex justify-content-end">
                    <i class="fa fa-calendar text-muted" aria-hidden="true"></i><span id="currentDateTime"
                        class="fw-bold text-muted px-3"></span>
                    <i class="fa fa-bell fa-2x me-4" aria-hidden="true"></i>
                    <div class="dropdown">
                        <a href="#"
                            class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                            id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">

                            {{-- User initials --}}
                            @php
                                $name = Auth::user()->name ?? 'Admin';
                                $initials = collect(explode(' ', $name))
                                    ->map(fn($part) => strtoupper(substr($part, 0, 1)))
                                    ->take(2)
                                    ->implode('');
                            @endphp

                            <div class="rounded-circle bg-danger text-white fw-bold d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                {{ $initials }}
                            </div>
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown">
                            <li class="dropdown-item text-center">
                                <strong>{{ $name }}</strong><br>
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
            <footer class="fw-bold text-muted text-center py-2 mt-auto shadow-lg bg-light">
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
<span id="currentDateTime" class="me-4 fw-bold text-muted"></span>

<script>
    function updateDateTime() {
        const now = new Date();
        const options = {
            weekday: 'short',
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit'
        };
        document.getElementById('currentDateTime').innerText = now.toLocaleString('en-IN', options);
    }

    setInterval(updateDateTime, 1000);
    updateDateTime(); 
</script>
<script>
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('sidebarToggle');

    toggleBtn.addEventListener('click', () => {
        if (window.innerWidth < 1024) {
            sidebar.classList.toggle('expanded'); 
        } else {
            sidebar.classList.toggle('collapsed');
        }
    });
</script>

</html>
