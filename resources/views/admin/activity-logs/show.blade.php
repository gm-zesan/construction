@extends('admin.app')
@section('title')
    Activity Log #{{ $log->id }} - {{ ucfirst($log->module) }} {{ ucwords(str_replace('_', ' ', $log->action)) }}
@endsection

@push('custom-style')
    <style>
        .log-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .log-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 4px;
        }

        .log-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
            word-break: break-word;
        }

        .log-description-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 18px;
            font-size: 14px;
            line-height: 1.6;
            color: #334155;
        }

        .json-code-box {
            background-color: #0f172a;
            color: #e2e8f0;
            border-radius: 6px;
            padding: 14px 16px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 12.5px;
            line-height: 1.6;
            overflow-x: auto;
            max-height: 380px;
            margin-bottom: 0;
        }

        .empty-diff-state {
            background-color: #f8fafc;
            border: 1px dashed #cbd5e1;
            border-radius: 6px;
            padding: 24px;
            text-align: center;
            color: #94a3b8;
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Main Column: Log Details and Values --}}
            <div class="col-lg-8 col-12">
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Activity Audit Details</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('activity-logs.index') }}">Activity
                                            Logs</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Log #{{ $log->id }}</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('activity-logs.index') }}" class="add-new"
                            style="background-color: #f1f5f9; color: #334155;">
                            <i class="ri-arrow-left-line me-1"></i> Back to Logs
                        </a>
                    </div>
                    <div class="card-body custom-form p-4">
                        {{-- Log Header Badge & Module Banner --}}
                        <div
                            class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-3 border-bottom gap-3">
                            <div class="d-flex align-items-center gap-2">
                                @php
                                    $action = strtolower($log->action);
                                    $badgeStyles = [
                                        'create' => 'background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;',
                                        'update' => 'background-color: #eff6ff; color: #1e40af; border: 1px solid #bfdbfe;',
                                        'delete' => 'background-color: #fee2e2; color: #dc2626; border: 1px solid #fca5a5;',
                                        'status_change' => 'background-color: #fef3c7; color: #d97706; border: 1px solid #fde68a;',
                                        'delete_media' => 'background-color: #fff1f2; color: #e11d48; border: 1px solid #fecdd3;',
                                        'login' => 'background-color: #f0fdf4; color: #166534; border: 1px solid #bbf7d0;',
                                        'logout' => 'background-color: #f8fafc; color: #475569; border: 1px solid #cbd5e1;',
                                    ];
                                    $style = $badgeStyles[$action] ?? 'background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1;';

                                    $moduleIcons = [
                                        'project' => 'ri-community-line',
                                        'service' => 'ri-hammer-line',
                                        'enquiry' => 'ri-mail-line',
                                        'media' => 'ri-image-line',
                                        'user' => 'ri-user-3-line',
                                        'role' => 'ri-shield-user-line',
                                        'auth' => 'ri-lock-line',
                                    ];
                                    $modIcon = $moduleIcons[strtolower($log->module)] ?? 'ri-file-list-line';
                                @endphp
                                <span class="badge"
                                    style="{{ $style }} font-size: 13px; padding: 6px 12px; border-radius: 6px; font-weight: 700;">
                                    {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                </span>
                                <span class="badge"
                                    style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 13px; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                    <i class="{{ $modIcon }} me-1 text-primary"></i>{{ ucfirst($log->module) }}
                                </span>
                            </div>
                            <div class="text-muted" style="font-size: 12.5px;">
                                <i class="ri-time-line me-1"></i>
                                {{ $log->created_at ? $log->created_at->format('M d, Y - h:i A') . ' (' . $log->created_at->diffForHumans() . ')' : '—' }}
                            </div>
                        </div>

                        {{-- Full Description --}}
                        <div class="mb-4">
                            <label class="form-label mb-2 text-muted"
                                style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                Description / Summary
                            </label>
                            <div class="log-description-box">
                                {{ $log->description ?: 'No additional description recorded.' }}
                            </div>
                        </div>

                        {{-- Subject Information --}}
                        <div class="mb-4">
                            <label class="form-label mb-2 text-muted"
                                style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                Subject Reference
                            </label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="log-meta-box">
                                        <div class="log-meta-label">Subject Model Type</div>
                                        <div class="log-meta-value">
                                            @if($log->subject_type)
                                                <code style="font-size: 12.5px; color: #0284c7;">{{ $log->subject_type }}</code>
                                            @else
                                                <span class="text-muted fw-normal">None / General Action</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="log-meta-box">
                                        <div class="log-meta-label">Subject Record ID</div>
                                        <div class="log-meta-value d-flex align-items-center justify-content-between">
                                            <span>
                                                @if($log->subject_id)
                                                    #{{ $log->subject_id }}
                                                @else
                                                    <span class="text-muted fw-normal">—</span>
                                                @endif
                                            </span>
                                            @if($log->subject)
                                                @if($log->module === 'project' && Route::has('projects.edit'))
                                                    <a href="{{ route('projects.edit', $log->subject_id) }}"
                                                        class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11.5px;">
                                                        <i class="ri-external-link-line me-1"></i> View Project
                                                    </a>
                                                @elseif($log->module === 'service' && Route::has('services.edit'))
                                                    <a href="{{ route('services.edit', $log->subject_id) }}"
                                                        class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11.5px;">
                                                        <i class="ri-external-link-line me-1"></i> View Service
                                                    </a>
                                                @elseif($log->module === 'enquiry' && Route::has('enquiries.show'))
                                                    <a href="{{ route('enquiries.show', $log->subject_id) }}"
                                                        class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 11.5px;">
                                                        <i class="ri-external-link-line me-1"></i> View Enquiry
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Changed Data Values (Side by Side or Tabs) --}}
                        <div>
                            <label class="form-label mb-2 text-muted"
                                style="font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                                Data State &amp; Changes
                            </label>

                            <div class="row g-3">
                                {{-- Old Values --}}
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-none border" style="border-radius: 8px;">
                                        <div
                                            class="card-header py-2 px-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                                            <span class="fw-bold text-dark" style="font-size: 12.5px;">
                                                <i class="ri-history-line text-warning me-1"></i> Previous Values (Old)
                                            </span>
                                            @if(!empty($log->old_values))
                                                <span class="badge bg-secondary"
                                                    style="font-size: 10px;">{{ count($log->old_values) }} attributes</span>
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            @if(!empty($log->old_values) && is_array($log->old_values))
                                                <pre
                                                    class="json-code-box"><code>{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                            @else
                                                <div class="empty-diff-state">
                                                    <i class="ri-file-shield-line d-block mb-1" style="font-size: 24px;"></i>
                                                    No prior state recorded
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- New Values --}}
                                <div class="col-md-6">
                                    <div class="card h-100 shadow-none border" style="border-radius: 8px;">
                                        <div
                                            class="card-header py-2 px-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                                            <span class="fw-bold text-dark" style="font-size: 12.5px;">
                                                <i class="ri-file-list-3-line text-success me-1"></i> Updated Values (New)
                                            </span>
                                            @if(!empty($log->new_values))
                                                <span class="badge bg-primary"
                                                    style="font-size: 10px;">{{ count($log->new_values) }} attributes</span>
                                            @endif
                                        </div>
                                        <div class="card-body p-2">
                                            @if(!empty($log->new_values) && is_array($log->new_values))
                                                <pre
                                                    class="json-code-box"><code>{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) }}</code></pre>
                                            @else
                                                <div class="empty-diff-state">
                                                    <i class="ri-file-shield-line d-block mb-1" style="font-size: 24px;"></i>
                                                    No updated state payload
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Right Column: User / Operator & Request Metadata --}}
            <div class="col-lg-4 col-12">
                {{-- Operator Profile Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title" style="font-size: 14px;">Operator Details</div>
                    </div>
                    <div class="card-body p-3">
                        @if($log->user)
                            @php
                                $uInitials = strtoupper(substr($log->user->name, 0, 1));
                                $avatarColors = ['#f95716', '#4f46e5', '#0284c7', '#059669', '#d97706'];
                                $colorIndex = crc32($log->user->name) % count($avatarColors);
                                $bgColor = $avatarColors[abs($colorIndex)];
                            @endphp
                            <div class="d-flex align-items-center gap-3 mb-3 pb-3 border-bottom">
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                    style="width: 44px; height: 44px; font-size: 16px; background-color: {{ $bgColor }};">
                                    {{ $uInitials }}
                                </div>
                                <div class="text-truncate">
                                    <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 14.5px;">
                                        {{ $log->user->name }}</h6>
                                    <span class="text-muted text-truncate d-block"
                                        style="font-size: 12px;">{{ $log->user->email }}</span>
                                </div>
                            </div>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex justify-content-between align-items-center py-1 border-bottom">
                                    <span class="text-muted" style="font-size: 12px;">User ID:</span>
                                    <span class="fw-semibold text-dark" style="font-size: 12.5px;">#{{ $log->user->id }}</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center py-1">
                                    <span class="text-muted" style="font-size: 12px;">Roles:</span>
                                    <span class="fw-semibold text-dark" style="font-size: 12px;">
                                        @forelse($log->user->getRoleNames() as $roleName)
                                            <span class="badge bg-secondary" style="font-size: 10.5px;">{{ $roleName }}</span>
                                        @empty
                                            <span class="text-muted">—</span>
                                        @endforelse
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-3">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold mb-2"
                                    style="width: 44px; height: 44px; font-size: 16px; background-color: #64748b;">
                                    S
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-size: 14px;">System / Unauthenticated</h6>
                                <p class="text-muted mb-0" style="font-size: 12px;">This activity was triggered via an
                                    unauthenticated public action or automated routine.</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Request Metadata Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title" style="font-size: 14px;">Audit Telemetry</div>
                    </div>
                    <div class="card-body p-3">
                        <div class="d-flex flex-column gap-3">
                            <div class="log-meta-box">
                                <div class="log-meta-label"><i class="ri-global-line me-1"></i> Client IP Address</div>
                                <div class="log-meta-value">
                                    <code>{{ $log->ip_address ?: 'Unavailable' }}</code>
                                </div>
                            </div>

                            <div class="log-meta-box">
                                <div class="log-meta-label"><i class="ri-computer-line me-1"></i> User Agent / Device</div>
                                <div class="log-meta-value"
                                    style="font-size: 12px; font-weight: normal; color: #475569; line-height: 1.5;">
                                    {{ $log->user_agent ?: 'Unavailable' }}
                                </div>
                            </div>

                            <div class="log-meta-box">
                                <div class="log-meta-label"><i class="ri-calendar-check-line me-1"></i> Audit Timestamp
                                </div>
                                <div class="log-meta-value" style="font-size: 13px;">
                                    {{ $log->created_at ? $log->created_at->toDayDateTimeString() : '—' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection