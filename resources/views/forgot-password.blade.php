<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">



    <div class="container vh-100">
        <div class="row h-100 justify-content-center align-items-center">
    
            <div class="col-md-4">
                <div class="card shadow-lg rounded-4">
                    <div class="card-body p-4">

                        <h4 class="text-center mb-4 fw-bold">Forgot Password</h4>

                        <form method="POST" action="{{ route('sendOtp') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Registered Email</label>
                                <input type="email" class="form-control rounded-pill" id="email" name="email"
                                       placeholder="Enter your registered email" required>
                            </div>
                            <button type="submit" 
                                    class="btn w-100 rounded-pill text-white fw-bold" 
                                    style="background-color: #FF6600;">
                                Send OTP
                            </button>
                        </form>

                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-decoration-none">Back to Login</a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
