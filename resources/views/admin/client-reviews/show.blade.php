@extends('admin.app')
@section('title')
    Review: {{ $review->client_name }}
@endsection

@push('custom-style')
    <style>
        .review-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .review-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .review-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .testimonial-showcase-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 24px;
            position: relative;
        }

        .testimonial-quote-icon {
            font-size: 38px;
            color: rgba(249, 87, 22, 0.15);
            line-height: 1;
            margin-bottom: 12px;
        }

        .testimonial-text-content {
            font-size: 15px;
            line-height: 1.8;
            color: #334155;
            font-style: italic;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Main Content Column --}}
            <div class="col-lg-8 col-12">
                {{-- Client Profile Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Review from {{ $review->client_name }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('client-reviews.index') }}">Client
                                            Reviews</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('client-reviews.index') }}" class="add-new"
                                style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;">
                                <i class="ri-arrow-left-line me-1"></i> Reviews List
                            </a>
                            @canany(['client-review-edit', 'review-edit'])
                                <a href="{{ route('client-reviews.edit', $review->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Review
                                </a>
                            @endcanany
                        </div>
                    </div>

                    <div class="card-body custom-form p-4">
                        {{-- Client Hero Header --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between p-3 rounded mb-4"
                            style="background: #f8fafc; border: 1px solid #e2e8f0;">
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle overflow-hidden d-flex align-items-center justify-content-center border"
                                    style="width: 72px; height: 72px; background: #ffffff;">
                                    @if($review->client_photo_url)
                                        <img src="{{ $review->client_photo_url }}" alt="{{ $review->client_name }}"
                                            style="width: 100%; height: 100%; object-fit: cover;">
                                    @else
                                        <div class="text-primary fw-bold" style="font-size: 22px;">
                                            {{ strtoupper(substr($review->client_name, 0, 2)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1" style="font-size: 19px;">{{ $review->client_name }}
                                    </h4>
                                    <div class="text-muted" style="font-size: 13px;">
                                        @if($review->designation && $review->company_name)
                                            <span class="text-dark fw-medium">{{ $review->designation }}</span> at <strong
                                                class="text-dark">{{ $review->company_name }}</strong>
                                        @elseif($review->designation)
                                            <span class="text-dark fw-medium">{{ $review->designation }}</span>
                                        @elseif($review->company_name)
                                            <strong class="text-dark">{{ $review->company_name }}</strong>
                                        @else
                                            <span>Valued Client</span>
                                        @endif
                                    </div>
                                    <div class="d-flex align-items-center gap-1 mt-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="ri-star-fill {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"
                                                style="font-size: 14px; {{ $i > $review->rating ? 'opacity: 0.3;' : '' }}"></i>
                                        @endfor
                                        <span class="badge bg-white text-dark border ms-1"
                                            style="font-size: 11px; font-weight: 700;">
                                            {{ $review->rating }}.0 / 5.0 Rating
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end gap-2 mt-3 mt-sm-0">
                                @if($review->is_published)
                                    <span class="badge"
                                        style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 12px; padding: 6px 12px; font-weight: 700; border-radius: 4px;">
                                        <i class="ri-checkbox-circle-line me-1"></i> Live on Website
                                    </span>
                                @else
                                    <span class="badge"
                                        style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 12px; padding: 6px 12px; font-weight: 700; border-radius: 4px;">
                                        Hidden / Draft
                                    </span>
                                @endif

                                @if($review->featured)
                                    <span class="badge"
                                        style="background-color: #fff7ed; color: #ea580c; border: 1px solid rgba(249,87,22,0.3); font-size: 11.5px; padding: 4px 10px; border-radius: 4px;">
                                        <i class="ri-star-fill me-1"></i> Featured on Homepage
                                    </span>
                                @endif
                            </div>
                        </div>

                        {{-- Testimonial Showcase Box --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"
                                style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                Client Testimonial Content
                            </h6>
                            <div class="testimonial-showcase-box">
                                <i class="ri-double-quotes-l testimonial-quote-icon"></i>
                                <div class="testimonial-text-content">
                                    "{{ $review->review }}"
                                </div>
                            </div>
                        </div>

                        {{-- Associated Project Section (if linked) --}}
                        @if($review->project)
                            <div class="mb-2">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Associated Construction Project
                                </h6>
                                <div class="p-3 rounded border d-flex flex-wrap align-items-center justify-content-between gap-3"
                                    style="background-color: #f8fafc;">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="rounded overflow-hidden border"
                                            style="width: 64px; height: 50px; background: #e2e8f0;">
                                            <img src="{{ $review->project->thumbnail_url }}" alt="{{ $review->project->title }}"
                                                onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                style="width: 100%; height: 100%; object-fit: cover;">
                                        </div>
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">
                                                {{ $review->project->title }}</h6>
                                            <span class="text-muted" style="font-size: 12px;">
                                                <i class="ri-map-pin-line me-1"></i>
                                                {{ $review->project->location ?: 'Location on file' }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('projects.show', $review->project->id) }}"
                                        class="btn btn-sm btn-outline-primary px-3">
                                        <i class="ri-external-link-line me-1"></i> View Project
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Sidebar Parameters Column --}}
            <div class="col-lg-4 col-12">
                <div class="row g-3">
                    {{-- Review Specifications Card --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Review Specifications</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-3">
                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Visibility Status</div>
                                        <div class="review-meta-value">
                                            @if($review->is_published)
                                                <span class="badge"
                                                    style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="ri-checkbox-circle-line me-1"></i> Published
                                                </span>
                                            @else
                                                <span class="badge"
                                                    style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    Draft / Hidden
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Homepage Spotlight</div>
                                        <div class="review-meta-value">
                                            @if($review->featured)
                                                <span class="badge"
                                                    style="background-color: #fff7ed; color: #ea580c; border: 1px solid rgba(249,87,22,0.3); font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="ri-star-line me-1"></i> Featured on Homepage
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-size: 13px;">Standard Display</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Client Rating Score</div>
                                        <div class="review-meta-value text-warning">
                                            <i class="ri-star-fill text-warning me-1"></i> {{ $review->rating }}.0 of 5.0
                                            Stars
                                        </div>
                                    </div>

                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Display Priority Order</div>
                                        <div class="review-meta-value">
                                            #{{ $review->sort_order }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Audit Trail Card --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Audit Trail &amp; History</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-3">
                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Created By</div>
                                        <div class="review-meta-value text-muted" style="font-size: 13px;">
                                            {{ $review->creator?->name ?? 'System Administrator' }}
                                            <div class="text-muted" style="font-size: 11px; font-weight: 400;">
                                                {{ $review->created_at?->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="review-meta-box">
                                        <div class="review-meta-label">Last Modified</div>
                                        <div class="review-meta-value text-muted" style="font-size: 13px;">
                                            {{ $review->updater?->name ?? 'System Administrator' }}
                                            <div class="text-muted" style="font-size: 11px; font-weight: 400;">
                                                {{ $review->updated_at?->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection