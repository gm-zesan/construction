@extends('admin.app')
@section('title')
    Service Details - {{ $service->title }}
@endsection

@push('custom-style')
    <style>
        .service-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .service-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .service-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .service-desc-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 20px;
            font-size: 14px;
            line-height: 1.8;
            color: #334155;
        }

        .service-desc-box img {
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
                {{-- Main Service Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Service Details: {{ $service->title }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('services.index') }}" class="add-new"
                                style="background-color: #f1f5f9; color: #334155;">
                                <i class="ri-arrow-left-line me-1"></i> Services List
                            </a>
                            @can('service-edit')
                                <a href="{{ route('services.edit', $service->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Service
                                </a>
                            @endcan
                        </div>
                    </div>
                    <div class="card-body custom-form p-4">
                        {{-- Service Hero Banner / Main Image --}}
                        <div class="position-relative rounded overflow-hidden mb-4 border"
                            style="height: 240px; background: #0b0f17;">
                            <img src="{{ $service->image_url }}" alt="{{ $service->title }}"
                                onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between align-items-end"
                                style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded d-flex align-items-center justify-content-center text-white"
                                        style="width: 44px; height: 44px; background-color: #f95716; font-size: 22px; flex-shrink: 0;">
                                        <i class="{{ $service->icon ?: 'ri-hammer-line' }}"></i>
                                    </div>
                                    <div>
                                        <h4 class="text-white fw-bold mb-0" style="font-size: 20px;">{{ $service->title }}
                                        </h4>
                                        <span class="text-white-50" style="font-size: 12px;">URL Slug:
                                            {{ $service->slug }}</span>
                                    </div>
                                </div>
                                <div class="d-flex gap-2">
                                    <span class="badge {{ $service->is_published ? 'bg-success' : 'bg-secondary' }}"
                                        style="font-size: 11.5px; padding: 5px 10px;">
                                        {{ $service->is_published ? 'Published' : 'Draft' }}
                                    </span>
                                    @if($service->featured)
                                        <span class="badge bg-warning text-dark" style="font-size: 11.5px; padding: 5px 10px;">
                                            Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Short Description --}}
                        @if($service->short_description)
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Service Overview
                                </h6>
                                <p class="text-dark mb-0 p-3 rounded"
                                    style="background-color: #f8fafc; border: 1px solid #e2e8f0; font-size: 13.5px; line-height: 1.7;">
                                    {{ $service->short_description }}
                                </p>
                            </div>
                        @endif

                        {{-- Full Description / Scope --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2"
                                style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                Full Capabilities &amp; Scope of Work
                            </h6>
                            <div class="service-desc-box">
                                {!! $service->description ?: '<em class="text-muted">No full description provided.</em>' !!}
                            </div>
                        </div>

                        {{-- Service Gallery --}}
                        @if($service->getMedia('gallery')->isNotEmpty())
                            <div class="mb-2">
                                <h6 class="fw-bold text-dark mb-2"
                                    style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Service Gallery Photos ({{ $service->getMedia('gallery')->count() }} Photos)
                                </h6>
                                <div class="row g-2">
                                    @foreach($service->getMedia('gallery') as $media)
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
                    </div>
                </div>

                {{-- SEO Information Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title">Search Engine Optimization (SEO)</div>
                    </div>
                    <div class="card-body custom-form p-3">
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="service-meta-box">
                                    <div class="service-meta-label">Meta Title</div>
                                    <div class="service-meta-value">{{ $service->meta_title ?: '—' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="service-meta-box">
                                    <div class="service-meta-label">Meta Description</div>
                                    <div class="service-meta-value text-muted" style="font-weight: 400;">
                                        {{ $service->meta_description ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Parameters Column --}}
            <div class="col-lg-4 col-12">
                <div class="row g-4">
                    {{-- Status & Visibility Specifications --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Service Parameters</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-3">
                                    <div class="service-meta-box">
                                        <div class="service-meta-label">Icon Class</div>
                                        <div class="service-meta-value d-flex align-items-center gap-2">
                                            <i class="{{ $service->icon ?: 'ri-hammer-line' }} text-primary"
                                                style="font-size: 18px;"></i>
                                            <code>{{ $service->icon ?: 'ri-hammer-line' }}</code>
                                        </div>
                                    </div>

                                    <div class="service-meta-box">
                                        <div class="service-meta-label">URL Slug</div>
                                        <div class="service-meta-value font-monospace" style="font-size: 12px;">
                                            {{ $service->slug }}</div>
                                    </div>

                                    <div class="service-meta-box">
                                        <div class="service-meta-label">Display Priority Order</div>
                                        <div class="service-meta-value">{{ $service->sort_order }}</div>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-2 rounded"
                                        style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <span class="fw-semibold text-dark" style="font-size: 13px;">Website
                                            Visibility:</span>
                                        <span class="badge {{ $service->is_published ? 'bg-success' : 'bg-secondary' }}"
                                            style="font-size: 11px;">
                                            {{ $service->is_published ? 'Published' : 'Draft' }}
                                        </span>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center p-2 rounded"
                                        style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                        <span class="fw-semibold text-dark" style="font-size: 13px;">Homepage
                                            Featured:</span>
                                        <span
                                            class="badge {{ $service->featured ? 'bg-warning text-dark' : 'bg-light text-muted border' }}"
                                            style="font-size: 11px;">
                                            {{ $service->featured ? 'Featured' : 'Standard' }}
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
                                    @can('service-edit')
                                        <a href="{{ route('services.edit', $service->id) }}"
                                            class="btn submit-button w-100 d-flex align-items-center justify-content-center gap-1">
                                            <i class="ri-edit-line"></i> Edit Service
                                        </a>
                                    @endcan
                                    @can('service-delete')
                                        <button type="button" class="btn btn-outline-danger w-100 btn-delete-modal"
                                            data-title="{{ $service->title }}"
                                            data-url="{{ route('services.destroy', $service->id) }}"
                                            style="height: 36px; font-size: 13px; font-weight: 600;">
                                            <i class="ri-delete-bin-line me-1"></i> Delete Service
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
    <div class="modal fade" id="deleteServiceModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                            Confirm Service Deletion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p class="mb-2" style="font-size: 14px; color: #334155;">
                        Are you sure you want to permanently delete service <strong id="deleteServiceTitle"
                            class="text-dark"></strong>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">
                        This action will remove all service gallery media and assets associated with this record.
                    </p>
                </div>
                <div class="modal-footer"
                    style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                        style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                    <form id="deleteServiceForm" method="POST" action="">
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

                $('#deleteServiceTitle').text(title);
                $('#deleteServiceForm').attr('action', url);
                $('#deleteServiceModal').modal('show');
            });
        });
    </script>
@endpush