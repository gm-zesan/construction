@extends('admin.app')

@php
    $canCreate = auth()->user() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('website-content-create'));
    $canDelete = auth()->user() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('website-content-delete'));
    $canEdit = auth()->user() && (auth()->user()->hasRole('superadmin') || auth()->user()->can('website-content-edit'));
    $currentPageMeta = $availablePages[$activePage] ?? [
        'title' => ucwords(str_replace(['_', '-'], ' ', $activePage)) . ' Content',
        'badge' => ucwords(str_replace(['_', '-'], ' ', $activePage)),
        'sections_title' => ucwords(str_replace(['_', '-'], ' ', $activePage)) . ' Sections',
    ];
    $firstSectionKey = array_key_first($sectionsMeta);
@endphp

@section('title')
    {{ $currentPageMeta['title'] }} - Content Management
@endsection

@push('custom-style')
    <style>
        .cms-nav-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 14px;
            border-radius: 6px;
            color: #334155;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.15s ease;
            cursor: pointer;
            margin-bottom: 3px;
            border: 1px solid transparent;
        }

        .cms-nav-item:hover {
            background-color: #f1f5f9;
            color: #0f172a;
        }

        .cms-nav-item.active {
            background-color: #fff7ed;
            color: #f95716;
            border-color: #ffedd5;
            font-weight: 600;
        }

        .cms-nav-item.active i {
            color: #f95716 !important;
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

        .dropzone-box:hover,
        .dropzone-box.dragover {
            border-color: #f95716;
            background-color: #fff7ed;
        }

        .cms-pane {
            display: none;
        }

        .cms-pane.active {
            display: block;
            animation: fadeIn 0.2s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(4px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .settings-section-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            margin-bottom: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.03);
        }

        .settings-section-header {
            padding: 14px 20px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .settings-section-body {
            padding: 20px;
        }

        .delete-field-btn {
            color: #94a3b8;
            font-size: 15px;
            transition: color 0.15s ease;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
            margin-left: 6px;
        }

        .delete-field-btn:hover {
            color: #ef4444;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row g-3">

            {{-- Left Column: Dynamic Page Section Tabs Sidebar --}}
            <div class="col-lg-3 col-md-4 col-12">
                <div class="card table-card sticky-top" style="top: 75px; z-index: 10;">
                    <div class="card-header table-header d-flex justify-content-between align-items-center">
                        <div class="table-title">{{ $currentPageMeta['sections_title'] }}</div>
                        <span class="badge bg-light text-dark border" style="font-size: 11px;">{{ $currentPageMeta['badge'] }}</span>
                    </div>
                    <div class="card-body p-2">
                        @forelse($sectionsMeta as $secKey => $secMeta)
                            <a class="cms-nav-item {{ $loop->first ? 'active' : '' }}" data-target="{{ $secKey }}" data-title="{{ $secMeta['title'] }}">
                                <span><i class="{{ $secMeta['icon'] }} me-2 text-muted"></i>{{ $secMeta['title'] }}</span>
                                <i class="ri-arrow-right-s-line text-muted"></i>
                            </a>
                        @empty
                            <div class="text-muted p-3 text-center" style="font-size: 13px;">No sections found.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Right Column: Dynamic Section Content Panes --}}
            <div class="col-lg-9 col-md-8 col-12">
                <div class="card table-card mb-4">
                    <div class="card-header table-header d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div class="title-with-breadcrumb">
                            <div class="table-title" id="activeSectionHeaderTitle">
                                {{ $firstSectionKey ? $sectionsMeta[$firstSectionKey]['title'] : 'Content Management' }}
                            </div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item">Content Management</li>
                                    <li class="breadcrumb-item" id="breadcrumbPageLabel">{{ $currentPageMeta['badge'] }}</li>
                                    <li class="breadcrumb-item active" id="breadcrumbSectionLabel" aria-current="page">
                                        {{ $firstSectionKey ? $sectionsMeta[$firstSectionKey]['title'] : '' }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($canCreate)
                                <button type="button" class="add-new" data-bs-toggle="modal" data-bs-target="#createCmsFieldModal">
                                    <i class="ri-add-line me-1"></i> Add Page / Field
                                </button>
                            @endif
                            <a href="{{ route('home') }}" target="_blank" class="add-new" style="background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;">
                                <i class="ri-external-link-line me-1"></i> View Live Site
                            </a>
                        </div>
                    </div>

                    <div class="card-body custom-form">
                        <form id="cmsContentForm" action="{{ route('content-management.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="active_page" value="{{ $activePage }}">

                            {{-- Dynamically Rendered Section Panes directly from Database --}}
                            @forelse($sectionsMeta as $secKey => $secMeta)
                                <div class="cms-pane {{ $loop->first ? 'active' : '' }}" id="pane-{{ $secKey }}">
                                    <div class="settings-section-card">
                                        <div class="settings-section-header">
                                            <div>
                                                <i class="{{ $secMeta['icon'] }} text-primary me-1" style="font-size: 18px;"></i> {{ $secMeta['title'] }}
                                            </div>
                                            <span class="text-muted" style="font-size: 11.5px; font-weight: 500;">
                                                Section: <code>{{ $secKey }}</code>
                                            </span>
                                        </div>
                                        <div class="settings-section-body">
                                            @php
                                                $sectionRecords = $contentRecords[$secKey] ?? [];
                                            @endphp

                                            @if(empty($sectionRecords))
                                                <div class="text-center py-4 text-muted">
                                                    <i class="ri-inbox-line" style="font-size: 32px;"></i>
                                                    <p class="mt-2 mb-0" style="font-size: 13px;">No configurable fields found for this section.</p>
                                                </div>
                                            @else
                                                <div class="row g-3">
                                                    @foreach($sectionRecords as $fieldKey => $record)
                                                        @php
                                                            $fieldVal = old("content.{$secKey}.{$fieldKey}", $record->value);
                                                            $fieldLabel = $record->label ?: ucwords(str_replace('_', ' ', $fieldKey));
                                                            $isLongText = in_array($record->type, ['textarea', 'richtext']) || strlen($fieldVal ?? '') > 80;
                                                            $colClass = $isLongText ? 'col-12' : 'col-md-6 col-12';
                                                        @endphp

                                                        <div class="{{ $colClass }}">
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <label class="form-label custom-label mb-0">{{ $fieldLabel }}</label>
                                                                @if($canDelete)
                                                                    <button type="button" class="delete-field-btn" title="Delete this field"
                                                                        onclick="confirmDeleteField({{ $record->id }}, '{{ addslashes($fieldLabel) }}')">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            @if($record->type === 'textarea' || $isLongText)
                                                                <textarea name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input"
                                                                    rows="3"
                                                                    placeholder="Enter {{ strtolower($fieldLabel) }}...">{{ $fieldVal }}</textarea>
                                                            @elseif($record->type === 'url')
                                                                <input type="text"
                                                                    name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input"
                                                                    value="{{ $fieldVal }}"
                                                                    placeholder="e.g. https://... or #section">
                                                            @elseif($record->type === 'number')
                                                                <input type="number"
                                                                    name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input"
                                                                    value="{{ $fieldVal }}">
                                                            @elseif($record->type === 'image')
                                                                <div class="dropzone-box" id="dropzone_{{ $secKey }}_{{ $fieldKey }}">
                                                                    <input type="file"
                                                                        name="media_files[{{ $secKey }}][{{ $fieldKey }}]"
                                                                        id="file_{{ $secKey }}_{{ $fieldKey }}"
                                                                        class="d-none"
                                                                        accept="image/*">
                                                                    <div class="dropzone-content">
                                                                        <i class="ri-image-add-line text-primary" style="font-size: 24px;"></i>
                                                                        <p class="mb-0 mt-1" style="font-size: 12px; font-weight: 600;">Click or drag image here</p>
                                                                    </div>
                                                                    @if(!empty($record->image_url))
                                                                        <div class="mt-2">
                                                                            <img src="{{ $record->image_url }}" alt="{{ $fieldLabel }}" style="max-height: 80px; border-radius: 6px;" class="border">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <input type="text"
                                                                    name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input"
                                                                    value="{{ $fieldVal }}"
                                                                    placeholder="Enter {{ strtolower($fieldLabel) }}...">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <i class="ri-folder-info-line" style="font-size: 40px;"></i>
                                    <h6 class="mt-2">No sections available for {{ $currentPageMeta['badge'] }}</h6>
                                </div>
                            @endforelse

                            {{-- Action Buttons --}}
                            <div class="row mt-4 pt-3 border-top">
                                <div class="col-12 d-flex align-items-center">
                                    <button type="submit" class="btn submit-button me-2" style="width: auto; height: 38px; padding: 0 24px;">
                                        <i class="ri-check-line me-1"></i> Save {{ $currentPageMeta['badge'] }}
                                    </button>
                                    <a href="{{ route('dashboard') }}" class="btn leave-button" style="width: auto; height: 38px; padding: 0 20px;">
                                        <i class="ri-arrow-left-line me-1"></i> Dashboard
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Dynamic CMS Field / Page Creation Modal --}}
    @if($canCreate)
        <div class="modal fade" id="createCmsFieldModal" tabindex="-1" aria-labelledby="createCmsFieldModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                style="width: 32px; height: 32px; background-color: #f95716;">
                                <i class="ri-layout-masonry-line" style="font-size: 18px;"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0" id="createCmsFieldModalLabel"
                                    style="font-size: 15.5px;">
                                    Add Dynamic CMS Page / Field
                                </h5>
                                <span class="text-muted" style="font-size: 11.5px;">Add custom sections, pages, or content keys to the website CMS repository</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="{{ route('content-management.fields.store') }}" method="POST">
                            @csrf
                            <div class="row g-3 mb-3">
                                {{-- Target Page Selection --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Target Page <span class="text-danger">*</span></label>
                                    <select name="page" id="cms_page_select" class="form-select custom-input" style="height: 38px; font-size: 13px;" required>
                                        @foreach($availablePages as $pKey => $pMeta)
                                            <option value="{{ $pKey }}" {{ $activePage === $pKey ? 'selected' : '' }}>
                                                {{ $pMeta['title'] }} ({{ $pKey }})
                                            </option>
                                        @endforeach
                                        <option value="__new__">+ Create New Page...</option>
                                    </select>
                                </div>

                                {{-- Custom Page Name (if new page selected) --}}
                                <div class="col-md-6 d-none" id="custom_page_wrapper">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">New Page Name <span class="text-danger">*</span></label>
                                    <input type="text" id="custom_page_input" class="form-control custom-input" placeholder="e.g. Careers or FAQ" style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Target Section Selection --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Section <span class="text-danger">*</span></label>
                                    <select name="section" id="cms_section_select" class="form-select custom-input" style="height: 38px; font-size: 13px;" required>
                                        @foreach($sectionsMeta as $sKey => $sMeta)
                                            <option value="{{ $sKey }}">{{ $sMeta['title'] }} ({{ $sKey }})</option>
                                        @endforeach
                                        <option value="__new__">+ Create New Section...</option>
                                    </select>
                                </div>

                                {{-- Custom Section Name (if new section selected) --}}
                                <div class="col-md-6 d-none" id="custom_section_wrapper">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">New Section Name <span class="text-danger">*</span></label>
                                    <input type="text" id="custom_section_input" class="form-control custom-input" placeholder="e.g. Job Openings or Benefits" style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Label --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Label / Title <span class="text-danger">*</span></label>
                                    <input type="text" id="cms_field_label" name="label" class="form-control custom-input" placeholder="e.g. Application Deadline" required style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Key (auto-generated identifier) --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Key (Identifier) <span class="text-danger">*</span></label>
                                    <input type="text" id="cms_field_key" name="key" class="form-control custom-input" placeholder="e.g. application_deadline" required style="height: 38px; font-size: 13px;">
                                    <div class="text-muted mt-1" style="font-size: 11px;">Code accessor: <code>get_content('page', 'section', 'key')</code></div>
                                </div>

                                {{-- Field Input Type --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Type <span class="text-danger">*</span></label>
                                    <select id="cms_field_type" name="type" class="form-select custom-input" style="height: 38px; font-size: 13px;" required>
                                        <option value="text">Text (Single Line)</option>
                                        <option value="textarea">Textarea (Multi-line)</option>
                                        <option value="url">URL / Link</option>
                                        <option value="image">Image Upload</option>
                                        <option value="number">Numeric Value</option>
                                    </select>
                                </div>

                                {{-- Initial / Default Value --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Initial Default Value (Optional)</label>
                                    <input type="text" id="cms_field_value" name="value" class="form-control custom-input" placeholder="Optional initial value" style="height: 38px; font-size: 13px;">
                                </div>
                            </div>

                            {{-- Modal Action Buttons matching Media Upload modal theme --}}
                            <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                                <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal"
                                    style="height: 36px; font-weight: 600;">Cancel</button>
                                <button type="submit" class="btn btn-primary btn-sm px-4"
                                    style="height: 36px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                                    <i class="ri-check-line me-1"></i> Save Content Field
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        {{-- Hidden Delete Field Form --}}
        <form id="deleteCmsFieldForm" action="" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    @endif
@endsection

@push('custom-script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Dynamic Section Tab Switcher
            const navItems = document.querySelectorAll('.cms-nav-item');
            const panes = document.querySelectorAll('.cms-pane');
            const headerTitle = document.getElementById('activeSectionHeaderTitle');
            const breadcrumbSectionLabel = document.getElementById('breadcrumbSectionLabel');

            navItems.forEach(item => {
                item.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    const title = this.getAttribute('data-title');

                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');

                    panes.forEach(p => p.classList.remove('active'));
                    const targetPane = document.getElementById(`pane-${target}`);
                    if (targetPane) {
                        targetPane.classList.add('active');
                    }

                    if (headerTitle) headerTitle.textContent = title;
                    if (breadcrumbSectionLabel) breadcrumbSectionLabel.textContent = title;
                });
            });

            // Dynamic Image Dropzones
            document.querySelectorAll('.dropzone-box').forEach(box => {
                const input = box.querySelector('input[type="file"]');
                if (!input) return;

                box.addEventListener('click', () => input.click());

                box.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    box.classList.add('dragover');
                });

                box.addEventListener('dragleave', () => box.classList.remove('dragover'));

                box.addEventListener('drop', (e) => {
                    e.preventDefault();
                    box.classList.remove('dragover');
                    if (e.dataTransfer.files.length) {
                        input.files = e.dataTransfer.files;
                    }
                });
            });

            // Modal Dynamic Page & Section Creation Handlers
            const pageSelect = document.getElementById('cms_page_select');
            const customPageWrapper = document.getElementById('custom_page_wrapper');
            const customPageInput = document.getElementById('custom_page_input');

            const sectionSelect = document.getElementById('cms_section_select');
            const customSectionWrapper = document.getElementById('custom_section_wrapper');
            const customSectionInput = document.getElementById('custom_section_input');

            const fieldLabel = document.getElementById('cms_field_label');
            const fieldKey = document.getElementById('cms_field_key');

            if (pageSelect && customPageWrapper && customPageInput) {
                pageSelect.addEventListener('change', function () {
                    if (this.value === '__new__') {
                        customPageWrapper.classList.remove('d-none');
                        customPageInput.setAttribute('name', 'page');
                        customPageInput.required = true;
                        this.removeAttribute('name');
                    } else {
                        customPageWrapper.classList.add('d-none');
                        customPageInput.removeAttribute('name');
                        customPageInput.required = false;
                        this.setAttribute('name', 'page');
                    }
                });
            }

            if (sectionSelect && customSectionWrapper && customSectionInput) {
                sectionSelect.addEventListener('change', function () {
                    if (this.value === '__new__') {
                        customSectionWrapper.classList.remove('d-none');
                        customSectionInput.setAttribute('name', 'section');
                        customSectionInput.required = true;
                        this.removeAttribute('name');
                    } else {
                        customSectionWrapper.classList.add('d-none');
                        customSectionInput.removeAttribute('name');
                        customSectionInput.required = false;
                        this.setAttribute('name', 'section');
                    }
                });
            }

            // Auto-slugify label into key
            if (fieldLabel && fieldKey) {
                fieldLabel.addEventListener('input', function () {
                    const slug = this.value.toLowerCase().trim()
                        .replace(/[^\w\s-]/g, '')
                        .replace(/[\s_-]+/g, '_')
                        .replace(/^-+|-+$/g, '');
                    fieldKey.value = slug;
                });
            }
        });

        function confirmDeleteField(fieldId, label) {
            if (confirm(`Are you sure you want to delete the content field "${label}"?`)) {
                const form = document.getElementById('deleteCmsFieldForm');
                if (form) {
                    form.action = `/dashboard/content-management/fields/${fieldId}`;
                    form.submit();
                }
            }
        }
    </script>
@endpush