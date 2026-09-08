@extends('admin.app')
@section('title')
    Article Details: {{ $article->title }}
@endsection

@push('custom-style')
    <style>
        .article-meta-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
        }

        .article-meta-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #64748b;
            margin-bottom: 3px;
        }

        .article-meta-value {
            font-size: 13.5px;
            font-weight: 600;
            color: #1e293b;
        }

        .scope-content-box {
            background-color: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 24px;
            font-size: 14.5px;
            line-height: 1.8;
            color: #334155;
        }

        .scope-content-box img {
            max-width: 100%;
            height: auto;
            border-radius: 6px;
            margin: 16px 0;
        }

        .scope-content-box h2, .scope-content-box h3, .scope-content-box h4 {
            font-weight: 700;
            color: #0f172a;
            margin-top: 24px;
            margin-bottom: 12px;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid my-3">
        <div class="row">
            {{-- Main Content Column --}}
            <div class="col-lg-8 col-12">
                {{-- Main Article Card --}}
                <div class="card table-card mb-4">
                    <div class="card-header table-header">
                        <div class="title-with-breadcrumb">
                            <div class="table-title">Article Details: {{ Str::limit($article->title, 40) }}</div>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{ route('articles.index') }}">News & Articles</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Details</li>
                                </ol>
                            </nav>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <a href="{{ route('articles.index') }}" class="add-new" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0;">
                                <i class="ri-arrow-left-line me-1"></i> Article List
                            </a>
                            @canany(['article-edit', 'blog-edit'])
                                <a href="{{ route('articles.edit', $article->id) }}" class="add-new">
                                    <i class="ri-edit-line me-1"></i> Edit Article
                                </a>
                            @endcanany
                        </div>
                    </div>

                    <div class="card-body custom-form p-4">
                        {{-- Cover Image Showcase --}}
                        @if($article->hasMedia('image') || $article->hasMedia('gallery'))
                            <div class="position-relative rounded overflow-hidden mb-4 border" style="height: 280px; background: #0b0f17;">
                                <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                                    onerror="this.onerror=null;this.src='{{ asset('admin/assets/images/default.jpg') }}';"
                                    style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="position-absolute bottom-0 start-0 end-0 p-3 d-flex justify-content-between align-items-end"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.85) 0%, rgba(0,0,0,0) 100%);">
                                    <div>
                                        @if($article->category)
                                            <span class="badge bg-primary mb-1" style="font-size: 11px;">{{ $article->category->name }}</span>
                                        @endif
                                        <h4 class="text-white fw-bold mb-0" style="font-size: 20px;">{{ $article->title }}</h4>
                                    </div>
                                    <div class="d-flex gap-2">
                                        @if($article->is_published)
                                            <span class="badge" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; padding: 5px 10px; border-radius: 4px; font-weight: 700;">
                                                <i class="ri-checkbox-circle-line me-1"></i> Published
                                            </span>
                                        @else
                                            <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; padding: 5px 10px; border-radius: 4px; font-weight: 700;">
                                                Draft
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @else
                            {{-- Title Header when without image --}}
                            <div class="d-flex flex-wrap align-items-center justify-content-between pb-3 mb-4 border-bottom gap-3">
                                <div>
                                    @if($article->category)
                                        <span class="badge mb-2" style="background-color: #f1f5f9; color: #334155; border: 1px solid #e2e8f0; font-size: 11.5px; padding: 4px 8px; font-weight: 600;">
                                            <i class="ri-price-tag-3-line me-1 text-primary"></i> {{ $article->category->name }}
                                        </span>
                                    @endif
                                    <h3 class="fw-bold text-dark mb-1" style="font-size: 22px;">{{ $article->title }}</h3>
                                    <span class="text-muted" style="font-size: 12px;">
                                        Slug: <code class="text-primary">{{ $article->slug }}</code> • Sort Order: <strong>#{{ $article->sort_order }}</strong>
                                    </span>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    @if($article->is_published)
                                        <span class="badge bg-success" style="font-size: 12px; padding: 6px 10px;">
                                            <i class="ri-eye-line me-1"></i> Published
                                        </span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 12px; padding: 6px 10px;">
                                            <i class="ri-eye-off-line me-1"></i> Draft
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        {{-- Executive Summary --}}
                        @if($article->summary)
                            <div class="mb-4">
                                <h6 class="fw-bold text-dark mb-2" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                    Summary &amp; Key Highlights
                                </h6>
                                <p class="text-dark mb-0 p-3 rounded" style="background-color: #fff8f5; border: 1px solid rgba(249, 87, 22, 0.2); border-left: 4px solid #f95716; font-size: 13.5px; line-height: 1.7;">
                                    {{ $article->summary }}
                                </p>
                            </div>
                        @endif

                        {{-- Detailed Article Body --}}
                        <div class="mb-4">
                            <h6 class="fw-bold text-dark mb-2" style="font-size: 13px; text-transform: uppercase; letter-spacing: 0.05em; color: #64748b;">
                                Full Article Content
                            </h6>
                            <div class="scope-content-box">
                                {!! $article->content ?: '<em class="text-muted">No content written yet.</em>' !!}
                            </div>
                        </div>
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
                                <div class="article-meta-box">
                                    <div class="article-meta-label">Meta Title</div>
                                    <div class="article-meta-value">{{ $article->meta_title ?: '—' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="article-meta-box">
                                    <div class="article-meta-label">Meta Keywords</div>
                                    <div class="article-meta-value">{{ $article->meta_keywords ?: '—' }}</div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="article-meta-box">
                                    <div class="article-meta-label">Meta Description</div>
                                    <div class="article-meta-value text-muted" style="font-weight: 400;">{{ $article->meta_description ?: '—' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar Parameters Column --}}
            <div class="col-lg-4 col-12">
                <div class="row g-3">
                    {{-- Article Specifications Card --}}
                    <div class="col-12">
                        <div class="card table-card">
                            <div class="card-header table-header">
                                <div class="table-title">Article Specifications</div>
                            </div>
                            <div class="card-body custom-form">
                                <div class="d-flex flex-column gap-3">
                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Category</div>
                                        <div class="article-meta-value d-flex align-items-center justify-content-between">
                                            <span>{{ $article->category ? $article->category->name : 'Uncategorized' }}</span>
                                            @if($article->category)
                                                <a href="{{ route('articles.index', ['category_id' => $article->category_id]) }}" class="badge" style="background-color: #f1f5f9; color: #334155; text-decoration: none;">
                                                    View in Category
                                                </a>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Visibility Status</div>
                                        <div class="article-meta-value">
                                            @if($article->is_published)
                                                <span class="badge" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0; font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="ri-checkbox-circle-line me-1"></i> Public Live
                                                </span>
                                            @else
                                                <span class="badge" style="background-color: #f1f5f9; color: #475569; border: 1px solid #cbd5e1; font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    Draft / Hidden
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Homepage Feature</div>
                                        <div class="article-meta-value">
                                            @if($article->featured)
                                                <span class="badge" style="background-color: #fff7ed; color: #ea580c; border: 1px solid rgba(249,87,22,0.3); font-size: 11.5px; padding: 4px 8px; border-radius: 4px;">
                                                    <i class="ri-star-line me-1"></i> Featured on Home
                                                </span>
                                            @else
                                                <span class="text-muted" style="font-size: 13px;">Standard Display</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Author</div>
                                        <div class="article-meta-value">
                                            <i class="ri-user-3-line text-muted me-1"></i> {{ $article->author_name ?: 'Editorial Team' }}
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Publication Date</div>
                                        <div class="article-meta-value">
                                            <i class="ri-calendar-line text-muted me-1"></i> {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Not Scheduled' }}
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Reading Time</div>
                                        <div class="article-meta-value">
                                            <i class="ri-time-line text-muted me-1"></i> {{ $article->read_time }} Minutes
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Total Views</div>
                                        <div class="article-meta-value text-primary">
                                            <i class="ri-eye-line text-primary me-1"></i> {{ number_format($article->views_count) }} Impressions
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
                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Created By</div>
                                        <div class="article-meta-value text-muted" style="font-size: 13px;">
                                            {{ $article->creator?->name ?? 'System Administrator' }}
                                            <div class="text-muted" style="font-size: 11px; font-weight: 400;">
                                                {{ $article->created_at?->format('M d, Y h:i A') }}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="article-meta-box">
                                        <div class="article-meta-label">Last Modified</div>
                                        <div class="article-meta-value text-muted" style="font-size: 13px;">
                                            {{ $article->updater?->name ?? 'System Administrator' }}
                                            <div class="text-muted" style="font-size: 11px; font-weight: 400;">
                                                {{ $article->updated_at?->format('M d, Y h:i A') }}
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
