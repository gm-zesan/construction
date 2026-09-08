@extends('admin.app')

@section('title')
    Dashboard
@endsection

@push('custom-style')
    <style>
        .stat-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px 18px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.06);
            border-color: #cbd5e1;
        }

        .stat-icon-wrapper {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 700;
            color: #0f172a;
            line-height: 1.2;
            margin: 4px 0 2px;
        }

        .stat-label {
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
        }

        .stat-link {
            font-size: 11.5px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: color 0.15s ease;
        }

        .stat-link:hover {
            text-decoration: underline;
        }

        .dashboard-section-card {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.02);
        }

        .dashboard-section-header {
            padding: 14px 20px;
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .dashboard-section-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dashboard-section-title::before {
            content: '';
            display: inline-block;
            width: 3px;
            height: 16px;
            background-color: #f95716;
            border-radius: 2px;
        }

        .dashboard-table th {
            background-color: #f8fafc;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 11px 16px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .dashboard-table td {
            padding: 12px 16px;
            vertical-align: middle;
            font-size: 13px;
            color: #334155;
            border-bottom: 1px solid #f1f5f9;
        }

        .dashboard-table tbody tr:hover {
            background-color: #fafbfc;
        }

        .dashboard-table tbody tr:last-child td {
            border-bottom: none;
        }

        .quick-action-btn {
            height: 32px;
            padding: 0 12px;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.15s ease;
            background-color: #ffffff;
            color: #334155;
            border: 1px solid #cbd5e1;
        }

        .quick-action-btn:hover {
            color: #f95716;
            background-color: #fff3ee;
            border-color: rgba(249, 87, 22, 0.35);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        {{-- Top Card Header adhering strictly to Theme Architecture --}}
        <div class="row mb-3">
            <div class="col-12">
                <div class="card table-card mb-0">
                    <div class="card-header table-header flex-wrap gap-3">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Dashboard Overview</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Overview</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            @canany(['project-create', 'superadmin'])
                                <a href="{{ route('projects.create') }}" class="add-new">
                                    <i class="ri-add-line me-1"></i> Add Project
                                </a>
                            @endcanany

                            @canany(['service-create', 'superadmin'])
                                <a href="{{ route('services.create') }}" class="quick-action-btn">
                                    <i class="ri-tools-line me-1"></i> Add Service
                                </a>
                            @endcanany

                            @canany(['article-create', 'superadmin'])
                                <a href="{{ route('articles.create') }}" class="quick-action-btn">
                                    <i class="ri-article-line me-1"></i> Add Article
                                </a>
                            @endcanany

                            @canany(['contact-list', 'superadmin'])
                                <a href="{{ route('enquiries.index') }}" class="quick-action-btn">
                                    <i class="ri-mail-line me-1"></i> Client Enquiries
                                </a>
                            @endcanany
                        </div>
                    </div>
                    <div class="card-body py-2 px-3 border-top" style="background-color: #fafbfc;">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-2">
                            <div style="font-size: 13px; color: #475569;">
                                Welcome back, <strong class="text-dark">{{ Auth::user()->name ?? 'Administrator' }}</strong>. Construction administration &amp; real-time operational overview.
                            </div>
                            <div class="d-flex align-items-center gap-3 text-muted" style="font-size: 12px;">
                                <span><i class="ri-calendar-line me-1 text-secondary"></i> {{ now()->format('l, d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 8 Real-Time KPI Statistics Cards --}}
        <div class="row g-3 mb-4">
            {{-- Total Projects --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Total Projects</div>
                            <div class="stat-value">{{ $stats['total_projects'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #eff6ff; color: #2563eb;">
                            <i class="ri-building-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('projects.index') }}" class="stat-link" style="color: #2563eb;">
                            View Portfolio <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge bg-light text-muted" style="font-size: 11px;">All Sectors</span>
                    </div>
                </div>
            </div>

            {{-- Ongoing Projects --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Ongoing Projects</div>
                            <div class="stat-value text-primary">{{ $stats['ongoing_projects'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #fff8f5; color: #f95716;">
                            <i class="ri-hammer-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('projects.index', ['status' => 'ongoing']) }}" class="stat-link" style="color: #f95716;">
                            Active Sites <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge" style="background-color: #fff3ee; color: #f95716; font-size: 11px; font-weight: 600;">In Progress</span>
                    </div>
                </div>
            </div>

            {{-- Completed Projects --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Completed Projects</div>
                            <div class="stat-value" style="color: #059669;">{{ $stats['completed_projects'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #ecfdf5; color: #059669;">
                            <i class="ri-checkbox-circle-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('projects.index', ['status' => 'completed']) }}" class="stat-link" style="color: #059669;">
                            Delivered <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge" style="background-color: #ecfdf5; color: #065f46; font-size: 11px; font-weight: 600;">Handed Over</span>
                    </div>
                </div>
            </div>

            {{-- Upcoming Projects --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Upcoming Projects</div>
                            <div class="stat-value" style="color: #4f46e5;">{{ $stats['upcoming_projects'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #eef2ff; color: #4f46e5;">
                            <i class="ri-calendar-event-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('projects.index', ['status' => 'upcoming']) }}" class="stat-link" style="color: #4f46e5;">
                            Mobilization <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge" style="background-color: #eff6ff; color: #1e40af; font-size: 11px; font-weight: 600;">Planning</span>
                    </div>
                </div>
            </div>

            {{-- Total Services --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Total Services</div>
                            <div class="stat-value" style="color: #7c3aed;">{{ $stats['total_services'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #f5f3ff; color: #7c3aed;">
                            <i class="ri-tools-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('services.index') }}" class="stat-link" style="color: #7c3aed;">
                            Manage Services <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge bg-light text-muted" style="font-size: 11px;">Capabilities</span>
                    </div>
                </div>
            </div>

            {{-- New Client Enquiries --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">New Enquiries</div>
                            <div class="stat-value" style="color: #dc2626;">{{ $stats['new_enquiries'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #fff1f2; color: #dc2626;">
                            <i class="ri-mail-unread-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('enquiries.index', ['status' => 'new']) }}" class="stat-link" style="color: #dc2626;">
                            Review Leads <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge" style="background-color: #fee2e2; color: #dc2626; font-size: 11px; font-weight: 700;">Unread</span>
                    </div>
                </div>
            </div>

            {{-- Total Articles --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">News &amp; Articles</div>
                            <div class="stat-value" style="color: #0284c7;">{{ $stats['total_articles'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #f0f9ff; color: #0284c7;">
                            <i class="ri-article-line"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('articles.index') }}" class="stat-link" style="color: #0284c7;">
                            Manage News <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge bg-light text-muted" style="font-size: 11px;">Blog Posts</span>
                    </div>
                </div>
            </div>

            {{-- Total Client Reviews --}}
            <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-12">
                <div class="stat-card">
                    <div class="d-flex align-items-start justify-content-between">
                        <div>
                            <div class="stat-label">Client Reviews</div>
                            <div class="stat-value" style="color: #d97706;">{{ $stats['total_reviews'] }}</div>
                        </div>
                        <div class="stat-icon-wrapper" style="background-color: #fef3c7; color: #d97706;">
                            <i class="ri-star-fill"></i>
                        </div>
                    </div>
                    <div class="pt-2 mt-2 border-top d-flex justify-content-between align-items-center">
                        <a href="{{ route('client-reviews.index') }}" class="stat-link" style="color: #d97706;">
                            Testimonials <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                        <span class="badge bg-light text-dark border" style="font-size: 11px; font-weight: 600;">Feedback</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Dashboard Data Tables Row --}}
        <div class="row g-4">
            {{-- Left Column: Recent Projects --}}
            <div class="col-xl-7 col-lg-12">
                <div class="dashboard-section-card h-100">
                    <div class="dashboard-section-header">
                        <h5 class="dashboard-section-title">Recent Projects</h5>
                        <a href="{{ route('projects.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="font-size: 12px; height: 32px; border-radius: 6px; font-weight: 600;">
                            View All Projects <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_projects->isEmpty())
                            <div class="text-center py-5">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #64748b;">
                                    <i class="ri-building-line" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">No projects yet</h6>
                                <p class="text-muted mb-3" style="font-size: 12.5px;">Get started by adding your first construction project.</p>
                                @canany(['project-create', 'superadmin'])
                                    <a href="{{ route('projects.create') }}" class="btn btn-sm btn-primary px-3" style="background-color: #f95716; border-color: #f95716; font-size: 12.5px;">
                                        <i class="ri-add-line me-1"></i> Create Project
                                    </a>
                                @endcanany
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table dashboard-table w-100 mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width: 45px;" class="text-center">Photo</th>
                                            <th>Project Title</th>
                                            <th>Category / Location</th>
                                            <th style="width: 110px;">Status</th>
                                            <th style="width: 100px;">Date</th>
                                            <th style="width: 80px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_projects as $project)
                                            <tr>
                                                <td class="text-center">
                                                    <div class="rounded overflow-hidden d-inline-flex align-items-center justify-content-center border" style="width: 42px; height: 42px; background: #f8fafc;">
                                                        <img src="{{ $project->main_image_url }}" alt="{{ $project->title }}"
                                                            onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                            style="width: 100%; height: 100%; object-fit: cover;">
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="{{ route('projects.show', $project->id) }}" class="fw-bold text-dark text-decoration-none text-truncate d-block" style="max-width: 220px; font-size: 13.5px;" title="{{ $project->title }}">
                                                        {{ $project->title }}
                                                    </a>
                                                    <span class="text-muted" style="font-size: 11px;">Slug: {{ $project->slug }}</span>
                                                </td>
                                                <td>
                                                    <span class="fw-semibold text-dark d-block" style="font-size: 12px;">{{ $project->category }}</span>
                                                    @if($project->location)
                                                        <span class="text-muted text-truncate d-block" style="font-size: 11.5px; max-width: 160px;">
                                                            <i class="ri-map-pin-line me-1 text-danger"></i>{{ $project->location }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $status = $project->status instanceof \App\Enums\ProjectStatus ? $project->status : \App\Enums\ProjectStatus::tryFrom($project->status);
                                                        $badgeStyle = match ($status) {
                                                            \App\Enums\ProjectStatus::COMPLETED => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                                                            \App\Enums\ProjectStatus::ONGOING => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                                                            \App\Enums\ProjectStatus::UPCOMING => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                                                            default => 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
                                                        };
                                                        $label = $status ? $status->label() : ucfirst((string) $project->status);
                                                    @endphp
                                                    <span class="badge" style="{{ $badgeStyle }} font-size: 11px; padding: 4px 8px; border-radius: 4px; font-weight: 600;">
                                                        {{ $label }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="text-muted" style="font-size: 12px;">{{ $project->created_at?->format('M d, Y') }}</span>
                                                </td>
                                                <td class="text-center">
                                                    <div class="d-inline-flex align-items-center gap-1">
                                                        <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-edit" title="View Project" style="background-color: #f1f5f9; color: #334155; width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                        @canany(['project-edit', 'superadmin'])
                                                            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-edit" title="Edit Project" style="width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                                <i class="ri-edit-line"></i>
                                                            </a>
                                                        @endcanany
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Right Column: Recent Client Enquiries --}}
            <div class="col-xl-5 col-lg-12">
                <div class="dashboard-section-card h-100">
                    <div class="dashboard-section-header">
                        <h5 class="dashboard-section-title">Recent Client Enquiries</h5>
                        <a href="{{ route('enquiries.index') }}" class="btn btn-sm btn-outline-secondary px-3" style="font-size: 12px; height: 32px; border-radius: 6px; font-weight: 600;">
                            View All <i class="ri-arrow-right-line ms-1"></i>
                        </a>
                    </div>
                    <div class="card-body p-0">
                        @if($recent_enquiries->isEmpty())
                            <div class="text-center py-5">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 48px; height: 48px; background-color: #f1f5f9; color: #64748b;">
                                    <i class="ri-mail-line" style="font-size: 24px;"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">No enquiries yet</h6>
                                <p class="text-muted mb-0" style="font-size: 12.5px;">New messages from potential clients will appear here.</p>
                            </div>
                        @else
                            <div class="table-responsive">
                                <table class="table dashboard-table w-100 mb-0">
                                    <thead>
                                        <tr>
                                            <th>Client Details</th>
                                            <th>Subject / Service</th>
                                            <th style="width: 90px;" class="text-center">Status</th>
                                            <th style="width: 50px;" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recent_enquiries as $enquiry)
                                            <tr>
                                                <td>
                                                    <div class="fw-bold text-dark" style="font-size: 13px;">{{ $enquiry->name }}</div>
                                                    <div class="text-muted text-truncate" style="font-size: 11px; max-width: 160px;" title="{{ $enquiry->email }}">
                                                        {{ $enquiry->company ?: $enquiry->email }}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-dark text-truncate" style="font-size: 12.5px; max-width: 170px;" title="{{ $enquiry->subject }}">
                                                        {{ $enquiry->subject }}
                                                    </div>
                                                    @if($enquiry->service)
                                                        <span class="badge" style="background-color: #f1f5f9; color: #334155; font-size: 10.5px; padding: 2px 6px; border-radius: 4px;">
                                                            {{ $enquiry->service->title }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted" style="font-size: 11px;">{{ $enquiry->submitted_at ? $enquiry->submitted_at->diffForHumans() : $enquiry->created_at->diffForHumans() }}</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $enqStatus = $enquiry->status instanceof \App\Enums\EnquiryStatus ? $enquiry->status : \App\Enums\EnquiryStatus::tryFrom($enquiry->status);
                                                        $style = $enqStatus ? $enqStatus->badgeStyle() : 'background-color: #f1f5f9; color: #475569;';
                                                        $label = $enqStatus ? $enqStatus->label() : ucfirst((string) $enquiry->status);
                                                    @endphp
                                                    <span class="badge" style="{{ $style }} font-size: 11px; padding: 3px 8px; border-radius: 4px; font-weight: 600;">
                                                        {{ $label }}
                                                    </span>
                                                </td>
                                                <td class="text-center">
                                                    @canany(['contact-list', 'superadmin'])
                                                        <a href="{{ route('enquiries.show', $enquiry->id) }}" class="btn btn-sm btn-edit" title="View Enquiry Details" style="background-color: #f1f5f9; color: #334155; width: 30px; height: 30px; padding: 0; display: inline-flex; align-items: center; justify-content: center; border-radius: 6px;">
                                                            <i class="ri-eye-line"></i>
                                                        </a>
                                                    @endcanany
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
