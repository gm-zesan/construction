@extends('admin.app')
@section('title', 'Team Member: ' . $teamMember->name)

@push('custom-style')
    <style>
        .member-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .member-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 4px;
        }

        .member-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Main Content Column --}}
            <div class="col-lg-8 col-12">
                {{-- Member Profile Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">{{ $teamMember->name }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('team-members.index') }}" class="add-new"
                                style="background-color: #f1f5f9; color: #334155;">
                                <i class="ri-list-check me-1"></i> Team Members
                            </a>
                            @canany(['team-member-edit'])
                                <a href="{{ route('team-members.edit', $teamMember->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Profile
                                </a>
                            @endcanany
                        </div>
                    </div>

                    <div class="card-body custom-form p-4">
                        {{-- Member Hero Header --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between p-3 rounded mb-4"
                            style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center border shadow-sm"
                                    style="width: 76px; height: 76px; background: #ffffff;">
                                    @if($teamMember->photo_url)
                                        <img src="{{ $teamMember->photo_url }}" alt="{{ $teamMember->name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="text-primary fw-bold" style="font-size: 24px;">
                                            {{ strtoupper(substr($teamMember->name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-0">{{ $teamMember->name }}</h4>
                                    <div class="text-primary fw-semibold" style="font-size: 14px;">
                                        {{ $teamMember->designation }}
                                    </div>
                                    @if($teamMember->department)
                                        <div class="text-muted" style="font-size: 12px;">
                                            <i class="ri-building-line me-1"></i>{{ $teamMember->department }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-1 mt-2 mt-sm-0">
                                @if($teamMember->is_active)
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5" style="font-size: 12px;">
                                        <i class="ri-checkbox-circle-line me-1"></i> Active / Published
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-3 py-1.5" style="font-size: 12px;">
                                        <i class="ri-close-circle-line me-1"></i> Inactive / Hidden
                                    </span>
                                @endif

                                @if($teamMember->is_featured)
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2.5 py-1" style="font-size: 11px;">
                                        <i class="ri-star-fill text-warning me-1"></i> Featured Executive
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Professional Bio --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 13.5px; text-transform: uppercase; letter-spacing: 0.05em;">
                                Professional Overview &amp; Bio
                            </h6>
                            <div class="p-3 rounded bg-white border" style="font-size: 14px; line-height: 1.7; color: #334155;">
                                {{ $teamMember->bio ?: 'No biography provided for this team member.' }}
                            </div>
                        </div>

                        {{-- Contact & Social Links Grid --}}
                        <div class="row g-3">
                            <div class="col-sm-6">
                                <div class="member-meta-box">
                                    <div class="member-meta-label"><i class="ri-mail-line me-1"></i> Email Address</div>
                                    <div class="member-meta-value">
                                        @if($teamMember->email)
                                            <a href="mailto:{{ $teamMember->email }}" class="text-primary text-decoration-none">{{ $teamMember->email }}</a>
                                        @else
                                            <span class="text-muted fst-italic">Not provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="member-meta-box">
                                    <div class="member-meta-label"><i class="ri-phone-line me-1"></i> Phone Number</div>
                                    <div class="member-meta-value">
                                        @if($teamMember->phone)
                                            <a href="tel:{{ $teamMember->phone }}" class="text-dark text-decoration-none">{{ $teamMember->phone }}</a>
                                        @else
                                            <span class="text-muted fst-italic">Not provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="member-meta-box">
                                    <div class="member-meta-label"><i class="ri-linkedin-fill me-1 text-primary"></i> LinkedIn Profile</div>
                                    <div class="member-meta-value text-truncate">
                                        @if($teamMember->linkedin_url)
                                            <a href="{{ $teamMember->linkedin_url }}" target="_blank" class="text-primary text-decoration-none">{{ $teamMember->linkedin_url }}</a>
                                        @else
                                            <span class="text-muted fst-italic">Not linked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="member-meta-box">
                                    <div class="member-meta-label"><i class="ri-twitter-x-line me-1 text-dark"></i> X / Twitter</div>
                                    <div class="member-meta-value text-truncate">
                                        @if($teamMember->twitter_url)
                                            <a href="{{ $teamMember->twitter_url }}" target="_blank" class="text-dark text-decoration-none">{{ $teamMember->twitter_url }}</a>
                                        @else
                                            <span class="text-muted fst-italic">Not linked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="member-meta-box">
                                    <div class="member-meta-label"><i class="ri-facebook-fill me-1 text-primary"></i> Facebook</div>
                                    <div class="member-meta-value text-truncate">
                                        @if($teamMember->facebook_url)
                                            <a href="{{ $teamMember->facebook_url }}" target="_blank" class="text-primary text-decoration-none">{{ $teamMember->facebook_url }}</a>
                                        @else
                                            <span class="text-muted fst-italic">Not linked</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar: Meta & Audit Info --}}
            <div class="col-lg-4 col-12">
                <div class="card table-card">
                    <div class="card-header table-header">
                        <div class="table-title">Audit Information</div>
                    </div>
                    <div class="card-body p-4">
                        <ul class="list-unstyled mb-0 d-flex flex-column gap-3" style="font-size: 13px;">
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Display Sort Order:</span>
                                <span class="fw-bold text-dark">{{ $teamMember->sort_order }}</span>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Status:</span>
                                <span>
                                    @if($teamMember->is_active)
                                        <span class="badge bg-success-subtle text-success">Active</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger">Inactive</span>
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Featured:</span>
                                <span>
                                    @if($teamMember->is_featured)
                                        <span class="badge bg-warning-subtle text-warning-emphasis">Featured</span>
                                    @else
                                        <span class="badge bg-light text-muted">Standard</span>
                                    @endif
                                </span>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Created By:</span>
                                <span class="fw-semibold text-dark">{{ $teamMember->creator?->name ?? 'System Seeder' }}</span>
                            </li>
                            <li class="d-flex justify-content-between pb-2 border-bottom">
                                <span class="text-muted">Created At:</span>
                                <span class="text-dark">{{ $teamMember->created_at?->format('M d, Y h:i A') ?? '—' }}</span>
                            </li>
                            <li class="d-flex justify-content-between">
                                <span class="text-muted">Last Updated:</span>
                                <span class="text-dark">{{ $teamMember->updated_at?->format('M d, Y h:i A') ?? '—' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
