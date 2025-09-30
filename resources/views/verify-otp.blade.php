<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
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

                        <h4 class="text-center mb-4 fw-bold">Verify OTP</h4>

                        <form method="POST" action="{{ route('verifyOtp') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">Registered Email</label>
                                <input type="email" class="form-control rounded-pill" id="email" name="email"
                                       value="{{ session('email') }}" placeholder="Enter your email" readonly>
                            </div>

                            <div class="mb-3">
                                <label for="otp" class="form-label">Enter OTP</label>
                                <input type="text" class="form-control rounded-pill @error('otp') is-invalid @enderror" 
                                       id="otp" name="otp" placeholder="Enter 6-digit OTP">
                                @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" 
                                       id="password" name="password" placeholder="Enter new password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control rounded-pill @error('password_confirmation') is-invalid @enderror" 
                                       id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                                @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn w-100 rounded-pill text-white fw-bold" style="background-color: #FF6600;">
                                Reset Password
                            </button>
                        </form>

                    </div>
                </div>
            </div>
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
