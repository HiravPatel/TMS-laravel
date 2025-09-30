@extends('layout')

@section('content')
    <div class="container mt-4 d-flex justify-content-center">
        <div class="card shadow-lg border-1 rounded-4 overflow-hidden" style="max-width: 550px; width: 100%;">

            <div class="text-white text-center p-4" style="background: linear-gradient(135deg, #0dcaf0,#FFF085);">

                <div class="rounded-circle bg-white text-danger d-flex align-items-center justify-content-center mx-auto mb-3"
                    style="width: 110px; height: 110px; font-size: 50px; box-shadow: 0 4px 12px rgba(0,0,0,0.3);">
                    <i class="fa fa-user"></i>
                </div>

                <h3 class="fw-bold mb-0">{{ $user->name }}</h3>
                <small class="opacity-75">{{ $user->role->role }}</small>
            </div>

            <div class="card-body p-4">
                <div class="mb-3">
                    <p class="mb-1 text-muted"><i class="fa fa-envelope text-primary me-2"></i> <strong>Email</strong></p>
                    <div class="p-3 rounded bg-light">{{ $user->email }}</div>
                </div>

                <div class="mb-3">
                    <p class="mb-1 text-muted"><i class="fa fa-phone text-success me-2"></i> <strong>Contact</strong></p>
                    <div class="p-3 rounded bg-light">{{ $user->cno }}</div>
                </div>

                <div class="mb-3">
                    <p class="mb-1 text-muted"><i class="fa fa-id-badge text-warning me-2"></i> <strong>Role</strong></p>
                    <div class="p-3 rounded bg-light">{{ $user->role->role }}</div>
                </div>

            </div>
        </div>
    </div>
@endsection
