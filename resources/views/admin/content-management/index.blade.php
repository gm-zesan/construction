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
            padding: 16px;
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
            from {
                opacity: 0;
                transform: translateY(4px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .settings-section-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            margin-bottom: 20px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            overflow: hidden;
        }

        .settings-section-header {
            padding: 12px 18px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13.5px;
            font-weight: 700;
            color: #1e293b;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .settings-section-body {
            padding: 18px;
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

        .group-item-table th {
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            color: #64748b;
            background-color: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }

        .group-item-table td {
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .group-item-table tr:last-child td {
            border-bottom: none;
        }

        .action-btn .btn {
            width: 32px;
            height: 32px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 6px;
            font-size: 15px;
            border: none;
            transition: all 0.15s ease;
        }

        .btn-edit {
            background-color: #eff6ff;
            color: #3b82f6;
        }

        .btn-edit:hover {
            background-color: #dbeafe;
            color: #1d4ed8;
        }

        .btn-delete {
            background-color: #fef2f2;
            color: #ef4444;
        }

        .btn-delete:hover {
            background-color: #fee2e2;
            color: #b91c1c;
        }

        .btn-add-group-item {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 12px;
            font-weight: 600;
            height: 32px;
            padding: 0 14px;
            border-radius: 6px;
            color: #ea580c;
            background-color: #fff7ed;
            border: 1px solid #ffedd5;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            box-shadow: 0 1px 2px rgba(234, 88, 12, 0.05);
        }

        .btn-add-group-item i {
            font-size: 14px;
            transition: transform 0.2s ease;
        }

        .btn-add-group-item:hover {
            color: #ffffff;
            background: linear-gradient(135deg, #f95716 0%, #ea580c 100%);
            border-color: #f95716;
            box-shadow: 0 4px 10px rgba(249, 87, 22, 0.25);
            transform: translateY(-1px);
        }

        .btn-add-group-item:hover i {
            transform: rotate(90deg);
        }

        .btn-add-group-item:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(249, 87, 22, 0.2);
        }

        .btn-save-section {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            height: 38px;
            padding: 0 22px;
            border-radius: 7px;
            color: #ffffff;
            background: linear-gradient(135deg, #f95716 0%, #ea580c 100%);
            border: 1px solid #ea580c;
            box-shadow: 0 2px 6px rgba(249, 87, 22, 0.25);
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
        }

        .btn-save-section i {
            font-size: 15px;
            font-weight: bold;
        }

        .btn-save-section:hover {
            color: #ffffff;
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            border-color: #c2410c;
            box-shadow: 0 4px 14px rgba(249, 87, 22, 0.35);
            transform: translateY(-1px);
        }

        .btn-save-section:active {
            transform: translateY(0);
            box-shadow: 0 1px 3px rgba(249, 87, 22, 0.2);
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
                        <span class="badge bg-light text-dark border"
                            style="font-size: 11px;">{{ $currentPageMeta['badge'] }}</span>
                    </div>
                    <div class="card-body p-2">
                        @forelse($sectionsMeta as $secKey => $secMeta)
                            <a class="cms-nav-item {{ $loop->first ? 'active' : '' }}" data-target="{{ $secKey }}"
                                data-title="{{ $secMeta['title'] }}">
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
                                    <li class="breadcrumb-item" id="breadcrumbPageLabel">{{ $currentPageMeta['badge'] }}
                                    </li>
                                    <li class="breadcrumb-item active" id="breadcrumbSectionLabel" aria-current="page">
                                        {{ $firstSectionKey ? $sectionsMeta[$firstSectionKey]['title'] : '' }}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            {{-- Active Theme Indicator Badge --}}
                            <a href="{{ route('themes.index') }}" class="btn btn-sm btn-outline-secondary d-flex align-items-center gap-1 text-decoration-none"
                                style="height: 38px; font-weight: 600; font-size: 13px; border-radius: 6px; background-color: #ffffff;"
                                title="Manage Themes in Theme Settings">
                                <i class="ri-palette-line text-primary me-1" style="color: #f95716 !important;"></i>
                                Active Theme: <strong>{{ optional($availableThemes->firstWhere('directory', $currentTheme))->name ?? ucfirst($currentTheme) }}</strong>
                            </a>

                            @if($canCreate)
                                <button type="button" class="add-new" data-bs-toggle="modal"
                                    data-bs-target="#createCmsFieldModal">
                                    <i class="ri-add-line me-1"></i> Add Page / Field
                                </button>
                            @endif
                            <a href="{{ route('home') }}" target="_blank" class="add-new"
                                style="background-color: #ffffff; color: #475569; border: 1px solid #cbd5e1;">
                                <i class="ri-external-link-line me-1"></i> View Live Site
                            </a>
                        </div>
                    </div>

                    <div class="card-body p-3">
                        @forelse($sectionsMeta as $secKey => $secMeta)
                            @php
                                $secData = $sectionsData[$secKey] ?? ['standalone' => [], 'groups' => []];
                                $hasGroups = !empty($secData['groups']);
                                $hasStandalone = !empty($secData['standalone']);
                            @endphp

                            <div class="cms-pane {{ $loop->first ? 'active' : '' }}" id="pane-{{ $secKey }}">

                                {{-- 1. Repeating Item Groups (Lists) --}}
                                @if($hasGroups)
                                    @foreach($secData['groups'] as $gType => $gData)
                                        <div class="settings-section-card mb-4">
                                            <div class="settings-section-header">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="p-1 rounded d-inline-flex align-items-center justify-content-center text-white"
                                                        style="width: 24px; height: 24px; background-color: #f95716; font-size: 13px;">
                                                        <i class="ri-list-check-2"></i>
                                                    </span>
                                                    <span class="fw-bold text-dark">{{ $gData['group_title'] }}</span>
                                                    <span class="badge bg-light text-muted border" style="font-size: 11px;">
                                                        {{ count($gData['items']) }} {{ Str::plural('Item', count($gData['items'])) }}
                                                    </span>
                                                </div>

                                                @if($canCreate)
                                                    @php
                                                        // Get a sample template from first item to populate create modal
                                                        $firstItem = reset($gData['items']);
                                                        $templateKeys = [];
                                                        if ($firstItem && !empty($firstItem['records'])) {
                                                            foreach ($firstItem['records'] as $fr) {
                                                                $parsedKey = \App\Models\WebsiteContent::parseContentKey($fr->key);
                                                                $cleanSub = $parsedKey['field'] ?: '__self__';
                                                                $templateKeys[] = [
                                                                    'sub_key' => $cleanSub,
                                                                    'label' => $fr->label ?: ucwords(str_replace('_', ' ', $cleanSub !== '__self__' ? $cleanSub : $gType)),
                                                                    'type' => $fr->type,
                                                                ];
                                                            }
                                                        }
                                                    @endphp
                                                    <button type="button"
                                                        class="btn-add-group-item"
                                                        onclick="openAddGroupItemModal('{{ $activePage }}', '{{ $secKey }}', '{{ $gType }}', '{{ addslashes($gData['group_title']) }}', {{ json_encode($templateKeys) }})">
                                                        <i class="ri-add-line"></i> Add {{ Str::singular($gData['group_title']) }}
                                                    </button>
                                                @endif
                                            </div>

                                            <div class="p-0">
                                                <div class="table-responsive">
                                                    <table class="table group-item-table table-hover align-middle mb-0"
                                                        style="font-size: 13px;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 50px; padding: 11px 16px;">#</th>
                                                                <th style="width: 200px; padding: 11px 16px;">Item Name</th>
                                                                <th style="padding: 11px 16px;">Content Preview</th>
                                                                <th style="width: 100px; padding: 11px 16px;" class="text-center">Fields
                                                                </th>
                                                                <th style="width: 100px; padding: 11px 16px;" class="text-center">Action
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @forelse($gData['items'] as $gId => $item)
                                                                @php
                                                                    // JSON data payload for fast modal loading
                                                                    $itemJson = [
                                                                        'page' => $activePage,
                                                                        'section' => $secKey,
                                                                        'group_id' => $gId,
                                                                        'item_label' => $item['item_label'],
                                                                        'fields' => array_map(function ($r) {
                                                                            return [
                                                                                'id' => $r->id,
                                                                                'key' => $r->key,
                                                                                'label' => $r->label ?: ucwords(str_replace('_', ' ', $r->key)),
                                                                                'type' => $r->type,
                                                                                'value' => $r->value,
                                                                                'image_url' => $r->image_url,
                                                                            ];
                                                                        }, $item['records'])
                                                                    ];
                                                                @endphp
                                                                <tr id="row_{{ $secKey }}_{{ $gId }}">
                                                                    <td style="padding: 12px 16px;" class="text-muted fw-semibold">
                                                                        {{ $loop->iteration }}
                                                                    </td>
                                                                    <td style="padding: 12px 16px;">
                                                                        <div class="fw-bold text-dark" style="font-size: 13.5px;">
                                                                            {{ $item['item_label'] }}</div>
                                                                        <code class="text-muted" style="font-size: 11px;">{{ $gId }}</code>
                                                                    </td>
                                                                    <td style="padding: 12px 16px;">
                                                                        <div class="d-flex align-items-center flex-wrap gap-2 mb-1">
                                                                            @if(!empty($item['badge_preview']))
                                                                                <span class="badge"
                                                                                    style="background-color: #fff7ed; color: #f95716; border: 1px solid #ffedd5; font-size: 11px; font-weight: 600;">
                                                                                    {{ $item['badge_preview'] }}
                                                                                </span>
                                                                            @endif
                                                                            @if(!empty($item['title_preview']))
                                                                                <span class="fw-semibold text-dark" style="font-size: 13px;">
                                                                                    {{ Str::limit($item['title_preview'], 55) }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                        @if(!empty($item['desc_preview']))
                                                                            <div class="text-muted"
                                                                                style="font-size: 12px; line-height: 1.4; max-width: 520px;">
                                                                                {{ Str::limit($item['desc_preview'], 90) }}
                                                                            </div>
                                                                        @endif
                                                                        @if(!empty($item['tags_preview']))
                                                                            <div class="d-flex flex-wrap gap-1 mt-1">
                                                                                @foreach($item['tags_preview'] as $tag)
                                                                                    <span class="badge bg-light text-secondary border"
                                                                                        style="font-size: 10.5px;">{{ $tag }}</span>
                                                                                @endforeach
                                                                            </div>
                                                                        @endif
                                                                    </td>
                                                                    <td style="padding: 12px 16px;" class="text-center">
                                                                        <span class="badge bg-light text-dark border"
                                                                            style="font-size: 11px; font-weight: 500;">
                                                                            {{ count($item['records']) }}
                                                                            {{ Str::plural('field', count($item['records'])) }}
                                                                        </span>
                                                                    </td>
                                                                    <td style="padding: 12px 16px;" class="text-center">
                                                                        {{-- Embedded JSON payload for this item --}}
                                                                        <script type="application/json" id="json_{{ $secKey }}_{{ $gId }}">
                                                                                                {!! json_encode($itemJson) !!}
                                                                                            </script>

                                                                        <div
                                                                            class="action-btn d-flex align-items-center justify-content-center gap-1">
                                                                            @if($canEdit)
                                                                                <button type="button" class="btn btn-edit"
                                                                                    title="Edit {{ $item['item_label'] }}"
                                                                                    onclick="openEditGroupItemModal('{{ $secKey }}', '{{ $gId }}')">
                                                                                    <i class="ri-edit-line"></i>
                                                                                </button>
                                                                            @endif
                                                                            @if($canDelete)
                                                                                <button type="button" class="btn btn-delete"
                                                                                    title="Delete {{ $item['item_label'] }}"
                                                                                    onclick="confirmDeleteGroupItem('{{ $activePage }}', '{{ $secKey }}', '{{ $gId }}', '{{ addslashes($item['item_label']) }}')">
                                                                                    <i class="ri-delete-bin-2-line"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center py-4 text-muted">
                                                                        <i class="ri-inbox-line" style="font-size: 26px;"></i>
                                                                        <p class="mt-1 mb-0" style="font-size: 12px;">No items found in this
                                                                            collection.</p>
                                                                    </td>
                                                                </tr>
                                                            @endforelse
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                {{-- 2. Standalone / General Section Fields --}}
                                @if($hasStandalone)
                                    <form action="{{ route('content-management.update') }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="theme" value="{{ $currentTheme }}">
                                        <input type="hidden" name="active_page" value="{{ $activePage }}">

                                        <div class="settings-section-card">
                                            <div class="settings-section-header">
                                                <div>
                                                    <i class="{{ $secMeta['icon'] }} text-primary me-1"
                                                        style="font-size: 16px;"></i>
                                                    {{ $hasGroups ? 'General Section Information & Settings' : $secMeta['title'] }}
                                                </div>
                                                <span class="text-muted" style="font-size: 11.5px; font-weight: 500;">
                                                    Section: <code>{{ $secKey }}</code>
                                                </span>
                                            </div>
                                            <div class="settings-section-body">
                                                <div class="row g-3">
                                                    @foreach($secData['standalone'] as $fieldKey => $record)
                                                        @php
                                                            $fieldVal = old("content.{$secKey}.{$fieldKey}", $record->value);
                                                            $fieldLabel = $record->label ?: ucwords(str_replace('_', ' ', $fieldKey));
                                                            $isLongText = in_array($record->type, ['textarea', 'richtext']) || strlen($fieldVal ?? '') > 80;
                                                            $colClass = $isLongText ? 'col-12' : 'col-md-6 col-12';
                                                        @endphp

                                                        <div class="{{ $colClass }}">
                                                            <div class="d-flex align-items-center justify-content-between mb-1">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <label class="form-label custom-label mb-0">{{ $fieldLabel }}</label>
                                                                    @if($record->type === 'richtext')
                                                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle" style="font-size: 10px; font-weight: 700; padding: 2px 6px;">HTML / Rich</span>
                                                                    @endif
                                                                </div>
                                                                @if($canDelete)
                                                                    <button type="button" class="delete-field-btn" title="Delete this field"
                                                                        onclick="confirmDeleteField({{ $record->id }}, '{{ addslashes($fieldLabel) }}')">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </button>
                                                                @endif
                                                            </div>

                                                            @if($record->type === 'richtext')
                                                                <textarea name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input font-monospace" rows="3" style="font-size: 13px;"
                                                                    placeholder="Enter {{ strtolower($fieldLabel) }} (HTML allowed)...">{{ $fieldVal }}</textarea>
                                                            @elseif($record->type === 'textarea' || $isLongText)
                                                                <textarea name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input" rows="3"
                                                                    placeholder="Enter {{ strtolower($fieldLabel) }}...">{{ $fieldVal }}</textarea>
                                                            @elseif($record->type === 'url')
                                                                <input type="text" name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input" value="{{ $fieldVal }}"
                                                                    placeholder="e.g. https://... or #section">
                                                            @elseif($record->type === 'number')
                                                                <input type="number" name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input" value="{{ $fieldVal }}">
                                                            @elseif($record->type === 'image')
                                                                <div class="dropzone-box" id="dropzone_{{ $secKey }}_{{ $fieldKey }}">
                                                                    <input type="file" name="media_files[{{ $secKey }}][{{ $fieldKey }}]"
                                                                        id="file_{{ $secKey }}_{{ $fieldKey }}" class="d-none"
                                                                        accept="image/*">
                                                                    <div class="dropzone-content">
                                                                        <i class="ri-image-add-line text-primary"
                                                                            style="font-size: 24px;"></i>
                                                                        <p class="mb-0 mt-1" style="font-size: 12px; font-weight: 600;">
                                                                            Click or drag image here</p>
                                                                    </div>
                                                                    @if(!empty($record->image_url))
                                                                        <div class="mt-2">
                                                                            <img src="{{ $record->image_url }}" alt="{{ $fieldLabel }}"
                                                                                style="max-height: 80px; border-radius: 6px;" class="border">
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            @else
                                                                <input type="text" name="content[{{ $secKey }}][{{ $fieldKey }}]"
                                                                    class="form-control custom-input" value="{{ $fieldVal }}"
                                                                    placeholder="Enter {{ strtolower($fieldLabel) }}...">
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                                                    <button type="submit" class="btn-save-section">
                                                        <i class="ri-check-line"></i> Save
                                                        {{ $hasGroups ? 'Section Details' : $currentPageMeta['badge'] }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                @endif

                                {{-- Fallback if section is completely empty --}}
                                @if(!$hasGroups && !$hasStandalone)
                                    <div class="text-center py-5 text-muted">
                                        <i class="ri-inbox-line" style="font-size: 36px;"></i>
                                        <p class="mt-2 mb-0" style="font-size: 13px;">No configurable fields or items found for this
                                            section.</p>
                                    </div>
                                @endif

                            </div>
                        @empty
                            <div class="text-center py-5 text-muted">
                                <i class="ri-folder-info-line" style="font-size: 40px;"></i>
                                <h6 class="mt-2">No sections available for {{ $currentPageMeta['badge'] }}</h6>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Dedicated Edit Single Group Item Modal --}}
    @if($canEdit)
        <div class="modal fade" id="editGroupItemModal" tabindex="-1" aria-labelledby="editGroupItemModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                style="width: 34px; height: 34px; background-color: #f95716;">
                                <i class="ri-edit-line" style="font-size: 18px;"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0" id="editGroupItemModalLabel"
                                    style="font-size: 16px;">
                                    Edit Item
                                </h5>
                                <span class="text-muted" style="font-size: 11.5px;" id="editGroupItemSubtitle">
                                    Update only the fields of this specific item
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="editGroupItemForm" action="{{ route('content-management.item.update') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="theme" value="{{ $currentTheme }}">
                        <input type="hidden" name="page" id="edit_modal_page" value="{{ $activePage }}">
                        <input type="hidden" name="section" id="edit_modal_section" value="">
                        <input type="hidden" name="group_id" id="edit_modal_group_id" value="">
                        <input type="hidden" name="item_label" id="edit_modal_item_label" value="">

                        <div class="modal-body p-4">
                            <div class="row g-3" id="edit_modal_fields_container">
                                {{-- Dynamically populated via JavaScript --}}
                            </div>
                        </div>

                        <div class="modal-footer bg-light" style="border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal"
                                style="height: 36px; font-weight: 600;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm px-4"
                                style="height: 36px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                                <i class="ri-check-line me-1"></i> Update Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- 4. Delete Single Group Item Confirmation Modal --}}
    @if($canDelete)
        <div class="modal fade" id="deleteGroupItemModal" tabindex="-1" aria-labelledby="deleteGroupItemModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-danger-subtle border-0">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-danger bg-white shadow-sm flex-shrink-0"
                                style="width: 36px; height: 36px;">
                                <i class="ri-delete-bin-line" style="font-size: 20px;"></i>
                            </div>
                            <h5 class="modal-title fw-bold text-danger mb-0" id="deleteGroupItemModalLabel"
                                style="font-size: 16px;">
                                Delete Item
                            </h5>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="deleteGroupItemForm" action="{{ route('content-management.item.destroy') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="theme" value="{{ $currentTheme }}">
                        <input type="hidden" name="page" id="delete_modal_page" value="{{ $activePage }}">
                        <input type="hidden" name="section" id="delete_modal_section" value="">
                        <input type="hidden" name="group_id" id="delete_modal_group_id" value="">
                        <input type="hidden" name="item_label" id="delete_modal_item_label" value="">

                        <div class="modal-body p-4 text-center">
                            <p class="mb-2 text-dark" style="font-size: 14.5px;">
                                Are you sure you want to delete <strong id="delete_modal_item_name" class="text-danger">this
                                    item</strong>?
                            </p>
                            <p class="text-muted small mb-0">
                                All fields associated with this item will be permanently removed from the website content
                                repository.
                            </p>
                        </div>

                        <div class="modal-footer bg-light border-0 justify-content-center pb-4">
                            <button type="button" class="btn btn-secondary btn-sm px-4" data-bs-dismiss="modal"
                                style="height: 36px; font-weight: 600;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-danger btn-sm px-4" style="height: 36px; font-weight: 600;">
                                <i class="ri-delete-bin-line me-1"></i> Yes, Delete Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- 5. Add New Group Item Modal --}}
    @if($canCreate)
        <div class="modal fade" id="addGroupItemModal" tabindex="-1" aria-labelledby="addGroupItemModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header" style="background-color: #f8fafc; border-bottom: 1px solid #e2e8f0;">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white flex-shrink-0"
                                style="width: 34px; height: 34px; background-color: #f95716;">
                                <i class="ri-add-line" style="font-size: 18px;"></i>
                            </div>
                            <div>
                                <h5 class="modal-title fw-bold text-dark mb-0" id="addGroupItemModalLabel"
                                    style="font-size: 16px;">
                                    Add New Item
                                </h5>
                                <span class="text-muted" style="font-size: 11.5px;" id="addGroupItemSubtitle">
                                    Create a new item in this collection
                                </span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <form id="addGroupItemForm" action="{{ route('content-management.item.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="theme" value="{{ $currentTheme }}">
                        <input type="hidden" name="page" id="add_modal_page" value="{{ $activePage }}">
                        <input type="hidden" name="section" id="add_modal_section" value="">
                        <input type="hidden" name="group_type" id="add_modal_group_type" value="">

                        <div class="modal-body p-4">
                            <div class="row g-3" id="add_modal_fields_container">
                                {{-- Dynamically populated via JavaScript --}}
                            </div>
                        </div>

                        <div class="modal-footer bg-light" style="border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                            <button type="button" class="btn btn-secondary btn-sm px-3" data-bs-dismiss="modal"
                                style="height: 36px; font-weight: 600;">
                                Cancel
                            </button>
                            <button type="submit" class="btn btn-primary btn-sm px-4"
                                style="height: 36px; font-weight: 600; background-color: #f95716; border-color: #f95716;">
                                <i class="ri-check-line me-1"></i> Save New Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- 6. Dynamic CMS Field / Page Creation Modal --}}
    @if($canCreate)
        <div class="modal fade" id="createCmsFieldModal" tabindex="-1" aria-labelledby="createCmsFieldModalLabel"
            aria-hidden="true">
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
                                <span class="text-muted" style="font-size: 11.5px;">Add custom sections, pages, or content keys
                                    to the website CMS repository</span>
                            </div>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body p-4">
                        <form action="{{ route('content-management.fields.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="theme" value="{{ $currentTheme }}">
                            <div class="row g-3 mb-3">
                                {{-- Target Page Selection --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Target Page
                                        <span class="text-danger">*</span></label>
                                    <select name="page" id="cms_page_select" class="form-select custom-input"
                                        style="height: 38px; font-size: 13px;" required>
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
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">New Page Name
                                        <span class="text-danger">*</span></label>
                                    <input type="text" id="custom_page_input" class="form-control custom-input"
                                        placeholder="e.g. Careers or FAQ" style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Target Section Selection --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Section <span
                                            class="text-danger">*</span></label>
                                    <select name="section" id="cms_section_select" class="form-select custom-input"
                                        style="height: 38px; font-size: 13px;" required>
                                        @foreach($sectionsMeta as $sKey => $sMeta)
                                            <option value="{{ $sKey }}">{{ $sMeta['title'] }} ({{ $sKey }})</option>
                                        @endforeach
                                        <option value="__new__">+ Create New Section...</option>
                                    </select>
                                </div>

                                {{-- Custom Section Name (if new section selected) --}}
                                <div class="col-md-6 d-none" id="custom_section_wrapper">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">New Section
                                        Name <span class="text-danger">*</span></label>
                                    <input type="text" id="custom_section_input" class="form-control custom-input"
                                        placeholder="e.g. Job Openings or Benefits" style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Label --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Label /
                                        Title <span class="text-danger">*</span></label>
                                    <input type="text" id="cms_field_label" name="label" class="form-control custom-input"
                                        placeholder="e.g. Application Deadline" required style="height: 38px; font-size: 13px;">
                                </div>

                                {{-- Field Key (auto-generated identifier) --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Key
                                        (Identifier) <span class="text-danger">*</span></label>
                                    <input type="text" id="cms_field_key" name="key" class="form-control custom-input"
                                        placeholder="e.g. application_deadline" required style="height: 38px; font-size: 13px;">
                                    <div class="text-muted mt-1" style="font-size: 11px;">Code accessor:
                                        <code>get_content('page', 'section', 'key')</code></div>
                                </div>

                                {{-- Field Input Type --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Field Type
                                        <span class="text-danger">*</span></label>
                                    <select id="cms_field_type" name="type" class="form-select custom-input"
                                        style="height: 38px; font-size: 13px;" required>
                                        <option value="text">Text (Single Line)</option>
                                        <option value="textarea">Textarea (Multi-line Plain)</option>
                                        <option value="richtext">Rich Text / HTML / Headings</option>
                                        <option value="url">URL / Link</option>
                                        <option value="image">Image Upload</option>
                                        <option value="number">Numeric Value</option>
                                    </select>
                                </div>

                                {{-- Initial / Default Value --}}
                                <div class="col-md-6">
                                    <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Initial
                                        Default Value (Optional)</label>
                                    <input type="text" id="cms_field_value" name="value" class="form-control custom-input"
                                        placeholder="Optional initial value" style="height: 38px; font-size: 13px;">
                                </div>
                            </div>

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
            // Dynamic Section Tab Switcher with URL hash persistence
            const navItems = document.querySelectorAll('.cms-nav-item');
            const panes = document.querySelectorAll('.cms-pane');
            const headerTitle = document.getElementById('activeSectionHeaderTitle');
            const breadcrumbSectionLabel = document.getElementById('breadcrumbSectionLabel');

            function switchSection(targetKey) {
                const targetBtn = Array.from(navItems).find(i => i.getAttribute('data-target') === targetKey);
                if (!targetBtn) return;

                const title = targetBtn.getAttribute('data-title');
                navItems.forEach(i => i.classList.remove('active'));
                targetBtn.classList.add('active');

                panes.forEach(p => p.classList.remove('active'));
                const targetPane = document.getElementById(`pane-${targetKey}`);
                if (targetPane) {
                    targetPane.classList.add('active');
                }

                if (headerTitle) headerTitle.textContent = title;
                if (breadcrumbSectionLabel) breadcrumbSectionLabel.textContent = title;

                // Update URL hash without jumping
                if (history.replaceState) {
                    history.replaceState(null, null, `#sec-${targetKey}`);
                }
            }

            navItems.forEach(item => {
                item.addEventListener('click', function () {
                    const target = this.getAttribute('data-target');
                    switchSection(target);
                });
            });

            // Check URL hash on page load
            const currentHash = window.location.hash;
            if (currentHash && currentHash.startsWith('#sec-')) {
                const secFromHash = currentHash.replace('#sec-', '');
                switchSection(secFromHash);
            }

            // Dynamic Image Dropzones
            setupDropzones();

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

        function setupDropzones() {
            document.querySelectorAll('.dropzone-box').forEach(box => {
                const input = box.querySelector('input[type="file"]');
                if (!input) return;

                box.onclick = (e) => {
                    if (e.target.tagName !== 'INPUT' && e.target.tagName !== 'BUTTON' && !e.target.closest('.remove-media-check')) {
                        input.click();
                    }
                };

                box.ondragover = (e) => {
                    e.preventDefault();
                    box.classList.add('dragover');
                };

                box.ondragleave = () => box.classList.remove('dragover');

                box.ondrop = (e) => {
                    e.preventDefault();
                    box.classList.remove('dragover');
                    if (e.dataTransfer.files.length) {
                        input.files = e.dataTransfer.files;
                    }
                };
            });
        }

        // Open Edit Modal for Single Group Item
        function openEditGroupItemModal(sectionKey, groupId) {
            const jsonElem = document.getElementById(`json_${sectionKey}_${groupId}`);
            if (!jsonElem) return;

            let data;
            try {
                data = JSON.parse(jsonElem.textContent);
            } catch (err) {
                console.error("Failed to parse item json:", err);
                return;
            }

            document.getElementById('editGroupItemModalLabel').textContent = `Edit ${data.item_label}`;
            document.getElementById('editGroupItemSubtitle').textContent = `Page: ${data.page.toUpperCase()} • Section: ${data.section} • Identifier: ${data.group_id}`;
            document.getElementById('edit_modal_page').value = data.page;
            document.getElementById('edit_modal_section').value = data.section;
            document.getElementById('edit_modal_group_id').value = data.group_id;
            document.getElementById('edit_modal_item_label').value = data.item_label;

            const container = document.getElementById('edit_modal_fields_container');
            container.innerHTML = '';

            data.fields.forEach(field => {
                const isLong = field.type === 'textarea' || (field.value && field.value.length > 80);
                const colClass = isLong ? 'col-12' : 'col-md-6 col-12';
                const col = document.createElement('div');
                col.className = colClass;

                let inputHtml = '';
                const val = field.value || '';

                if (field.type === 'textarea' || isLong) {
                    inputHtml = `<textarea name="fields[${field.key}]" class="form-control custom-input" rows="3" placeholder="Enter ${field.label.toLowerCase()}...">${escapeHtml(val)}</textarea>`;
                } else if (field.type === 'image') {
                    inputHtml = `
                            <div class="dropzone-box" id="dropzone_modal_${field.key}">
                                <input type="file" name="media_files[${field.key}]" id="file_modal_${field.key}" class="d-none" accept="image/*">
                                <div class="dropzone-content">
                                    <i class="ri-image-add-line text-primary" style="font-size: 24px;"></i>
                                    <p class="mb-0 mt-1" style="font-size: 12px; font-weight: 600;">Click or drag image here</p>
                                </div>
                                ${field.image_url ? `
                                    <div class="mt-2 d-flex align-items-center gap-2">
                                        <img src="${field.image_url}" alt="${escapeHtml(field.label)}" style="max-height: 60px; border-radius: 4px;" class="border">
                                        <div class="form-check remove-media-check">
                                            <input class="form-check-input" type="checkbox" name="remove_media[${field.key}]" value="1" id="rm_${field.key}">
                                            <label class="form-check-label text-danger small" for="rm_${field.key}">Remove Image</label>
                                        </div>
                                    </div>
                                ` : ''}
                            </div>
                        `;
                } else if (field.type === 'number') {
                    inputHtml = `<input type="number" name="fields[${field.key}]" class="form-control custom-input" value="${escapeHtml(val)}">`;
                } else if (field.type === 'url') {
                    inputHtml = `<input type="text" name="fields[${field.key}]" class="form-control custom-input" value="${escapeHtml(val)}" placeholder="https://...">`;
                } else {
                    inputHtml = `<input type="text" name="fields[${field.key}]" class="form-control custom-input" value="${escapeHtml(val)}" placeholder="Enter ${field.label.toLowerCase()}...">`;
                }

                col.innerHTML = `
                        <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">
                            ${escapeHtml(field.label)}
                            <code class="text-muted ms-1" style="font-size: 11px; font-weight: normal;">${field.key}</code>
                        </label>
                        ${inputHtml}
                    `;
                container.appendChild(col);
            });

            setupDropzones();

            const modal = new bootstrap.Modal(document.getElementById('editGroupItemModal'));
            modal.show();
        }

        // Open Delete Modal for Single Group Item
        function confirmDeleteGroupItem(page, section, groupId, itemLabel) {
            document.getElementById('delete_modal_page').value = page;
            document.getElementById('delete_modal_section').value = section;
            document.getElementById('delete_modal_group_id').value = groupId;
            document.getElementById('delete_modal_item_label').value = itemLabel;
            document.getElementById('delete_modal_item_name').textContent = `"${itemLabel}" (${groupId})`;

            const modal = new bootstrap.Modal(document.getElementById('deleteGroupItemModal'));
            modal.show();
        }

        // Open Add Modal for Group
        function openAddGroupItemModal(page, section, groupType, groupTitle, templateKeys) {
            document.getElementById('add_modal_page').value = page;
            document.getElementById('add_modal_section').value = section;
            document.getElementById('add_modal_group_type').value = groupType;
            document.getElementById('addGroupItemModalLabel').textContent = `Add New ${groupTitle.replace(/s$/, '')}`;
            document.getElementById('addGroupItemSubtitle').textContent = `Page: ${page.toUpperCase()} • Section: ${section}`;

            const container = document.getElementById('add_modal_fields_container');
            container.innerHTML = '';

            if (templateKeys && templateKeys.length > 0) {
                templateKeys.forEach(t => {
                    const isLong = t.type === 'textarea' || t.sub_key.includes('desc') || t.sub_key.includes('text');
                    const colClass = isLong ? 'col-12' : 'col-md-6 col-12';
                    const col = document.createElement('div');
                    col.className = colClass;

                    let inputHtml = '';
                    if (t.type === 'textarea' || isLong) {
                        inputHtml = `<textarea name="fields[${t.sub_key}][value]" class="form-control custom-input" rows="3" placeholder="Enter ${t.label.toLowerCase()}..."></textarea>`;
                    } else if (t.type === 'number') {
                        inputHtml = `<input type="number" name="fields[${t.sub_key}][value]" class="form-control custom-input">`;
                    } else {
                        inputHtml = `<input type="text" name="fields[${t.sub_key}][value]" class="form-control custom-input" placeholder="Enter ${t.label.toLowerCase()}...">`;
                    }

                    col.innerHTML = `
                            <input type="hidden" name="fields[${t.sub_key}][type]" value="${t.type}">
                            <input type="hidden" name="fields[${t.sub_key}][label]" value="${t.label}">
                            <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">${t.label}</label>
                            ${inputHtml}
                        `;
                    container.appendChild(col);
                });
            } else {
                // Generic single value field
                container.innerHTML = `
                        <div class="col-12">
                            <label class="form-label mb-1 fw-semibold text-dark" style="font-size: 13px;">Item Value / Title</label>
                            <input type="text" name="fields[__self__][value]" class="form-control custom-input" placeholder="Enter item content..." required>
                            <input type="hidden" name="fields[__self__][type]" value="text">
                        </div>
                    `;
            }

            const modal = new bootstrap.Modal(document.getElementById('addGroupItemModal'));
            modal.show();
        }

        function confirmDeleteField(fieldId, label) {
            if (confirm(`Are you sure you want to delete the content field "${label}"?`)) {
                const form = document.getElementById('deleteCmsFieldForm');
                if (form) {
                    form.action = `/dashboard/content-management/fields/${fieldId}`;
                    form.submit();
                }
            }
        }

        function escapeHtml(string) {
            if (!string) return '';
            return String(string)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }
    </script>
@endpush