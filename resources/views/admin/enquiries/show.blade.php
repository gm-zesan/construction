@extends('admin.app')
@section('title')
    Enquiry Details - {{ $enquiry->name }}
@endsection

@push('custom-style')
    <style>
        .enquiry-info-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
        }

        .enquiry-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .enquiry-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .message-content-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-left: 4px solid #f95716;
            border-radius: 6px;
            padding: 18px 20px;
            font-size: 14px;
            line-height: 1.7;
            color: #334155;
            white-space: pre-wrap;
        }

        .ref-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            transition: all 0.2s ease;
            overflow: hidden;
        }

        .ref-card:hover {
            border-color: #cbd5e1;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Left Column: Enquiry Content & Context --}}
            <div class="col-lg-8 col-12">
                {{-- Main Enquiry Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Enquiry Information</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('enquiries.index') }}">Enquiries</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <a href="{{ route('enquiries.index') }}" class="add-new" style="background-color: #f1f5f9; color: #334155;">
                            <i class="ri-arrow-left-line me-1"></i> Back to Enquiries
                        </a>
                    </div>
                    <div class="card-body custom-form p-4">
                        {{-- Sender Summary Banner --}}
                        <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-3 border-bottom gap-3">
                            <div class="d-flex align-items-center gap-3">
                                @php
                                    $initials = strtoupper(substr($enquiry->name, 0, 1));
                                    $avatarColors = ['#f95716', '#4f46e5', '#0284c7', '#059669', '#d97706'];
                                    $colorIndex = crc32($enquiry->name) % count($avatarColors);
                                    $bgColor = $avatarColors[abs($colorIndex)];
                                @endphp
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold flex-shrink-0"
                                    style="width: 48px; height: 48px; font-size: 18px; background-color: {{ $bgColor }};">
                                    {{ $initials }}
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 17px;">{{ $enquiry->name }}</h5>
                                    <span class="text-muted" style="font-size: 12.5px;">
                                        {{ $enquiry->company ? $enquiry->company . ' • ' : '' }}
                                        Received {{ ($enquiry->submitted_at ?? $enquiry->created_at)->format('M d, Y \a\t h:i A') }}
                                        ({{ ($enquiry->submitted_at ?? $enquiry->created_at)->diffForHumans() }})
                                    </span>
                                </div>
                            </div>
                            <div>
                                @php
                                    $enumStatus = $enquiry->status instanceof \App\Enums\EnquiryStatus ? $enquiry->status : \App\Enums\EnquiryStatus::tryFrom($enquiry->status);
                                    $badgeStyle = $enumStatus ? $enumStatus->badgeStyle() : 'background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1;';
                                @endphp
                                <span class="badge" style="{{ $badgeStyle }} font-size: 12px; padding: 6px 12px; border-radius: 6px; font-weight: 700;">
                                    <i class="ri-checkbox-blank-circle-fill me-1" style="font-size: 8px;"></i>
                                    {{ $enumStatus ? $enumStatus->label() : ucfirst($enquiry->status) }}
                                </span>
                            </div>
                        </div>

                        {{-- Client Contact Meta Grid --}}
                        <div class="row g-3 mb-4">
                            <div class="col-md-4 col-sm-6">
                                <div class="enquiry-info-box">
                                    <div class="enquiry-meta-label">Email Address</div>
                                    <div class="enquiry-meta-value text-truncate">
                                        <a href="mailto:{{ $enquiry->email }}" class="text-primary text-decoration-none">
                                            <i class="ri-mail-line me-1"></i> {{ $enquiry->email }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="enquiry-info-box">
                                    <div class="enquiry-meta-label">Phone Number</div>
                                    <div class="enquiry-meta-value">
                                        @if($enquiry->phone)
                                            <a href="tel:{{ $enquiry->phone }}" class="text-dark text-decoration-none">
                                                <i class="ri-phone-line me-1 text-success"></i> {{ $enquiry->phone }}
                                            </a>
                                        @else
                                            <span class="text-muted">Not Provided</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <div class="enquiry-info-box">
                                    <div class="enquiry-meta-label">Company / Organization</div>
                                    <div class="enquiry-meta-value text-truncate">
                                        {{ $enquiry->company ?: 'Individual Client' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Subject & Detailed Message --}}
                        <div class="mb-2">
                            <label class="form-label custom-label text-dark fw-bold mb-1" style="font-size: 14px;">
                                Subject: {{ $enquiry->subject }}
                            </label>
                            <div class="message-content-box mt-2">
                                {{ $enquiry->message }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Associated Context: Related Service & Project --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="table-title">Associated Portfolio Context</div>
                    </div>
                    <div class="card-body custom-form p-3">
                        <div class="row g-3">
                            {{-- Associated Service --}}
                            <div class="col-md-6 col-12">
                                <div class="ref-card p-3 h-100">
                                    <span class="enquiry-meta-label d-block">Inquired Service</span>
                                    @if($enquiry->service)
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <div class="rounded d-flex align-items-center justify-content-center flex-shrink-0"
                                                style="width: 38px; height: 38px; background-color: #eef2ff; color: #4f46e5; font-size: 18px;">
                                                <i class="{{ $enquiry->service->icon ?: 'ri-hammer-line' }}"></i>
                                            </div>
                                            <div class="overflow-hidden">
                                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 13.5px;">{{ $enquiry->service->title }}</h6>
                                                <span class="text-muted text-truncate d-block" style="font-size: 11px;">Slug: {{ $enquiry->service->slug }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('services.edit', $enquiry->service->id) }}" class="btn btn-sm btn-outline-primary w-100" style="font-size: 12px;">
                                                <i class="ri-edit-line me-1"></i> View / Edit Service
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-muted mt-2" style="font-size: 13px;">
                                            <i class="ri-information-line me-1"></i> No specific service attached to this enquiry.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Associated Project --}}
                            <div class="col-md-6 col-12">
                                <div class="ref-card p-3 h-100">
                                    <span class="enquiry-meta-label d-block">Referenced Project</span>
                                    @if($enquiry->project)
                                        <div class="d-flex align-items-center gap-2 mt-2">
                                            <div class="rounded overflow-hidden flex-shrink-0"
                                                style="width: 48px; height: 38px; background-color: #000;">
                                                <img src="{{ $enquiry->project->main_image_url }}" alt="{{ $enquiry->project->title }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                                    style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div class="overflow-hidden">
                                                <h6 class="fw-bold text-dark mb-0 text-truncate" style="font-size: 13.5px;">{{ $enquiry->project->title }}</h6>
                                                <span class="text-muted text-truncate d-block" style="font-size: 11px;">{{ $enquiry->project->category }} • {{ $enquiry->project->location ?: 'Site' }}</span>
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <a href="{{ route('projects.edit', $enquiry->project->id) }}" class="btn btn-sm btn-outline-success w-100" style="font-size: 12px;">
                                                <i class="ri-community-line me-1"></i> View / Edit Project
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-muted mt-2" style="font-size: 13px;">
                                            <i class="ri-information-line me-1"></i> General enquiry (no specific project attached).
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Column: Status, Internal Notes & Actions --}}
            <div class="col-lg-4 col-12">
                <div class="row g-3">
                    {{-- Status & Internal Notes Form --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Management &amp; Notes</div>
                            </div>
                            <div class="card-body custom-form">
                                <form id="enquiryUpdateForm" action="{{ route('enquiries.update', $enquiry->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    {{-- Status Selection --}}
                                    <div class="mb-3">
                                        <label for="status" class="form-label custom-label">Follow-up Status <span class="text-danger">*</span></label>
                                        <select class="form-select custom-input @error('status') is-invalid @enderror" name="status" id="status" required>
                                            @foreach($statuses as $status)
                                                <option value="{{ $status->value }}" {{ old('status', $enquiry->status instanceof \App\Enums\EnquiryStatus ? $enquiry->status->value : $enquiry->status) === $status->value ? 'selected' : '' }}>
                                                    {{ $status->label() }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('status')
                                            <div class="error_msg">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Internal Admin Notes --}}
                                    <div class="mb-3">
                                        <label for="internal_notes" class="form-label custom-label">Internal Staff Notes</label>
                                        <textarea class="form-control custom-input @error('internal_notes') is-invalid @enderror"
                                            name="internal_notes" id="internal_notes" rows="6"
                                            placeholder="Add confidential notes on phone calls, estimate status, or assigned staff members..."
                                            style="resize: vertical;">{{ old('internal_notes', $enquiry->internal_notes) }}</textarea>
                                        <span class="text-muted d-block mt-1" style="font-size: 11px;">
                                            Visible to admins only. Not shared with the client.
                                        </span>
                                        @error('internal_notes')
                                            <div class="error_msg">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn submit-button w-100">
                                        <i class="ri-save-line me-1"></i> Update Status &amp; Notes
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Quick Communication Card --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Direct Outreach</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-2">
                                    <a href="mailto:{{ $enquiry->email }}?subject=Re: {{ rawurlencode($enquiry->subject) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2" style="height: 38px; font-size: 13px; font-weight: 600;">
                                        <i class="ri-mail-send-line"></i> Compose Email Reply
                                    </a>
                                    @if($enquiry->phone)
                                        <a href="tel:{{ $enquiry->phone }}" class="btn btn-outline-success w-100 d-flex align-items-center justify-content-center gap-2" style="height: 38px; font-size: 13px; font-weight: 600;">
                                            <i class="ri-phone-line"></i> Place Phone Call
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Deletion Card --}}
                    @can('contact-delete')
                    <div class="col-12">
                        <div class="card table-card border-danger border-opacity-25">
                            <div class="card-header table-header bg-danger bg-opacity-10">
                                <div class="table-title text-danger text-light">Danger Zone</div>
                            </div>
                            <div class="card-body custom-form">
                                <p class="text-muted mb-3" style="font-size: 12px;">
                                    Permanently remove this enquiry record from the database.
                                </p>
                                <button type="button" class="btn btn-outline-danger w-100 btn-delete-modal"
                                    data-name="{{ $enquiry->name }}"
                                    data-subject="{{ $enquiry->subject }}"
                                    data-url="{{ route('enquiries.destroy', $enquiry->id) }}"
                                    style="height: 36px; font-size: 13px; font-weight: 600;">
                                    <i class="ri-delete-bin-line me-1"></i> Delete Enquiry
                                </button>
                            </div>
                        </div>
                    </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Confirmation Modal --}}
    <div class="modal fade" id="deleteEnquiryModal" tabindex="-1" aria-labelledby="deleteModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"
                style="border-radius: 10px; border: 1px solid #e2e8f0; overflow: hidden; box-shadow: 0 20px 25px -5px rgba(11, 15, 23, 0.1);">
                <div class="modal-header"
                    style="background-color: #fee2e2; border-bottom: 1px solid #fca5a5; padding: 16px 20px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="ri-error-warning-line text-danger" style="font-size: 22px;"></i>
                        <h5 class="modal-title fw-bold text-danger mb-0" id="deleteModalTitle" style="font-size: 16px;">
                            Confirm Enquiry Deletion</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" style="padding: 20px;">
                    <p class="mb-2" style="font-size: 14px; color: #334155;">
                        Are you sure you want to permanently delete the inquiry from <strong id="deleteEnquiryName"
                            class="text-dark"></strong> regarding <span id="deleteEnquirySubject" class="fst-italic"></span>?
                    </p>
                    <p class="text-muted mb-0" style="font-size: 12.5px;">
                        This action cannot be undone. Associated activity logs for this deletion will be recorded.
                    </p>
                </div>
                <div class="modal-footer"
                    style="background-color: #f8fafc; border-top: 1px solid #e2e8f0; padding: 12px 20px;">
                    <button type="button" class="btn btn-sm btn-outline-secondary px-3" data-bs-dismiss="modal"
                        style="font-size: 13px; height: 36px; border-radius: 6px;">Cancel</button>
                    <form id="deleteEnquiryForm" method="POST" action="">
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
            // Delete Modal setup
            $(document).on('click', '.btn-delete-modal', function () {
                var name = $(this).data('name');
                var subject = $(this).data('subject');
                var url = $(this).data('url');

                $('#deleteEnquiryName').text(name);
                $('#deleteEnquirySubject').text('"' + subject + '"');
                $('#deleteEnquiryForm').attr('action', url);
                $('#deleteEnquiryModal').modal('show');
            });
        });
    </script>
@endpush
