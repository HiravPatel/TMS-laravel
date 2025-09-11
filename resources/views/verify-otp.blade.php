<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify OTP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
     <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg">
                <div class="card-body">
            
                    <form method="POST" action="{{ route('verifyOtp') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Registered Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   value="{{ session('email') }}" placeholder="Enter your email">
                        </div>

                        <div class="mb-3">
                            <label for="otp" class="form-label">Enter OTP</label>
                            <input type="text" class="form-control @error('otp') is-invalid @enderror" id="otp" name="otp"
                                   placeholder="Enter 6-digit OTP">
                                    @error('otp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password"
                                   placeholder="Enter new password">
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation"
                                   name="password_confirmation" placeholder="Confirm new password">
                                    @error('password_confirmation')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
