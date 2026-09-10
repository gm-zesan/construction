@extends('admin.app')
@section('title')
    Themes
@endsection

@push('custom-style')
    <style>
        .stat-badge-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 12px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .stat-badge-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .theme-card-box {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            height: 100%;
            transition: all 0.2s ease;
        }

        .theme-card-box:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            border-color: #cbd5e1;
        }

        .theme-card-box.is-active-theme {
            border: 2px solid #10b981;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.15);
        }

        .theme-card-thumb-wrap {
            position: relative;
            width: 100%;
            height: 180px;
            background-color: #0f172a;
            overflow: hidden;
            border-bottom: 1px solid #e2e8f0;
        }

        .theme-card-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: top;
            transition: transform 0.3s ease;
        }

        .theme-card-box:hover .theme-card-thumb {
            transform: scale(1.03);
        }

        .theme-badge-active {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #10b981;
            color: #ffffff;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.04em;
            padding: 3px 10px;
            border-radius: 4px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
            z-index: 2;
        }

        .theme-badge-version {
            position: absolute;
            bottom: 10px;
            left: 10px;
            background: rgba(15, 23, 42, 0.85);
            color: #f8fafc;
            font-size: 10.5px;
            font-family: monospace;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            z-index: 2;
        }

        .btn-activate-theme {
            border: 1px solid #f95716;
            color: #f95716;
            background-color: transparent;
            font-size: 13px;
            font-weight: 600;
            border-radius: 6px;
            height: 36px;
            transition: all 0.2s ease;
        }

        .btn-activate-theme:hover {
            background-color: #f95716;
            color: #ffffff;
            border-color: #f95716;
        }

        .dropzone-box {
            border: 2px dashed #cbd5e1;
            border-radius: 8px;
            background-color: #f8fafc;
            padding: 20px 16px;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
        }

        .dropzone-box:hover {
            border-color: #f95716;
            background-color: #fff7ed;
        }

        .dropzone-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background-color: rgba(249, 87, 22, 0.1);
            color: #f95716;
            font-size: 22px;
            margin: 0 auto 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            <div class="col-12">
                {{-- Header Table Card --}}
                <div class="card table-card mb-3">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Website Themes</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="{{ route('dashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active" aria-current="page">Themes</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <form action="{{ route('themes.scan') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                                    style="height: 38px; font-weight: 600; font-size: 13px; border-radius: 6px;">
                                    <i class="ri-refresh-line"></i> Scan Folders
                                </button>
                            </form>
                            <a href="{{ route('home') }}" target="_blank"
                                class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1"
                                style="height: 38px; font-weight: 600; font-size: 13px; border-radius: 6px;">
                                <i class="ri-external-link-line"></i> Live Site
                            </a>
                            @canany(['theme-create', 'role:superadmin'])
                                <button type="button" class="add-new border-0" data-bs-toggle="modal"
                                    data-bs-target="#createThemeModal">
                                    Register Theme <i class="ms-1 ri-add-line"></i>
                                </button>
                            @endcanany
                        </div>
                    </div>
                </div>

                {{-- Quick Metrics Row --}}
                <div class="row g-3 mb-3">
                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #ecfdf5; color: #059669;">
                                <i class="ri-checkbox-circle-fill"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Active Live Theme</div>
                                <div class="fw-bold text-dark text-truncate" style="font-size: 16px;" title="{{ $activeTheme->name ?? 'Default' }}">
                                    {{ $activeTheme->name ?? 'Default' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #fff7ed; color: #ea580c;">
                                <i class="ri-palette-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Installed Themes</div>
                                <div class="fw-bold text-dark" style="font-size: 18px;">{{ $themes->count() }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #eff6ff; color: #2563eb;">
                                <i class="ri-folder-2-line"></i>
                            </div>
                            <div class="overflow-hidden">
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Active Views Path</div>
                                <div class="fw-bold text-dark font-monospace text-truncate" style="font-size: 13px;" title="resources/views/themes/{{ $activeTheme->directory ?? 'default' }}">
                                    themes/{{ $activeTheme->directory ?? 'default' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-3 col-sm-6">
                        <div class="stat-badge-card">
                            <div class="stat-badge-icon" style="background-color: #faf5ff; color: #9333ea;">
                                <i class="ri-shield-check-line"></i>
                            </div>
                            <div>
                                <div class="text-muted" style="font-size: 12px; font-weight: 600;">Engine Status</div>
                                <div class="fw-bold text-success" style="font-size: 15px;">
                                    <span class="d-inline-block rounded-circle bg-success me-1" style="width: 8px; height: 8px;"></span> Live &amp; Cached
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Themes Card Grid Container --}}
                <div class="card table-card">
                    <div class="card-header border-bottom py-3 px-4" style="background-color: #f8fafc;">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-dark" style="font-size: 14px;">
                                <i class="ri-layout-grid-line me-1" style="color: #f95716;"></i> Available Frontend Templates
                            </div>
                            <span class="badge bg-light text-dark border" style="font-size: 12px;">
                                {{ $themes->count() }} Themes Registered
                            </span>
                        </div>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-4">
                            @foreach($themes as $theme)
                                <div class="col-md-6 col-xl-4">
                                    <div class="theme-card-box {{ $theme->is_active ? 'is-active-theme' : '' }}">
                                        {{-- Thumbnail --}}
                                        <div class="theme-card-thumb-wrap">
                                            <img src="{{ $theme->preview_image_url }}" alt="{{ $theme->name }}" class="theme-card-thumb" onerror="this.src='{{ asset('images/theme-placeholder.jpg') }}'">

                                            @if($theme->is_active)
                                                <div class="theme-badge-active">
                                                    <i class="ri-checkbox-circle-fill"></i> ACTIVE
                                                </div>
                                            @endif

                                            <div class="theme-badge-version">
                                                v{{ $theme->version }}
                                            </div>
                                        </div>

                                        {{-- Details --}}
                                        <div class="p-3 d-flex flex-column flex-grow-1 justify-content-between">
                                            <div>
                                                <div class="d-flex justify-content-between align-items-start mb-1">
                                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 14.5px;">{{ $theme->name }}</h6>
                                                    <span class="badge font-monospace" style="background-color: #f1f5f9; color: #475569; font-size: 10.5px;">
                                                        {{ $theme->directory }}
                                                    </span>
                                                </div>

                                                <p class="text-muted mb-3" style="font-size: 12px; line-height: 1.45; min-height: 35px;">
                                                    {{ Str::limit($theme->description ?? 'Custom responsive theme for engineering and construction websites.', 95) }}
                                                </p>

                                                <div class="d-flex justify-content-between align-items-center py-2 px-2 rounded mb-3" style="background-color: #f8fafc; font-size: 11.5px; border: 1px solid #edf2f7;">
                                                    <span class="text-muted">
                                                        <i class="ri-user-3-line me-1"></i> {{ $theme->author ?? 'In-House' }}
                                                    </span>
                                                    <span class="text-muted font-monospace">
                                                        <i class="ri-folder-2-line me-1"></i> /{{ $theme->directory }}
                                                    </span>
                                                </div>
                                            </div>

                                            {{-- Actions --}}
                                            <div class="d-flex align-items-center gap-2 pt-2 border-top">
                                                @if($theme->is_active)
                                                    <button type="button" class="btn btn-sm btn-success w-100 fw-semibold d-flex align-items-center justify-content-center gap-1 disabled" style="height: 36px; opacity: 0.95; border-radius: 6px;">
                                                        <i class="ri-check-line"></i> Currently Active
                                                    </button>
                                                @else
                                                    <form action="{{ route('themes.activate', $theme->id) }}" method="POST" class="w-100 mb-0">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-activate-theme w-100 d-flex align-items-center justify-content-center gap-1">
                                                            <i class="ri-toggle-line"></i> Activate Theme
                                                        </button>
                                                    </form>
                                                @endif

                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light border px-2 d-flex align-items-center justify-content-center" style="height: 36px; width: 36px; border-radius: 6px;" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border" style="font-size: 12.5px;">
                                                        <li>
                                                            <a class="dropdown-item py-1.5" href="#" data-bs-toggle="modal" data-bs-target="#editThemeModal{{ $theme->id }}">
                                                                <i class="ri-edit-line me-2 text-primary"></i> Edit Metadata
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-1.5" href="{{ route('home') }}" target="_blank">
                                                                <i class="ri-external-link-line me-2 text-success"></i> Preview Frontend
                                                            </a>
                                                        </li>
                                                        @if(!$theme->is_active && $theme->directory !== 'default')
                                                            <li><hr class="dropdown-divider my-1"></li>
                                                            <li>
                                                                <form action="{{ route('themes.destroy', $theme->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove theme \'{{ $theme->name }}\'?');">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item py-1.5 text-danger">
                                                                        <i class="ri-delete-bin-line me-2"></i> Delete Theme
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Edit Theme Modal --}}
                                <div class="modal fade" id="editThemeModal{{ $theme->id }}" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content border-0 shadow" style="border-radius: 8px;">
                                            <form action="{{ route('themes.update', $theme->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header border-bottom py-3 px-4" style="background-color: #f8fafc;">
                                                    <h6 class="modal-title fw-bold text-dark">
                                                        <i class="ri-edit-line me-1" style="color: #f95716;"></i> Edit Theme: {{ $theme->name }}
                                                    </h6>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-dark">Theme Display Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="name" class="form-control custom-input" value="{{ $theme->name }}" required>
                                                    </div>
                                                    <div class="row g-2 mb-3">
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold text-dark">Author / Studio</label>
                                                            <input type="text" name="author" class="form-control custom-input" value="{{ $theme->author }}">
                                                        </div>
                                                        <div class="col-6">
                                                            <label class="form-label small fw-semibold text-dark">Version</label>
                                                            <input type="text" name="version" class="form-control custom-input" value="{{ $theme->version }}">
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label small fw-semibold text-dark">Description</label>
                                                        <textarea name="description" class="form-control custom-input" rows="3">{{ $theme->description }}</textarea>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label small fw-semibold text-dark">Update Preview Screenshot</label>
                                                        <input type="file" name="preview_image" class="form-control custom-input" accept="image/*">
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-top py-2 px-4" style="background-color: #f8fafc;">
                                                    <button type="button" class="btn leave-button" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn submit-button">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Register New Theme Modal --}}
    <div class="modal fade" id="createThemeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow" style="border-radius: 8px;">
                <form action="{{ route('themes.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header border-bottom py-3 px-4" style="background-color: #f8fafc;">
                        <h6 class="modal-title fw-bold text-dark">
                            <i class="ri-add-circle-line me-1" style="color: #f95716;"></i> Register New Theme
                        </h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Theme Display Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control custom-input" placeholder="e.g. Modern Glass Minimal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Views Directory Name <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text font-monospace small bg-light" style="font-size: 11px;">resources/views/themes/</span>
                                <input type="text" name="directory" class="form-control custom-input font-monospace" placeholder="e.g. modern-glass" required pattern="[a-zA-Z0-9\-_]+">
                            </div>
                            <div class="form-text small" style="font-size: 11px;">Use lowercase letters, numbers, and dashes. The directory structure will be created automatically.</div>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-dark">Author / Designer</label>
                                <input type="text" name="author" class="form-control custom-input" placeholder="e.g. In-House Studio">
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-semibold text-dark">Version</label>
                                <input type="text" name="version" class="form-control custom-input" value="1.0.0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-dark">Description</label>
                            <textarea name="description" class="form-control custom-input" rows="2" placeholder="Brief description of the theme's aesthetic and layout..."></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-dark">Preview Screenshot</label>
                            <input type="file" name="preview_image" class="form-control custom-input" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer border-top py-2 px-4" style="background-color: #f8fafc;">
                        <button type="button" class="btn leave-button" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn submit-button">Register Theme</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
