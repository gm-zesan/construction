@extends('admin.app')
@section('title')
    Milestone Details - {{ $milestone->title }}
@endsection

@push('custom-style')
<style>
    .milestone-meta-box {
        background-color: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 14px 16px;
    }
    .milestone-meta-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #64748b;
        margin-bottom: 3px;
    }
    .milestone-meta-value {
        font-size: 13.5px;
        font-weight: 600;
        color: #1e293b;
    }
    .description-box {
        background-color: #ffffff;
        border: 1px solid #e2e8f0;
        border-left: 4px solid #f95716;
        border-radius: 6px;
        padding: 16px 18px;
        font-size: 14px;
        line-height: 1.7;
        color: #334155;
        white-space: pre-wrap;
    }
    .project-card-mini {
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        overflow: hidden;
        background: #ffffff;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Left Column: Milestone Progress & Verification Details --}}
            <div class="col-lg-8 col-12">
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Milestone Overview</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('milestones.index') }}">Milestones</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex gap-2">
                            @can('milestone-edit')
                                <a href="{{ route('milestones.edit', $milestone->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Milestone
                                </a>
                            @endcan
                            <a href="{{ route('milestones.index') }}" class="add-new" style="background-color: #f1f5f9; color: #334155;">
                                <i class="ri-arrow-left-line me-1"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body custom-form p-4">
                        {{-- Milestone Header Banner --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-4 border-bottom gap-3">
                            <div>
                                <h4 class="fw-bold text-dark mb-1" style="font-size: 18px;">{{ $milestone->title }}</h4>
                                <span class="text-muted" style="font-size: 12.5px;">
                                    Slug: <code class="text-primary">{{ $milestone->slug }}</code> • Sequence Priority: <strong>#{{ $milestone->sort_order }}</strong>
                                </span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge" style="{{ $milestone->status->badgeStyle() }} font-size: 13px; padding: 6px 12px; border-radius: 6px; font-weight: 700;">
                                    {{ $milestone->status->label() }}
                                </span>
                                @if($milestone->is_published)
                                    <span class="badge bg-success" style="font-size: 12px; padding: 6px 10px;">
                                        <i class="ri-eye-line me-1"></i> Public
                                    </span>
                                @else
                                    <span class="badge bg-secondary" style="font-size: 12px; padding: 6px 10px;">
                                        <i class="ri-eye-off-line me-1"></i> Hidden
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Progress Bar Banner --}}
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="milestone-meta-label">Completion Progress</span>
                                <span class="fw-bold text-primary" style="font-size: 15px;">{{ $milestone->progress_percentage }}%</span>
                            </div>
                            @php
                                $pct = $milestone->progress_percentage ?? 0;
                                $barClass = $pct >= 100 ? 'bg-success' : ($pct >= 50 ? 'bg-primary' : 'bg-warning');
                            @endphp
                            <div class="progress" style="height: 10px; background-color: #e2e8f0; border-radius: 5px;">
                                <div class="progress-bar {{ $barClass }} progress-bar-striped" role="progressbar" style="width: {{ $pct }}%"></div>
                            </div>
                        </div>

                        {{-- Verification Site Photo --}}
                        @if($milestone->image_url)
                            <div class="mb-4">
                                <label class="form-label milestone-meta-label">Site Verification &amp; Evidence Photo</label>
                                <div class="position-relative rounded overflow-hidden" style="max-height: 380px; background: #0f172a;">
                                    <img src="{{ $milestone->image_url }}" alt="{{ $milestone->title }}" class="w-100 object-fit-contain" style="max-height: 380px;">
                                </div>
                            </div>
                        @endif

                        {{-- Phase Description --}}
                        <div class="mb-4">
                            <label class="form-label milestone-meta-label">Phase Description &amp; Scope</label>
                            <div class="description-box">
                                {{ $milestone->description ?: 'No detailed description provided for this milestone phase.' }}
                            </div>
                        </div>

                        {{-- Target vs Actual Timetable Grid --}}
                        <div>
                            <label class="form-label milestone-meta-label">Milestone Timetable &amp; Schedule</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="milestone-meta-box">
                                        <div class="milestone-meta-label"><i class="ri-calendar-event-line me-1"></i> Target Completion Date</div>
                                        <div class="milestone-meta-value">
                                            {{ $milestone->target_date->format('F d, Y') }}
                                            <span class="text-muted fw-normal d-block" style="font-size: 12px;">({{ $milestone->target_date->diffForHumans() }})</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="milestone-meta-box">
                                        <div class="milestone-meta-label"><i class="ri-checkbox-circle-line me-1"></i> Actual Handover Date</div>
                                        <div class="milestone-meta-value">
                                            @if($milestone->completion_date)
                                                <span class="text-success">{{ $milestone->completion_date->format('F d, Y') }}</span>
                                                <span class="text-muted fw-normal d-block" style="font-size: 12px;">({{ $milestone->completion_date->diffForHumans() }})</span>
                                            @else
                                                <span class="text-muted fw-normal">Pending Completion</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Project Context & Governance --}}
            <div class="col-lg-4 col-12">
                {{-- Associated Project Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title" style="font-size: 14px;">Associated Construction Project</div>
                    </div>
                    <div class="card-body p-3">
                        @if($milestone->project)
                            <div class="project-card-mini mb-3">
                                <div style="height: 120px; overflow: hidden; background: #e2e8f0;">
                                    <img src="{{ $milestone->project->main_image_url }}" alt="{{ $milestone->project->title }}" class="w-100 h-100 object-fit-cover">
                                </div>
                                <div class="p-3">
                                    <h6 class="fw-bold text-dark mb-1" style="font-size: 14.5px;">{{ $milestone->project->title }}</h6>
                                    <span class="badge bg-light text-dark border mb-2" style="font-size: 11px;">{{ ucfirst($milestone->project->category) }}</span>
                                    <div class="text-muted" style="font-size: 12px; line-height: 1.5;">
                                        @if($milestone->project->location)
                                            <div><i class="ri-map-pin-line me-1 text-danger"></i> {{ $milestone->project->location }}</div>
                                        @endif
                                        @if($milestone->project->client_name)
                                            <div><i class="ri-user-line me-1 text-primary"></i> Client: {{ $milestone->project->client_name }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('projects.show', $milestone->project->id) }}" class="btn btn-sm btn-outline-primary w-100" style="font-weight: 600; font-size: 12.5px;">
                                <i class="ri-external-link-line me-1"></i> View Full Project Portfolio
                            </a>
                        @else
                            <div class="text-muted text-center py-3" style="font-size: 13px;">No project attached.</div>
                        @endif
                    </div>
                </div>

                {{-- Audit & Governance Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title" style="font-size: 14px;">Audit &amp; Governance</div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-2">
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                <span class="text-muted" style="font-size: 12px;">Created By:</span>
                                <span class="fw-semibold text-dark" style="font-size: 12.5px;">{{ $milestone->creator?->name ?? 'System' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                <span class="text-muted" style="font-size: 12px;">Last Updated By:</span>
                                <span class="fw-semibold text-dark" style="font-size: 12.5px;">{{ $milestone->updater?->name ?? 'System' }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                <span class="text-muted" style="font-size: 12px;">Creation Date:</span>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">{{ $milestone->created_at?->format('M d, Y') }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center py-1">
                                <span class="text-muted" style="font-size: 12px;">Last Modified:</span>
                                <span class="fw-semibold text-dark" style="font-size: 12px;">{{ $milestone->updated_at?->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
