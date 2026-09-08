@extends('admin.app')

@section('title')
    Construction Dashboard
@endsection

@push('custom-style')
<style>
    .kpi-card {
        background: #ffffff;
        border-radius: 8px;
        border: 1px solid #e9edf4;
        box-shadow: 0 2px 4px rgba(17, 26, 58, 0.02);
        padding: 18px 20px;
        transition: all 0.25s ease-in-out;
        position: relative;
        height: 100%;
    }
    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 14px rgba(17, 26, 58, 0.06);
        border-color: #dbe2ea;
    }
    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        flex-shrink: 0;
    }
    .kpi-icon.orange { background-color: rgba(249, 87, 22, 0.12); color: #f95716; }
    .kpi-icon.purple { background-color: #f1f5f9; color: #0f172a; }
    .kpi-icon.blue { background-color: #e8f4fd; color: #1a88cb; }
    .kpi-icon.green { background-color: #e8f8f0; color: #16a34a; }
    .kpi-icon.amber { background-color: #fff8dd; color: #b58105; }

    .kpi-label {
        font-size: 13px;
        font-weight: 500;
        color: #536485;
        margin-bottom: 4px;
    }
    .kpi-value {
        font-size: 24px;
        font-weight: 700;
        color: #111a3a;
        line-height: 1.2;
        margin-bottom: 4px;
    }
    .kpi-sub {
        font-size: 11.5px;
        color: #8c98a9;
    }
    .kpi-link {
        font-size: 12px;
        font-weight: 500;
        color: #f95716;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        transition: all 0.2s ease;
    }
    .kpi-link:hover {
        color: #ea4907;
        text-decoration: underline;
    }

    .status-pill {
        display: inline-block;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 600;
        border-radius: 4px;
        text-transform: capitalize;
    }
    .status-pill.pending { background-color: #fff8dd; color: #b58105; border: 1px solid #f7e6a5; }
    .status-pill.verified { background-color: #e8f4fd; color: #1a88cb; border: 1px solid #bce1f9; }
    .status-pill.in_progress { background-color: rgba(249, 87, 22, 0.12); color: #f95716; border: 1px solid rgba(249, 87, 22, 0.25); }
    .status-pill.approved { background-color: #e8f8f0; color: #16a34a; border: 1px solid #bbf0d4; }
    .status-pill.rejected { background-color: #feecee; color: #e11d48; border: 1px solid #fcc2ca; }

    .dashboard-table-card {
        background-color: #fff;
        border-radius: 8px;
        border: 1px solid #e9edf4;
        box-shadow: 0 2px 4px rgba(17, 26, 58, 0.02);
        margin-bottom: 24px;
    }
    .dashboard-table-card .card-header {
        background-color: #fff;
        padding: 16px 20px;
        border-bottom: 1px solid #f0f1f7;
        border-radius: 8px 8px 0 0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .dashboard-table-card .card-title {
        font-size: 15px;
        font-weight: 600;
        color: #1d1b31;
        position: relative;
        padding-left: 12px;
        margin-bottom: 0;
    }
    .dashboard-table-card .card-title::before {
        content: "";
        position: absolute;
        height: 16px;
        width: 3px;
        top: 2px;
        left: 0;
        background: #f95716;
        border-radius: 4px;
    }
    .dashboard-table-card table th {
        font-size: 12px;
        font-weight: 600;
        color: #536485;
        background-color: #f8fafc;
        border-bottom: 1px solid #e9edf4;
        padding: 12px 16px;
    }
    .dashboard-table-card table td {
        font-size: 13px;
        color: #333335;
        vertical-align: middle;
        padding: 13px 16px;
        border-bottom: 1px solid #f0f1f7;
    }

    .pipeline-progress-bar {
        height: 7px;
        border-radius: 4px;
        overflow: hidden;
        background-color: #f1f3f7;
    }
    .pipeline-progress-fill {
        height: 100%;
        background-color: #f95716;
        border-radius: 4px;
    }

    .quick-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .quick-action-btn.primary {
        background-color: #f95716;
        color: #ffffff;
    }
    .quick-action-btn.primary:hover {
        background-color: #ea4907;
        color: #ffffff;
    }
    .quick-action-btn.light {
        background-color: #f8fafc;
        color: #1e293b;
        border: 1px solid #e2e8f0;
    }
    .quick-action-btn.light:hover {
        background-color: #f1f5f9;
        color: #0f172a;
    }
</style>
@endpush

@section('content')
<div class="container-fluid my-4">

    <!-- Page Title & Actions Header -->
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1" style="color: #111a3a;">Operations Dashboard</h4>
            <p class="text-muted mb-0" style="font-size: 13px;">Welcome back, <strong class="text-dark">{{ Auth::user()->name ?? 'Administrator' }}</strong>. Here is the active overview of site activities and portfolio.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('home') }}" target="_blank" class="quick-action-btn light">
                <i class="ri-external-link-line"></i> View Live Site
            </a>
            <button type="button" class="quick-action-btn primary" onclick="showToast('New project modal initialized!', false, 'Project Action')">
                <i class="ri-add-line"></i> New Project
            </button>
        </div>
    </div>

    <!-- KPI Metric Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Card 1: Active Projects -->
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-label">Active Field Sites</div>
                        <div class="kpi-value">{{ $stats['active_sites'] }}</div>
                        <div class="kpi-sub">Total Portfolio: <span class="fw-semibold text-dark">{{ $stats['total_projects'] }}</span> Projects</div>
                    </div>
                    <div class="kpi-icon orange">
                        <i class="ri-building-2-line"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <a href="#projects-table" class="kpi-link">View project list <i class="ms-1 ri-arrow-right-line"></i></a>
                    <span class="badge bg-light text-success fw-semibold" style="font-size: 11px;">Active Execution</span>
                </div>
            </div>
        </div>

        <!-- Card 2: Client Inquiries -->
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-label">Client Inquiries</div>
                        <div class="kpi-value">{{ $stats['total_inquiries'] }}</div>
                        <div class="kpi-sub">Today: <span class="fw-semibold text-dark">+{{ $stats['today_inquiries'] }}</span> | 7d: <span class="fw-semibold text-dark">+{{ $stats['week_inquiries'] }}</span></div>
                    </div>
                    <div class="kpi-icon purple">
                        <i class="ri-mail-unread-line"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <a href="#messages" class="kpi-link" style="color: #f95716;">View all inquiries <i class="ms-1 ri-arrow-right-line"></i></a>
                    <span class="badge bg-light text-muted fw-normal" style="font-size: 11px;">Lead Pipeline</span>
                </div>
            </div>
        </div>

        <!-- Card 3: Team & Superintendents -->
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-label">Engineering Personnel</div>
                        <div class="kpi-value">{{ $stats['team_engineers'] }}</div>
                        <div class="kpi-sub">Field Superintendents: <span class="fw-semibold text-dark">14 On-Site</span></div>
                    </div>
                    <div class="kpi-icon blue">
                        <i class="ri-team-line"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted" style="font-size: 12px;">Licensed Engineers</span>
                    <span class="badge bg-light text-primary fw-semibold" style="font-size: 11px;">Deployed</span>
                </div>
            </div>
        </div>

        <!-- Card 4: Safety & Compliance -->
        <div class="col-xl-3 col-md-6">
            <div class="kpi-card">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <div class="kpi-label">Safety Compliance Score</div>
                        <div class="kpi-value">{{ $stats['safety_score'] }}%</div>
                        <div class="kpi-sub">Zero Lost-Time Incidents (YTD)</div>
                    </div>
                    <div class="kpi-icon green">
                        <i class="ri-shield-check-line"></i>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top d-flex justify-content-between align-items-center">
                    <span class="text-muted" style="font-size: 12px;">OSHA &amp; ISO 45001</span>
                    <span class="badge bg-light text-success fw-semibold" style="font-size: 11px;">Certified</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Row: Active Projects Table & Recent Inquiries -->
    <div class="row g-4" id="projects-table">
        <!-- Left: Project Portfolio Execution -->
        <div class="col-xl-7 col-lg-12">
            <div class="dashboard-table-card h-100 mb-0">
                <div class="card-header">
                    <h5 class="card-title">Active Construction Projects</h5>
                    <span class="badge bg-light text-dark fw-semibold" style="font-size: 12px;">{{ count($recent_projects) }} Key Projects</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table w-100 mb-0">
                            <thead>
                                <tr>
                                    <th>Project Details</th>
                                    <th>Location</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_projects as $project)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $project['name'] }}</div>
                                            <div class="text-muted" style="font-size: 11.5px;">{{ $project['category'] }} &bull; <span class="fw-medium text-slate-600">{{ $project['budget'] }}</span></div>
                                        </td>
                                        <td>
                                            <span class="text-muted" style="font-size: 12px;"><i class="ri-map-pin-line me-1 text-danger"></i>{{ $project['location'] }}</span>
                                        </td>
                                        <td style="min-width: 130px;">
                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                <span class="text-muted" style="font-size: 11px;">Topping-out</span>
                                                <span class="fw-semibold text-dark" style="font-size: 11.5px;">{{ $project['progress'] }}%</span>
                                            </div>
                                            <div class="pipeline-progress-bar">
                                                <div class="pipeline-progress-fill" style="width: {{ $project['progress'] }}%;"></div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($project['status'] === 'in_progress')
                                                <span class="status-pill in_progress">In Progress</span>
                                            @elseif($project['status'] === 'approved')
                                                <span class="status-pill approved">Completed</span>
                                            @elseif($project['status'] === 'verified')
                                                <span class="status-pill verified">Framing</span>
                                            @else
                                                <span class="status-pill pending">Planning</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <div class="d-inline-flex align-items-center gap-1">
                                                <button type="button" class="btn-view" title="View Project" onclick="showToast('Viewing {{ addslashes($project['name']) }}', false, 'Project Details')">
                                                    <i class="ri-eye-line"></i>
                                                </button>
                                                <button type="button" class="btn-edit" title="Edit Milestones" onclick="showToast('Edit modal for {{ addslashes($project['name']) }}', false, 'Project Edit')">
                                                    <i class="ri-pencil-line"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Recent Client Inquiries -->
        <div class="col-xl-5 col-lg-12" id="messages">
            <div class="dashboard-table-card h-100 mb-0">
                <div class="card-header">
                    <h5 class="card-title">Recent Client Inquiries</h5>
                    <button type="button" class="btn btn-sm" style="color: #f95716; font-weight: 500; font-size: 13px;" onclick="showToast('Refreshed recent inquiries list', false, 'Client Messages')">
                        Refresh <i class="ri-refresh-line ms-1"></i>
                    </button>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table w-100 mb-0">
                            <thead>
                                <tr>
                                    <th>Client / Company</th>
                                    <th>Scope / Type</th>
                                    <th>Message Snippet</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recent_inquiries as $msg)
                                    <tr>
                                        <td>
                                            <div class="fw-semibold text-dark">{{ $msg['name'] }}</div>
                                            <div class="text-muted" style="font-size: 11px;">{{ $msg['company'] }}</div>
                                        </td>
                                        <td>
                                            <span class="badge bg-light text-dark fw-medium" style="font-size: 11px;">{{ $msg['project_type'] }}</span>
                                        </td>
                                        <td>
                                            <div class="text-muted text-truncate" style="max-width: 170px; font-size: 12px;" title="{{ $msg['message'] }}">
                                                {{ $msg['message'] }}
                                            </div>
                                            <div class="text-muted" style="font-size: 10.5px;">{{ $msg['date'] }}</div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
