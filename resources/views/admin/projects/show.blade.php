@extends('admin.app')
@section('title')
    Project Details - {{ $project->title }}
@endsection

@push('custom-style')
    <style>
        .project-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .project-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .project-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .scope-content-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            font-size: 14px;
            line-height: 1.8;
            color: #334155;
        }

        .scope-content-box img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
        }

        .gallery-thumb-item {
            position: relative;
            border-radius: 6px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            height: 100px;
            background: #000;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .gallery-thumb-item:hover {
            transform: scale(1.03);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .gallery-thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Main Content Column --}}
            <div class="col-lg-8 col-12">
                {{-- Main Project Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Project Details: {{ $project->title }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('projects.index') }}">Projects</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('projects.index') }}" class="add-new"
                                style="background-color: #f1f5f9; color: #334155;">
                                <i class="ri-arrow-left-line me-1"></i> Project List
                            </a>
                            @can('project-edit')
                                <a href="{{ route('projects.edit', $project->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Project
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body custom-form p-4">
                        {{-- Cover Image Showcase --}}
                        <div class="position-relative rounded overflow-hidden mb-4 border"
                            style="height: 260px; background: #0b0f17;">
                            <img src="{{ $project->main_image_url }}" alt="{{ $project->title }}"
                                onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between align-items-end"
                                style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);">
                                <div>
                                    <span class="badge bg-primary mb-1"
                                        style="font-size: 11px;">{{ $project->category }}</span>
                                    <h4 class="text-white fw-bold mb-0" style="font-size: 20px;">{{ $project->title }}</h4>
                                </div>
                                <div class="d-flex gap-2">
                                    @php
                                        $status = $project->status instanceof \App\Enums\ProjectStatus ? $project->status : \App\Enums\ProjectStatus::tryFrom($project->status);
                                        $badgeStyle = match ($status) {
                                            \App\Enums\ProjectStatus::COMPLETED => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                                            \App\Enums\ProjectStatus::ONGOING => 'background-color: #fff3ee; color: #f95716; border: 1px solid rgba(249, 87, 22, 0.3);',
                                            \App\Enums\ProjectStatus::UPCOMING => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                                            default => 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;',
                                        };
                                    @endphp
                                    <span class="badge"
                                        style="{{ $badgeStyle }} font-size: 11.5px; padding: 5px 10px; border-radius: 4px; font-weight: 700;">
                                        {{ $status ? $status->label() : ucfirst($project->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Executive Summary --}}
                        @if($project->short_description)
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Executive Summary
                                </h6>
                                <p class="text-dark mb-0 p-3 rounded"
                                    style="background-color: #f8fafc; border: 1px solid #e2e8f0; font-size: 13.5px; line-height: 1.7;">
                                    {{ $project->short_description }}
                                </p>
                            </div>
                        @endif

                        {{-- Full Description / Case Study --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"
                                style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                Detailed Scope of Work &amp; Case Study
                            </h6>
                            <div class="scope-content-box">
                                {!! $project->description ?: '<em class="text-muted">No detailed scope of work provided.</em>' !!}
                            </div>
                        </div>

                        {{-- Project Gallery --}}
                        @if($project->getMedia('gallery')->isNotEmpty())
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Photo Gallery ({{ $project->getMedia('gallery')->count() }} Photos)
                                </h6>
                                <div class="row g-2">
                                    @foreach($project->getMedia('gallery') as $media)
                                        @php
                                            $mediaUrl = $media->getUrl();
                                            if (\Illuminate\Support\Str::startsWith($mediaUrl, ['http://', 'https://'])) {
                                                $mediaUrl = parse_url($mediaUrl, PHP_URL_PATH) ?: $mediaUrl;
                                            }
                                        @endphp
                                        <div class="col-6 col-sm-4 col-md-3">
                                            <a href="{{ $mediaUrl }}" target="_blank" class="d-block gallery-thumb-item"
                                                title="{{ $media->file_name }}">
                                                <img src="{{ $mediaUrl }}" alt="{{ $media->name }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';">
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- Technical Documents --}}
                        @if($project->getMedia('documents')->isNotEmpty())
                            <div class="mb-2">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Engineering &amp; Technical Documents
                                </h6>
                                <ul class="list-group list-group-flush border rounded overflow-hidden">
                                    @foreach($project->getMedia('documents') as $doc)
                                        @php
                                            $docUrl = $doc->getUrl();
                                            if (\Illuminate\Support\Str::startsWith($docUrl, ['http://', 'https://'])) {
                                                $docUrl = parse_url($docUrl, PHP_URL_PATH) ?: $docUrl;
                                            }
                                        @endphp
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-2 px-3"
                                            style="font-size: 13px; background: #f8fafc;">
                                            <div class="d-flex align-items-center text-truncate me-2">
                                                <i class="ri-file-pdf-line text-danger me-2" style="font-size: 20px;"></i>
                                                <span class="fw-semibold text-dark text-truncate">{{ $doc->file_name }}</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <span class="badge bg-light text-dark border">{{ $doc->readable_size }}</span>
                                                <a href="{{ $docUrl }}" target="_blank"
                                                    class="btn btn-sm btn-outline-primary py-0 px-2"
                                                    style="font-size: 12px; height: 26px; line-height: 24px;">
                                                    <i class="ri-download-2-line me-1"></i> View
                                                </a>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- SEO Information Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title">SEO &amp; Search Engine Visibility</div>
                    </div>
                    <div class="card-body custom-form p-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="project-meta-box">
                                    <div class="project-meta-label">Meta Title</div>
                                    <div class="project-meta-value">{{ $project->meta_title ?: '—' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="project-meta-box">
                                    <div class="project-meta-label">Meta Description</div>
                                    <div class="project-meta-value text-muted" style="font-weight: 400;">
                                        {{ $project->meta_description ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Parameters Column --}}
            <div class="col-lg-4 col-12">
                <div class="row g-4">
                    {{-- Status & Visibility Parameters --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Project Specifications</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-3">
                                    <div class="project-meta-box">
                                        <div class="project-meta-label">Sector / Category</div>
                                        <div class="project-meta-value">{{ $project->category }}</div>
                                    </div>

                                    <div class="project-meta-box">
                                        <div class="project-meta-label">Client / Stakeholder</div>
                                        <div class="project-meta-value">
                                            {{ $project->client_name ?: 'Confidential / Direct' }}</div>
                                    </div>

                                    <div class="project-meta-box">
                                        <div class="project-meta-label">Site Location</div>
                                        <div class="project-meta-value">
                                            @if($project->location)
                                                <i class="ri-map-pin-line text-danger me-1"></i> {{ $project->location }}
                                            @else
                                                <span class="text-muted">Not specified</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row g-2">
                                        <div class="col-6">
                                            <div class="project-meta-box">
                                                <div class="project-meta-label">Commenced</div>
                                                <div class="project-meta-value" style="font-size: 12.5px;">
                                                    {{ $project->start_date ? $project->start_date->format('M d, Y') : '—' }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="project-meta-box">
                                                <div class="project-meta-label">Completion</div>
                                                <div class="project-meta-value" style="font-size: 12.5px;">
                                                    {{ $project->completion_date ? $project->completion_date->format('M d, Y') : '—' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="project-meta-box">
                                        <div class="project-meta-label">Slug Identifier</div>
                                        <div class="project-meta-value font-monospace" style="font-size: 12px;">
                                            {{ $project->slug }}</div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-2 rounded"
                                        style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <span class="fw-semibold text-dark" style="font-size: 13px;">Website
                                            Visibility:</span>
                                        <span class="badge {{ $project->is_published ? 'bg-success' : 'bg-secondary' }}"
                                            style="font-size: 11px;">
                                            {{ $project->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-2 rounded"
                                        style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <span class="fw-semibold text-dark" style="font-size: 13px;">Homepage
                                            Featured:</span>
                                        <span
                                            class="badge {{ $project->featured ? 'bg-warning text-dark' : 'bg-light text-muted border' }}"
                                            style="font-size: 11px;">
                                            {{ $project->featured ? 'Featured' : 'Standard' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions Card --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Quick Actions</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-2">
                                    @can('project-edit')
                                        <a href="{{ route('projects.edit', $project->id) }}"
                                            class="btn submit-button w-100 d-flex align-items-center justify-content-center gap-1">
                                            <i class="ri-edit-line"></i> Edit Project
                                        </a>
                                    @endcan
                                    @can('project-delete')
                                        <button type="button" class="btn btn-outline-danger w-100 btn-delete-modal"
                                            data-title="{{ $project->title }}"
                                            data-url="{{ route('projects.destroy', $project->id) }}"
                                            style="height: 36px; font-size: 13px; font-weight: 600;">
                                            <i class="ri-delete-bin-line me-1"></i> Delete Project
                                        </button>
                                    @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteProjectModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                            Confirm Project Deletion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p class="mb-2" style="font-size: 14px; color: #334155;">
                        Are you sure you want to permanently delete project <strong id="deleteProjectTitle"
                            class="text-dark"></strong>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">
                        This action will remove all gallery media, specs, and documents associated with this project.
                    </p>
                </div>
                <div class="modal-footer"
                    style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                        style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                    <form id="deleteProjectForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger px-4"
                            style="font-size: 13px; height: 36px; border-radius: 6px; font-weight: 600;">
                            Delete Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '.btn-delete-modal', function () {
                var title = $(this).data('title');
                var url = $(this).data('url');

                $('#deleteProjectTitle').text(title);
                $('#deleteProjectForm').attr('action', url);
                $('#deleteProjectModal').modal('show');
            });
        });
    </script>
@endpush