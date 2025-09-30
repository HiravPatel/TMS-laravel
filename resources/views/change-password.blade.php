<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- jQuery (Toastr depends on jQuery) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="container vh-100">
        <div class="row h-100 justify-content-center align-items-center">
            <div class="col-md-4">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4 fw-bold">Change Password</h4>

                        <form method="POST" action="{{ route('updatePassword') }}">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}"
                                    class="form-control rounded-pill" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password"
                                    class="form-control rounded-pill @error('password') is-invalid @enderror"
                                    placeholder="Enter new password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control rounded-pill"
                                    placeholder="Confirm new password">
                            </div>

                            <button type="submit" class="btn w-100 rounded-pill text-white fw-bold"
                                style="background-color: #FF6600;">
                                Update Password
                            </button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
</body>

</html>
