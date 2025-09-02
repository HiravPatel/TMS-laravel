@extends('layout')
@section('content')
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
  <div class="card shadow-sm w-100" style="max-width: 700px;">
    <div class="card-body">
      <h3 class="card-title mb-2 fw-bold">Edit Employee</h3>
      <p class="text-muted mb-4">Update the details for this employee</p>

      @if(session('success'))
          <div class="alert alert-success">{{ session('success') }}</div>
      @endif

      @if ($errors->any())
          <div class="alert alert-danger">
              <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
      @endif

      <form action="{{ route('updateemployee', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
          </div>
        </div>

        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label class="form-label">Contact No.</label>
            <input type="text" name="cno" value="{{ old('cno', $user->cno) }}" class="form-control">
          </div>
          <div class="col-md-6">
            <label class="form-label">Role</label>
            <select name="role_id" class="form-select" required>
              @foreach($roles as $role)
                  <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                      {{ $role->role }}
                  </option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="d-flex justify-content-end">
          <a href="{{ route('employeelist') }}" class="btn btn-secondary me-2">Cancel</a>
          <button type="submit" class="btn btn-success">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
