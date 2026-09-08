@extends('admin.app')

@section('title')
    Profile Settings
@endsection

@push('custom-style')
<style>
    .profile-card {
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #e9edf4;
        box-shadow: 0 2px 4px rgba(17, 26, 58, 0.02);
        margin-bottom: 24px;
    }
    .profile-card .card-header {
        background-color: #fff;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f1f7;
        border-radius: 8px 8px 0 0;
    }
    .profile-card .card-title {
        font-size: 15px;
        font-weight: 600;
        color: #1d1b31;
        position: relative;
        padding-left: 12px;
        margin-bottom: 0;
    }
    .profile-card .card-title::before {
        content: "";
        position: absolute;
        height: 16px;
        width: 3px;
        top: 2px;
        left: 0;
        background: #f95716;
        border-radius: 4px;
    }
    .form-label-admin {
        font-size: 13px;
        font-weight: 600;
        color: #333335;
        margin-bottom: 6px;
    }
    .form-control-admin {
        height: 42px;
        font-size: 13.5px;
        border-radius: 6px;
        border: 1px solid #ced4da;
        padding: 8px 14px;
        width: 100%;
        outline: none;
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }
    .form-control-admin:focus {
        border-color: #f95716;
        box-shadow: none !important;
        outline: none !important;
    }
    .btn-admin-save {
        background-color: #f95716;
        color: #ffffff;
        border: none;
        border-radius: 6px;
        padding: 9px 20px;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-admin-save:hover {
        background-color: #ea4907;
        color: #ffffff;
    }
    .btn-admin-save:focus,
    .btn-admin-save:focus-visible,
    .btn-admin-save:active {
        box-shadow: none !important;
        outline: none !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid my-4">

    <!-- Header Breadcrumbs -->
    <div class="mb-4">
        <h4 class="fw-bold mb-1" style="color: #111a3a;">Account &amp; Security Settings</h4>
        <p class="text-muted mb-0" style="font-size: 13px;">Manage your administrator profile details, credentials, and password security.</p>
    </div>

    <div class="row g-4">
        <!-- Left: Profile Information -->
        <div class="col-lg-7 col-12">
            <!-- Profile Info Card -->
            <div class="profile-card">
                <div class="card-header">
                    <h5 class="card-title">Profile Information</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4" style="font-size: 13px;">Update your account's display name and administrative email address.</p>

                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label for="name" class="form-label-admin">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control-admin" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                            @if($errors->has('name'))
                                <div class="text-danger small mt-1">{{ $errors->first('name') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="email" class="form-label-admin">Email Address</label>
                            <input type="email" id="email" name="email" class="form-control-admin" value="{{ old('email', $user->email) }}" required autocomplete="username">
                            @if($errors->has('email'))
                                <div class="text-danger small mt-1">{{ $errors->first('email') }}</div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3 pt-2">
                            <button type="submit" class="btn-admin-save">Save Profile Changes</button>
                            @if (session('status') === 'profile-updated')
                                <span class="text-success small fw-semibold"><i class="ri-check-line me-1"></i> Saved successfully.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>

            <!-- Update Password Card -->
            <div class="profile-card">
                <div class="card-header">
                    <h5 class="card-title">Update Password</h5>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted mb-4" style="font-size: 13px;">Ensure your account uses a strong, random password to maintain administrative integrity.</p>

                    <form method="post" action="{{ route('password.update') }}">
                        @csrf
                        @method('put')

                        <div class="mb-3">
                            <label for="current_password" class="form-label-admin">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control-admin" autocomplete="current-password">
                            @if($errors->updatePassword->has('current_password'))
                                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('current_password') }}</div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label-admin">New Password</label>
                            <input type="password" id="password" name="password" class="form-control-admin" autocomplete="new-password">
                            @if($errors->updatePassword->has('password'))
                                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password') }}</div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label-admin">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control-admin" autocomplete="new-password">
                            @if($errors->updatePassword->has('password_confirmation'))
                                <div class="text-danger small mt-1">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                            @endif
                        </div>

                        <div class="d-flex align-items-center gap-3 pt-2">
                            <button type="submit" class="btn-admin-save">Update Password</button>
                            @if (session('status') === 'password-updated')
                                <span class="text-success small fw-semibold"><i class="ri-check-line me-1"></i> Password updated.</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Right: Admin Info & Quick Details -->
        <div class="col-lg-5 col-12">
            <!-- Account Summary Card -->
            <div class="profile-card mb-4">
                <div class="card-header">
                    <h5 class="card-title">Account Summary</h5>
                </div>
                <div class="card-body p-4 text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle text-white mb-3" style="width: 80px; height: 80px; background-color: #f95716; font-size: 32px; font-weight: 700; box-shadow: 0 4px 14px rgba(249, 87, 22, 0.3);">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h5 class="fw-bold mb-1" style="color: #111a3a;">{{ $user->name }}</h5>
                    <p class="text-muted mb-3" style="font-size: 13px;">{{ $user->email }}</p>
                    <span class="badge bg-light text-dark fw-semibold px-3 py-1.5" style="border: 1px solid #e2e8f0; font-size: 12px;">Lead Superintendent / Administrator</span>

                    <hr class="my-4">

                    <ul class="list-unstyled mb-0 text-start" style="font-size: 13px;">
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Account Status:</span>
                            <span class="badge bg-success-subtle text-success fw-semibold">Active &amp; Verified</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Access Level:</span>
                            <span class="fw-semibold text-dark">Super Administrator</span>
                        </li>
                        <li class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted">Registered On:</span>
                            <span class="text-muted">{{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}</span>
                        </li>
                        <li class="d-flex justify-content-between py-2">
                            <span class="text-muted">Security Encryption:</span>
                            <span class="text-success fw-medium"><i class="ri-shield-check-fill me-1"></i>Bcrypt / 256-bit</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
