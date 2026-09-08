@extends('admin.app')
@section('title', 'CKEditor Rich Text Editor')

@section('content')
<div class="container-fluid my-3">
    <div class="row">
        <div class="col-12">
            <div class="card table-card">
                <div class="card-header table-header">
                    <div class="title-with-breadcrumb">
                        <div class="table-title">CKEditor Document Studio</div>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">CKEditor</li>
                            </ol>
                        </nav>
                    </div>
                </div>
                <div class="card-body custom-form p-4">
                    <div class="alert alert-info d-flex align-items-center mb-4" role="alert" style="border-left: 4px solid #f95716; background: rgba(249, 87, 22, 0.08); color: #111a3a;">
                        <i class="ri-information-line fs-4 me-2" style="color: #f95716;"></i>
                        <div>
                            <strong>WYSIWYG Rich Text Engine:</strong> Full image upload, formatting, table tools, and inline media embeds enabled with Laravel asset management.
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <label for="editor_demo" class="form-label custom-label fw-bold mb-2">Editor Content Canvas</label>
                            <textarea id="editor_demo" name="content" class="form-control" rows="12">
                                <h2>Commercial Architectural & Structural Excellence</h2>
                                <p>This rich-text environment is fully integrated with our Laravel backend, supporting direct media attachments, formatted engineering specifications, tables, blockquotes, and custom typography.</p>
                                <blockquote>Safety, precision, and architectural distinction on every site.</blockquote>
                            </textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('custom-scripts')
<script src="{{ asset('vendor/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
    setTimeout(function() {
        if (typeof CKEDITOR !== 'undefined') {
            CKEDITOR.replace('editor_demo', {
                filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token() ]) }}",
                filebrowserUploadMethod: 'form',
                height: 380
            });
        }
    }, 100);
</script>
@endpush
