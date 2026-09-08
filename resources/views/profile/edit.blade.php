@extends('admin.app')

@section('title', 'Profile Settings')

@push('custom-style')
    <style>
        .profile-card {
            background-color: #ffffff;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px rgba(11, 15, 23, 0.03);
            margin-bottom: 24px;
            overflow: hidden;
        }

        .profile-card .card-header {
            background-color: #ffffff;
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            border-radius: 8px 8px 0 0;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .profile-card .card-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            position: relative;
            padding-left: 12px;
            margin-bottom: 0;
        }

        .profile-card .card-title::before {
            content: "";
            position: absolute;
            height: 16px;
            width: 3px;
            top: 50%;
            transform: translateY(-50%);
            left: 0;
            background: #f95716;
            border-radius: 4px;
        }

        .custom-label {
            font-size: 12px;
            font-weight: 600;
            color: #475569;
            margin-bottom: 6px;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .custom-input {
            height: 38px;
            font-size: 13.5px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
            color: #0f172a;
            background-color: #ffffff;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .custom-input:focus {
            border-color: #f95716;
            box-shadow: none !important;
            outline: none !important;
        }

        .custom-input[readonly],
        .custom-input:disabled {
            background-color: #f8fafc;
            color: #64748b;
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        .submit-button {
            background-color: #f95716;
            color: #ffffff;
            border: 1px solid #ea580c;
            border-radius: 6px;
            padding: 8px 22px;
            font-size: 13px;
            font-weight: 600;
            height: 38px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .submit-button:hover {
            background-color: #ea4907;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(249, 87, 22, 0.3);
        }

        .avatar-dropzone {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            background-color: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .avatar-dropzone:hover,
        .avatar-dropzone.dragover {
            border-color: #f95716;
            background-color: #fff8f5;
        }

        .avatar-preview-box {
            position: relative;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            overflow: hidden;
            margin: 0 auto;
            border: 3px solid #f95716;
            box-shadow: 0 4px 14px rgba(249, 87, 22, 0.2);
        }

        .avatar-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-initials {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto;
            background-color: #f95716;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(249, 87, 22, 0.25);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        {{-- Header with Breadcrumb --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card table-card mb-0">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Administrator Profile &amp; Settings</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile Settings</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-3">
            {{-- Left: Edit Forms --}}
            <div class="col-lg-8 col-12">
                <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    {{-- Card 1: Personal & Professional Details --}}
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title">Personal &amp; Professional Details</h5>
                            <span class="badge bg-light text-muted border" style="font-size: 11px;">Primary
                                Information</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                {{-- Full Name --}}
                                <div class="col-md-6 col-12">
                                    <label for="name" class="form-label custom-label">Full Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" id="name" name="name"
                                        class="form-control custom-input @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required autocomplete="name"
                                        placeholder="e.g. John Doe">
                                    @error('name')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Professional Designation --}}
                                <div class="col-md-6 col-12">
                                    <label for="designation" class="form-label custom-label">Job Title / Designation</label>
                                    <input type="text" id="designation" name="designation"
                                        class="form-control custom-input @error('designation') is-invalid @enderror"
                                        value="{{ old('designation', $user->designation) }}"
                                        placeholder="e.g. Senior Project Director">
                                    @error('designation')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email Address (Locked / Readonly) --}}
                                <div class="col-md-6 col-12">
                                    <label for="email"
                                        class="form-label custom-label d-flex justify-content-between align-items-center">
                                        <span>Administrative Email</span>
                                        <span class="text-muted" style="font-size: 11px; text-transform: none;"><i
                                                class="ri-lock-2-line text-secondary"></i> Non-Editable</span>
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light text-muted border-end-0"
                                            style="border-color: #e2e8f0; font-size: 14px;">
                                            <i class="ri-mail-lock-line"></i>
                                        </span>
                                        <input type="email" id="email" class="form-control custom-input border-start-0"
                                            value="{{ $user->email }}" readonly disabled>
                                    </div>
                                    <div class="text-muted mt-1" style="font-size: 11px;">
                                        <i class="ri-information-line me-1"></i>Primary account email is locked for security
                                        integrity.
                                    </div>
                                </div>

                                {{-- Phone Number --}}
                                <div class="col-md-6 col-12">
                                    <label for="phone_no" class="form-label custom-label">Contact Mobile / Phone</label>
                                    <input type="text" id="phone_no" name="phone_no"
                                        class="form-control custom-input @error('phone_no') is-invalid @enderror"
                                        value="{{ old('phone_no', $user->phone_no) }}" placeholder="e.g. +880 1700-000000">
                                    @error('phone_no')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Physical / Office Address --}}
                                <div class="col-12">
                                    <label for="address" class="form-label custom-label">Office / Physical Address</label>
                                    <input type="text" id="address" name="address"
                                        class="form-control custom-input @error('address') is-invalid @enderror"
                                        value="{{ old('address', $user->address) }}"
                                        placeholder="e.g. Level 7, Commercial Tower, Gulshan-2, Dhaka">
                                    @error('address')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Biography / Professional Summary --}}
                                <div class="col-12">
                                    <label for="description" class="form-label custom-label">Professional Biography &amp;
                                        Scope</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="form-control custom-input @error('description') is-invalid @enderror"
                                        style="height: auto;"
                                        placeholder="Brief summary of engineering background, certifications, and operational roles...">{{ old('description', $user->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Card 2: Social & Public Channels --}}
                    <div class="card profile-card">
                        <div class="card-header">
                            <h5 class="card-title">Social &amp; Communication Channels</h5>
                            <span class="badge bg-light text-muted border" style="font-size: 11px;">Networking</span>
                        </div>
                        <div class="card-body p-4">
                            <div class="row g-3">
                                {{-- LinkedIn --}}
                                <div class="col-md-4 col-12">
                                    <label for="linkedin" class="form-label custom-label">
                                        <i class="ri-linkedin-box-fill me-1 text-primary"></i> LinkedIn URL
                                    </label>
                                    <input type="url" id="linkedin" name="linkedin"
                                        class="form-control custom-input @error('linkedin') is-invalid @enderror"
                                        value="{{ old('linkedin', $user->linkedin) }}"
                                        placeholder="https://linkedin.com/in/username">
                                    @error('linkedin')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- WhatsApp --}}
                                <div class="col-md-4 col-12">
                                    <label for="whatsapp" class="form-label custom-label">
                                        <i class="ri-whatsapp-fill me-1 text-success"></i> WhatsApp Number
                                    </label>
                                    <input type="text" id="whatsapp" name="whatsapp"
                                        class="form-control custom-input @error('whatsapp') is-invalid @enderror"
                                        value="{{ old('whatsapp', $user->whatsapp) }}" placeholder="+8801700000000">
                                    @error('whatsapp')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Facebook --}}
                                <div class="col-md-4 col-12">
                                    <label for="facebook" class="form-label custom-label">
                                        <i class="ri-facebook-box-fill me-1 text-primary"></i> Facebook Profile
                                    </label>
                                    <input type="url" id="facebook" name="facebook"
                                        class="form-control custom-input @error('facebook') is-invalid @enderror"
                                        value="{{ old('facebook', $user->facebook) }}"
                                        placeholder="https://facebook.com/username">
                                    @error('facebook')
                                        <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hidden image input triggered by dropzone --}}
                            <input type="file" id="profile_image_input" name="image" class="d-none"
                                accept="image/jpeg,image/png,image/jpg,image/webp">

                            <div class="d-flex align-items-center justify-content-between pt-4 mt-2 border-top">
                                <button type="submit" class="btn submit-button">
                                    <i class="ri-check-line me-1"></i> Save Profile Changes
                                </button>
                                @if (session('status') === 'profile-updated' || session('success'))
                                    <span class="text-success small fw-semibold">
                                        <i class="ri-checkbox-circle-fill me-1"></i> Changes saved successfully.
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </form>

                {{-- Card 3: Password & Security Update --}}
                <div class="card profile-card">
                    <div class="card-header">
                        <h5 class="card-title">Account Security &amp; Password</h5>
                        <span class="badge bg-light text-muted border" style="font-size: 11px;">Authentication</span>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-4" style="font-size: 13px;">
                            Ensure your account uses a strong, random password to maintain administrative and site security.
                        </p>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="row g-3">
                                <div class="col-md-4 col-12">
                                    <label for="current_password" class="form-label custom-label">Current Password</label>
                                    <input type="password" id="current_password" name="current_password"
                                        class="form-control custom-input @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                                        autocomplete="current-password" placeholder="••••••••">
                                    @if($errors->updatePassword->has('current_password'))
                                        <div class="text-danger mt-1" style="font-size: 12px;">
                                            {{ $errors->updatePassword->first('current_password') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4 col-12">
                                    <label for="password" class="form-label custom-label">New Password</label>
                                    <input type="password" id="password" name="password"
                                        class="form-control custom-input @if($errors->updatePassword->has('password')) is-invalid @endif"
                                        autocomplete="new-password" placeholder="••••••••">
                                    @if($errors->updatePassword->has('password'))
                                        <div class="text-danger mt-1" style="font-size: 12px;">
                                            {{ $errors->updatePassword->first('password') }}</div>
                                    @endif
                                </div>

                                <div class="col-md-4 col-12">
                                    <label for="password_confirmation" class="form-label custom-label">Confirm New
                                        Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation"
                                        class="form-control custom-input @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                                        autocomplete="new-password" placeholder="••••••••">
                                    @if($errors->updatePassword->has('password_confirmation'))
                                        <div class="text-danger mt-1" style="font-size: 12px;">
                                            {{ $errors->updatePassword->first('password_confirmation') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="d-flex align-items-center justify-content-between pt-4 mt-2 border-top">
                                <button type="submit" class="btn submit-button"
                                    style="background-color: #0f172a; border-color: #0f172a;">
                                    <i class="ri-lock-password-line me-1"></i> Update Password
                                </button>
                                @if (session('status') === 'password-updated')
                                    <span class="text-success small fw-semibold">
                                        <i class="ri-checkbox-circle-fill me-1"></i> Password updated successfully.
                                    </span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right: Avatar Photo & Identity Metadata --}}
            <div class="col-lg-4 col-12">
                {{-- Profile Photo Card --}}
                <div class="card profile-card mb-4">
                    <div class="card-header">
                        <h5 class="card-title">Profile Photo</h5>
                    </div>
                    <div class="card-body p-4 text-center">
                        {{-- Active Photo or Initials --}}
                        <div id="avatar_display_container" class="mb-3">
                            @if(!empty($user->image) && file_exists(public_path($user->image)))
                                <div class="avatar-preview-box">
                                    <img id="avatar_img_preview" src="{{ asset($user->image) }}" alt="{{ $user->name }}">
                                </div>
                            @else
                                <div id="avatar_initials_fallback" class="avatar-initials">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div id="avatar_staged_preview_box" class="avatar-preview-box d-none">
                                    <img id="avatar_img_preview" src="" alt="Avatar preview">
                                </div>
                            @endif
                        </div>

                        <h5 class="fw-bold mb-1" style="color: #0f172a; font-size: 16px;">{{ $user->name }}</h5>
                        <p class="text-muted mb-2" style="font-size: 13px;">{{ $user->designation ?? 'Administrator' }}</p>

                        {{-- Role Badge --}}
                        @php
                            $roleName = $user->roles->first()?->name ?? 'Administrator';
                            $roleBadgeStyle = match ($roleName) {
                                'superadmin' => 'background-color: #fee2e2; color: #991b1b; border: 1px solid #fca5a5;',
                                'admin' => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                                'project-manager' => 'background-color: #e0f2fe; color: #075985; border: 1px solid #7dd3fc;',
                                default => 'background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;',
                            };
                        @endphp
                        <span class="badge"
                            style="{{ $roleBadgeStyle }} font-size: 11.5px; padding: 4px 10px; border-radius: 4px; font-weight: 600;">
                            {{ ucwords(str_replace('-', ' ', $roleName)) }}
                        </span>

                        <hr class="my-3">

                        {{-- Avatar Dropzone Box --}}
                        <div id="avatar_dropzone_area" class="avatar-dropzone mb-2">
                            <i class="ri-camera-switch-line" style="font-size: 26px; color: #f95716;"></i>
                            <div class="fw-semibold text-dark mt-1" style="font-size: 13px;">Upload New Photo</div>
                            <span class="text-muted d-block" style="font-size: 11px;">Drag &amp; drop or click to browse
                                (Max 3MB)</span>
                        </div>

                        <div id="avatar_staged_info" class="d-none text-start p-2 bg-light rounded border mt-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-truncate me-2" style="font-size: 11.5px;">
                                    <i class="ri-image-line text-primary me-1"></i>
                                    <strong id="avatar_staged_name"></strong>
                                </div>
                                <button type="button" class="btn btn-sm btn-link text-danger p-0 text-decoration-none"
                                    id="btn_cancel_avatar">
                                    <i class="ri-close-circle-line" style="font-size: 16px;"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Account & System Metadata --}}
                <div class="card profile-card">
                    <div class="card-header">
                        <h5 class="card-title">Account Security Details</h5>
                    </div>
                    <div class="card-body p-3">
                        <ul class="list-unstyled mb-0" style="font-size: 12.5px;">
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Account Status</span>
                                <span class="badge"
                                    style="background-color: #ecfdf5; color: #059669; border: 1px solid #a7f3d0; font-size: 11px;">
                                    <i class="ri-checkbox-circle-fill me-1"></i> Active &amp; Verified
                                </span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Primary Role</span>
                                <span class="fw-semibold text-dark">{{ ucwords(str_replace('-', ' ', $roleName)) }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Member Since</span>
                                <span
                                    class="text-dark">{{ $user->created_at ? $user->created_at->format('d M, Y') : 'N/A' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2 border-bottom">
                                <span class="text-muted">Last Updated</span>
                                <span
                                    class="text-muted">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Just now' }}</span>
                            </li>
                            <li class="d-flex justify-content-between py-2">
                                <span class="text-muted">Password Encryption</span>
                                <span class="text-success fw-semibold"><i class="ri-shield-check-fill me-1"></i> Bcrypt
                                    (256-bit)</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            var $imageInput = $('#profile_image_input');
            var $dropzone = $('#avatar_dropzone_area');

            $dropzone.on('click', function () {
                $imageInput.click();
            });

            $dropzone.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.addClass('dragover');
            });

            $dropzone.on('dragleave dragend drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $dropzone.removeClass('dragover');
            });

            $dropzone.on('drop', function (e) {
                var files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    $imageInput[0].files = files;
                    handleAvatarPreview(files[0]);
                }
            });

            $imageInput.on('change', function () {
                if (this.files && this.files[0]) {
                    handleAvatarPreview(this.files[0]);
                }
            });

            function handleAvatarPreview(file) {
                if (!file.type.match('image.*')) {
                    toastr.warning('Please select a valid image file (PNG, JPG, WebP)');
                    return;
                }
                if (file.size > 3 * 1024 * 1024) {
                    toastr.warning('Image exceeds 3MB limit');
                    return;
                }

                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatar_img_preview').attr('src', e.target.result);
                    $('#avatar_initials_fallback').addClass('d-none');
                    $('#avatar_staged_preview_box').removeClass('d-none');
                    $('#avatar_staged_name').text(file.name);
                    $('#avatar_staged_info').removeClass('d-none');
                };
                reader.readAsDataURL(file);
            }

            $('#btn_cancel_avatar').on('click', function () {
                $imageInput.val('');
                $('#avatar_staged_info').addClass('d-none');
                @if(empty($user->image) || !file_exists(public_path($user->image)))
                    $('#avatar_img_preview').attr('src', '');
                    $('#avatar_staged_preview_box').addClass('d-none');
                    $('#avatar_initials_fallback').removeClass('d-none');
                @else
                    $('#avatar_img_preview').attr('src', "{{ asset($user->image) }}");
                @endif
            });
        });
    </script>
@endpush