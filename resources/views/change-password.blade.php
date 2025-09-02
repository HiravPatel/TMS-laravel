<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card p-4 shadow-sm" style="max-width: 500px; margin:auto;">
        <h3 class="mb-4">Change Your Password</h3>
          @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
        <form method="POST" action="{{ route('updatePassword') }}">
            @csrf
            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="form-control" readonly>
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
            </div>
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>
            <button class="btn btn-primary w-100">Update Password</button>
        </form>
    </div>
</div>
</body>
</html>
