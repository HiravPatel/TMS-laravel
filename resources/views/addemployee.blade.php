@extends('layout')
@section('content')

    <body class="bg-light">
        <div class="container d-flex justify-content-center align-items-center mt-4">
            <div class="card shadow-sm w-100" style="max-width: 700px;">
                <div class="card-body">
                    <h3 class="card-title mb-2 fw-bold">Add New Employee</h3>
                    <p class="text-muted mb-4">Fill in the details for the new employee</p>
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    <form method="POST" action="{{ route('addemployeeform') }}">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" placeholder="Enter name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email"
                                    placeholder="Enter email">
                                     @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="cno" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control @error('cno') is-invalid @enderror" id="cno" name="cno"
                                    placeholder="Enter contact number">
                                    @error('cno')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select @error('role_id') is-invalid @enderror" id="role" name="role_id">
                                    <option value="" disabled selected>Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->role }}</option>
                                    @endforeach
                                </select>
                                  @error('role_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('employeelist') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Employee</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection
