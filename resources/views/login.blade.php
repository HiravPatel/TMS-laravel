<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TaskFlow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
     <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
     <!-- Toastr CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet" />
    <!-- jQuery (Toastr depends on jQuery) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
</head>
<body class="bg-light">

<div class="container vh-100">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-md-4">
            <div class="card shadow-lg rounded-4">
                <div class="card-body p-4">
                    
                    <div class="profile-icon">
                        <i class="fa fa-user-circle" aria-hidden="true" style="font-size: 100px;color:#45556C"></i>
                    </div>

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                                <input type="email" name="email" class="form-control rounded-pill @error('email') is-invalid @enderror" placeholder="Enter your email">
                                 @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Password</label>
                                <input type="password" name="password" class="form-control rounded-pill @error('password') is-invalid @enderror" placeholder="Enter your password">
                                 @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                 <a href="{{route('forgotPasswordForm')}}" class="m-2" style="text-decoration:none;float:right;">Forgot Password?</a>
                        </div>
                        <button type="submit" class="btn w-100 text-white fw-bold rounded-pill mt-4" style="background-color: #FF6600;">Login</button>
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
