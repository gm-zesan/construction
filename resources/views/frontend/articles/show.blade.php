@extends('layouts.app')

@section('content')
    <!-- Top Reading Progress Bar -->
    <div id="article-reading-progress"
        class="fixed top-0 left-0 h-[3px] bg-[#f95716] z-50 origin-left scale-x-0 pointer-events-none transition-none shadow-[0_0_8px_#f95716]">
    </div>

    <!-- 1. Article Hero & Editorial Header -->
    <section id="article-hero"
        class="relative pt-32 pb-16 lg:pt-40 lg:pb-20 bg-[#080c14] text-white overflow-hidden border-b border-white/10">

        <!-- Background Subtle Blueprint Matrix -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff06_1px,transparent_1px),linear-gradient(to_bottom,#ffffff06_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
            <div class="absolute top-1/3 -right-32 w-96 h-96 rounded-full bg-[#f95716]/10 blur-3xl pointer-events-none">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Breadcrumbs -->
            <nav class="article-hero-fade flex items-center gap-2 text-xs font-mono uppercase tracking-wider text-slate-400 mb-8"
                aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-white transition-colors">
                    {{ get_content('article_detail', 'hero', 'breadcrumb_home', 'Home') }}
                </a>
                <span class="text-slate-600">/</span>
                <a href="{{ route('public.articles.index') }}" class="hover:text-white transition-colors">
                    {{ get_content('article_detail', 'hero', 'breadcrumb_articles', 'Articles') }}
                </a>
                @if($article->category)
                    <span class="text-slate-600">/</span>
                    <a href="{{ route('public.articles.index', ['category' => $article->category->slug]) }}"
                        class="text-[#f95716] hover:underline">
                        {{ $article->category->name }}
                    </a>
                @endif
            </nav>

            <!-- Metadata Header Badges -->
            <div class="article-hero-fade flex flex-wrap items-center gap-3 sm:gap-4 mb-6">
                @if($article->category)
                    <span
                        class="inline-flex items-center px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-[#f95716] text-white shadow-md">
                        {{ $article->category->name }}
                    </span>
                @endif

                @if($article->read_time)
                    <span
                        class="font-mono text-xs font-semibold text-slate-300 bg-white/10 px-3 py-1 rounded-full border border-white/10">
                        {{ $article->read_time }} {{ get_content('article_detail', 'hero', 'min_read_suffix', 'MIN READ') }}
                    </span>
                @endif

                @if($article->published_at)
                    <span class="font-mono text-xs text-slate-400">
                        {{ get_content('article_detail', 'hero', 'published_prefix', 'Published on') }}
                        {{ $article->published_at->format('F d, Y') }}
                    </span>
                @endif
            </div>

            <!-- Grand Headline -->
            <h1
                class="article-hero-fade font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-5xl lg:text-6xl mb-6">
                {{ $article->title }}
            </h1>

            <!-- Author & Brief Summary -->
            <div class="article-hero-fade flex flex-col sm:flex-row sm:items-center justify-between gap-6 pt-6 border-t border-white/10">
                <!-- Author Info -->
                <div class="flex items-center gap-3">
                    <div
                        class="w-11 h-11 rounded-full bg-[#f95716] flex items-center justify-center font-heading font-black text-white text-base shadow-md">
                        {{ strtoupper(substr($article->author_name ?? 'E', 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-sm font-bold text-white uppercase tracking-wider">
                            {{ $article->author_name ?? get_setting('company_name', 'Senior Engineering Team') }}
                        </div>
                        <div class="text-xs font-mono text-slate-400">
                            {{ get_content('article_detail', 'hero', 'verified_label', 'Technical Field Documentation · Verified Dispatch') }}
                        </div>
                    </div>
                </div>

                <!-- Views Counter -->
                <div class="font-mono text-xs text-slate-400 flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-[#f95716]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span>{{ number_format($article->views_count ?? 1) }} Views</span>
                </div>
            </div>

        </div>

    </section>

    <!-- 2. Primary High-Res Visual Cover Plate -->
    <section id="article-cover-plate" class="relative bg-[#080c14] pb-16 sm:pb-20">
        <div class="container-fluid relative z-10 max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="article-cover-box relative aspect-[16/9] sm:aspect-[21/9] rounded-2xl sm:rounded-3xl overflow-hidden bg-slate-900 border border-white/15 shadow-2xl">
                <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                    class="w-full h-full object-cover object-center" loading="eager" fetchpriority="high" />
                <div
                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent pointer-events-none">
                </div>
                <div
                    class="absolute bottom-4 left-6 right-6 flex items-center justify-between text-xs text-slate-300 font-mono">
                    <span>{{ get_content('article_detail', 'plate', 'plate_label', 'Field Record Plate') }} —
                        {{ $article->category->name ?? 'Civil Engineering' }}</span>
                    <span
                        class="hidden sm:inline">{{ get_content('article_detail', 'plate', 'compliance_label', 'Certified QA/QC Documentation') }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Article Editorial Narrative & Sticky Technical Sidebar -->
    <section id="article-body-section" class="py-16 sm:py-20 lg:py-24 bg-[#ffffff] text-slate-900">
        <div class="container-fluid max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-start">

                <!-- Left Column (8 Cols): Rich Typography Reading Area -->
                <article class="lg:col-span-8 space-y-8">

                    <!-- Summary Lead Box -->
                    @if($article->summary)
                        <div
                            class="p-6 sm:p-8 rounded-2xl bg-[#f8f7f4] text-slate-800 text-lg sm:text-xl font-normal leading-relaxed shadow-sm">
                            {{ $article->summary }}
                        </div>
                    @endif

                    <!-- Rich HTML Content -->
                    <div
                        class="article-prose prose prose-lg sm:prose-xl max-w-none text-slate-700 leading-relaxed prose-headings:font-heading prose-headings:font-black prose-headings:uppercase prose-headings:text-slate-950 prose-a:text-[#f95716] prose-a:font-semibold hover:prose-a:underline prose-img:rounded-2xl prose-img:shadow-lg prose-blockquote:border-l-[#f95716] prose-blockquote:bg-slate-50 prose-blockquote:p-4 prose-blockquote:rounded-r-lg">
                        @if($article->content)
                            {!! $article->content !!}
                        @else
                            <p>
                                Structural precision and geotechnical safety remain at the core of heavy commercial
                                construction. Through continuous seismic modeling, pre-engineered steel erection, and
                                certified material testing, our engineering crews ensure that every structural tier
                                meets zero-incident compliance standards.
                            </p>
                        @endif
                    </div>

                    <!-- Author Sign-Off Card -->
                    <div
                        class="mt-12 pt-8 border-t border-slate-200 flex items-center gap-4 sm:gap-6 bg-[#f8f7f4] p-6 rounded-2xl">
                        <div
                            class="w-14 h-14 rounded-full bg-[#0b0f17] text-[#f95716] flex items-center justify-center font-heading font-black text-xl flex-shrink-0">
                            {{ strtoupper(substr($article->author_name ?? 'A', 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="font-heading font-black uppercase text-slate-950 text-base m-0">
                                Written by
                                {{ $article->author_name ?? get_setting('company_name', 'Engineering Editorial Board') }}
                            </h4>
                            <p class="text-xs sm:text-sm text-slate-600 m-0 mt-1">
                                {{ get_content('article_detail', 'author', 'author_bio', 'Technical project lead specializing in structural concrete mechanics, BIM coordination, and high-tolerance infrastructure delivery.') }}
                            </p>
                        </div>
                    </div>

                </article>

                <!-- Right Column (4 Cols): Sticky Technical Sidebar -->
                <aside class="lg:col-span-4 space-y-6">

                    <!-- Sticky Container -->
                    <div class="tech-sidebar-card sticky top-28 space-y-6">

                        <!-- Technical Data Sheet Card -->
                        <div class="bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm space-y-5">
                            <h3
                                class="text-xs font-mono uppercase tracking-widest text-slate-900 font-bold border-b border-slate-200 pb-3">
                                {{ get_content('article_detail', 'sidebar', 'specs_title', 'Dispatch Specifications') }}
                            </h3>

                            <dl class="divide-y divide-slate-200/70 text-sm">
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">
                                        {{ get_content('article_detail', 'sidebar', 'record_id_label', 'Record ID') }}</dt>
                                    <dd class="font-mono font-semibold text-slate-900">
                                        ART-{{ str_pad($article->id, 4, '0', STR_PAD_LEFT) }}
                                    </dd>
                                </div>
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">
                                        {{ get_content('article_detail', 'sidebar', 'category_label', 'Category') }}</dt>
                                    <dd class="font-semibold text-slate-900">
                                        {{ $article->category->name ?? 'General Build' }}
                                    </dd>
                                </div>
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">
                                        {{ get_content('article_detail', 'sidebar', 'published_label', 'Published') }}</dt>
                                    <dd class="font-mono text-slate-900">
                                        {{ $article->published_at ? $article->published_at->format('M d, Y') : 'Recent' }}
                                    </dd>
                                </div>
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">
                                        {{ get_content('article_detail', 'sidebar', 'duration_label', 'Read Duration') }}
                                    </dt>
                                    <dd class="font-semibold text-slate-900">
                                        {{ $article->read_time ?? 4 }}
                                        {{ get_content('article_detail', 'sidebar', 'minutes_label', 'Minutes') }}
                                    </dd>
                                </div>
                                <div class="py-2.5 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">
                                        {{ get_content('article_detail', 'sidebar', 'verification_label', 'Verification') }}
                                    </dt>
                                    <dd class="font-semibold text-emerald-600 flex items-center gap-1">
                                        <span>{{ get_content('article_detail', 'sidebar', 'verification_status', 'Peer-Reviewed') }}</span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <!-- Share This Dispatch Card -->
                        <div class="bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 shadow-sm">
                            <h4 class="text-xs font-mono uppercase tracking-widest text-slate-900 font-bold mb-4">
                                {{ get_content('article_detail', 'sidebar', 'share_title', 'Share Analysis') }}
                            </h4>
                            <div class="flex items-center gap-3">
                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full bg-white hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200 flex items-center justify-center transition-all duration-300 shadow-sm"
                                    aria-label="Share on LinkedIn">
                                    <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.97 0 1.75-.79 1.75-1.76s-.78-1.75-1.75-1.75a1.75 1.75 0 0 0-1.76 1.75c0 .97.79 1.76 1.76 1.76m1.39 9.74v-8.37H5.07v8.37h2.78z" />
                                    </svg>
                                </a>

                                <!-- Twitter / X -->
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($article->title) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full bg-white hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200 flex items-center justify-center transition-all duration-300 shadow-sm"
                                    aria-label="Share on Twitter">
                                    <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                </a>

                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                    target="_blank" rel="noopener noreferrer"
                                    class="w-10 h-10 rounded-full bg-white hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200 flex items-center justify-center transition-all duration-300 shadow-sm"
                                    aria-label="Share on Facebook">
                                    <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                                    </svg>
                                </a>

                                <!-- Copy Link Button -->
                                <button type="button"
                                    onclick="navigator.clipboard.writeText(window.location.href); alert('Dispatch link copied to clipboard!');"
                                    class="w-10 h-10 rounded-full bg-white hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200 flex items-center justify-center transition-all duration-300 shadow-sm cursor-pointer"
                                    aria-label="Copy article link">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Direct Consultation CTA Card -->
                        <div class="bg-[#0b0f17] rounded-2xl p-6 text-white text-center space-y-4 shadow-xl">
                            <div
                                class="w-10 h-10 rounded-full bg-[#f95716]/20 text-[#f95716] flex items-center justify-center mx-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                            </div>
                            <h4 class="font-heading font-black uppercase text-base sm:text-lg m-0">
                                {{ get_content('article_detail', 'sidebar', 'cta_title', 'Planning A Similar Project?') }}
                            </h4>
                            <p class="text-xs text-slate-300 m-0">
                                {{ get_content('article_detail', 'sidebar', 'cta_description', 'Connect with our structural engineers to review calculations, blueprints, and constructability.') }}
                            </p>
                            <a href="{{ get_content('article_detail', 'sidebar', 'cta_btn_url', route('home') . '#footer') }}"
                                class="w-full inline-flex items-center justify-center px-4 py-3 bg-[#f95716] hover:bg-[#ea4907] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition-colors">
                                {{ get_content('article_detail', 'sidebar', 'cta_btn_text', 'Inquire With Engineering Team') }}
                            </a>
                        </div>

                    </div>

                </aside>

            </div>

        </div>
    </section>

    <!-- 4. Related Articles Showcase -->
    @if(isset($relatedArticles) && $relatedArticles->count() > 0)
        <section id="article-related" class="py-20 bg-[#f8f7f4] border-t border-slate-200">
            <div class="container-fluid max-w-[1240px] mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div>
                        <span class="text-[#f95716] font-mono text-xs uppercase tracking-widest font-semibold block mb-2">
                            {{ get_content('article_detail', 'related', 'badge', 'Related Research') }}
                        </span>
                        <h2 class="text-2xl sm:text-3xl font-heading font-black tracking-tight text-slate-900 uppercase m-0">
                            {{ get_content('article_detail', 'related', 'title', 'More Engineering Dispatches') }}
                        </h2>
                    </div>
                    <a href="{{ route('public.articles.index') }}"
                        class="mt-4 md:mt-0 text-xs sm:text-sm font-mono uppercase tracking-wider text-[#f95716] hover:text-[#ea4907] font-semibold inline-flex items-center gap-1.5">
                        <span>{{ get_content('article_detail', 'related', 'view_all_text', 'View All Articles') }}</span>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedArticles as $rel)
                        <article
                            class="related-article-card group bg-white rounded-2xl overflow-hidden border border-slate-200/80 hover:border-[#f95716]/40 transition-all duration-300 shadow-sm hover:shadow-xl flex flex-col justify-between">
                            <div>
                                <div class="aspect-[16/10] overflow-hidden bg-slate-900">
                                    <img src="{{ $rel->image_url }}" alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105"
                                        loading="lazy">
                                </div>
                                <div class="p-6">
                                    <span
                                        class="text-xs font-mono uppercase text-[#f95716] tracking-wider font-semibold block mb-2">
                                        {{ $rel->category->name ?? 'Field Report' }}
                                    </span>
                                    <h3
                                        class="text-lg font-heading font-black text-slate-950 uppercase group-hover:text-[#f95716] transition-colors leading-tight line-clamp-2 m-0 mb-3">
                                        <a href="{{ route('public.articles.show', $rel->slug) }}">
                                            {{ $rel->title }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-600 line-clamp-2 m-0">
                                        {{ $rel->summary }}
                                    </p>
                                </div>
                            </div>
                            <div
                                class="px-6 pb-6 pt-0 mt-auto border-t border-slate-100 flex items-center justify-between text-xs font-mono text-slate-400">
                                <span>{{ $rel->published_at ? $rel->published_at->format('M Y') : 'Recent' }}</span>
                                <a href="{{ route('public.articles.show', $rel->slug) }}" class="text-[#f95716] font-bold">
                                    {{ get_content('article_detail', 'related', 'read_link_text', 'Read →') }}
                                </a>
                            </div>
                        </article>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
@endsection