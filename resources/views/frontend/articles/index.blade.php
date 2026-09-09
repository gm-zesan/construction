@extends('layouts.app')

@section('content')
    <!-- 1. Editorial Hero & Featured Blogs Slider Section -->
    <section id="blog-hero-slider"
        class="relative pt-28 pb-12 lg:pt-36 lg:pb-16 bg-[#080c14] text-white overflow-hidden border-b border-white/10">

        <!-- Blueprint Grid Motif Background -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden opacity-30">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
            <div class="absolute top-1/4 -right-40 w-96 h-96 rounded-full bg-[#f95716]/10 blur-3xl pointer-events-none"></div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Hero Section Header -->
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-8 lg:mb-10">
                <div>
                    <div class="blog-hero-fade inline-flex items-center gap-2.5 mb-2.5">
                        <span class="w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.25em] text-[#f95716]">
                            {{ get_content('articles', 'hero', 'badge', 'TECHNICAL JOURNAL & SITE DISPATCHES') }}
                        </span>
                    </div>
                    <h1 class="blog-hero-fade font-heading font-black uppercase text-white tracking-tight leading-tight text-3xl sm:text-4xl lg:text-5xl m-0">
                        {!! get_content('articles', 'hero', 'title', 'Featured <span class="font-sketch font-bold text-[#f95716] normal-case text-[1.1em] tracking-normal inline-block transform -rotate-1">Dispatches</span> &amp; Insights') !!}
                    </h1>
                </div>

                <!-- Swiper Navigation Arrows -->
                @if(isset($featuredArticles) && $featuredArticles->count() > 1)
                    <div class="blog-hero-fade flex items-center gap-3">
                        <button type="button" id="featured-slider-prev"
                            class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#f95716] text-white flex items-center justify-center transition-all duration-300 border border-white/15 cursor-pointer"
                            aria-label="Previous Featured Slide">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button type="button" id="featured-slider-next"
                            class="w-11 h-11 rounded-full bg-white/10 hover:bg-[#f95716] text-white flex items-center justify-center transition-all duration-300 border border-white/15 cursor-pointer"
                            aria-label="Next Featured Slide">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                @endif
            </div>

            <!-- Featured Blogs Swiper Container -->
            @if(isset($featuredArticles) && $featuredArticles->count() > 0)
                <div class="swiper featured-blog-swiper rounded-3xl overflow-hidden shadow-2xl border border-white/15 bg-[#101622]">
                    <div class="swiper-wrapper">
                        @foreach($featuredArticles as $fArticle)
                            <div class="swiper-slide">
                                <div class="grid grid-cols-1 lg:grid-cols-12 items-center min-h-[440px] lg:min-h-[480px]">

                                    <!-- Slide Left / Image Plate (7 Cols) -->
                                    <div class="lg:col-span-7 relative aspect-[16/10] sm:aspect-[16/9] lg:aspect-auto h-full min-h-[320px] lg:min-h-[480px] overflow-hidden bg-slate-900 group">
                                        <img src="{{ $fArticle->image_url }}" alt="{{ $fArticle->title }}"
                                            class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                            loading="lazy" />
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                                        <!-- Top Pill -->
                                        <div class="absolute top-6 left-6 flex items-center gap-3 z-10">
                                            @if($fArticle->category)
                                                <span class="inline-flex items-center px-3.5 py-1 text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] rounded-full shadow-md">
                                                    {{ $fArticle->category->name }}
                                                </span>
                                            @endif
                                            <span class="font-mono text-xs font-semibold text-white/90 bg-black/60 backdrop-blur-md px-3 py-1 rounded-md border border-white/15">
                                                {{ get_content('articles', 'featured', 'pill_text', 'FEATURED') }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Slide Right / Text Content (5 Cols) -->
                                    <div class="lg:col-span-5 p-8 sm:p-10 lg:p-12 flex flex-col justify-between h-full space-y-6">
                                        <div>
                                            <!-- Date & Read Time -->
                                            <div class="flex items-center gap-3 text-xs font-mono text-slate-400 mb-4 uppercase tracking-wider">
                                                @if($fArticle->published_at)
                                                    <span>{{ $fArticle->published_at->format('M d, Y') }}</span>
                                                @endif
                                                @if($fArticle->read_time)
                                                    <span>·</span>
                                                    <span>{{ $fArticle->read_time }} {{ get_content('articles', 'featured', 'read_time_suffix', 'MIN READ') }}</span>
                                                @endif
                                                @if($fArticle->author_name)
                                                    <span>·</span>
                                                    <span class="text-slate-300 font-semibold">{{ $fArticle->author_name }}</span>
                                                @endif
                                            </div>

                                            <!-- Headline -->
                                            <h2 class="font-heading font-black uppercase text-white hover:text-[#f95716] text-2xl sm:text-3xl lg:text-3xl xl:text-4xl tracking-tight leading-tight transition-colors duration-300 m-0 mb-4 line-clamp-3">
                                                <a href="{{ route('public.articles.show', $fArticle->slug) }}">
                                                    {{ $fArticle->title }}
                                                </a>
                                            </h2>

                                            <!-- Excerpt -->
                                            <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed m-0 line-clamp-3">
                                                {{ $fArticle->summary ?? 'Comprehensive engineering assessment of high-tolerance structural milestones, telemetry data, and site quality compliance.' }}
                                            </p>
                                        </div>

                                        <!-- Action Link -->
                                        <div class="pt-4 border-t border-white/10 flex items-center justify-between">
                                            <a href="{{ route('public.articles.show', $fArticle->slug) }}"
                                                class="inline-flex items-center gap-3 px-6 py-3.5 rounded-sm bg-[#f95716] hover:bg-[#ea4907] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-lg shadow-[#f95716]/25 hover:scale-[1.02]">
                                                <span>{{ get_content('articles', 'featured', 'btn_text', 'Read Full Article') }}</span>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                                </svg>
                                            </a>

                                            <span class="font-mono text-xs text-slate-400">
                                                {{ $fArticle->views_count ?? 0 }} Views
                                            </span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Swiper Pagination -->
                    <div class="swiper-pagination featured-blog-pagination pb-3"></div>
                </div>
            @endif

        </div>
    </section>

    <!-- 2. Main 2-Column Blog Layout (Left: All Blogs | Right: Sidebar with Search, Categories, Recent) -->
    <section id="blog-main-content" class="py-16 sm:py-20 lg:py-24 bg-[#ffffff] text-slate-900 border-t border-slate-200">
        <div class="container-fluid max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 xl:gap-16 items-start">

                <!-- LEFT SIDE (8 Cols): All Blogs List -->
                <div class="lg:col-span-8 space-y-10">

                    <!-- Filter Status Bar -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-200">
                        <div>
                            <span class="text-xs font-mono uppercase tracking-widest text-[#f95716] font-bold block mb-1">
                                {{ get_content('articles', 'archive', 'eyebrow', 'Articles Archive') }}
                            </span>
                            <h2 class="font-heading font-black uppercase text-slate-950 text-2xl sm:text-3xl tracking-tight m-0">
                                @if(!empty($selectedCategorySlug) && $selectedCategorySlug !== 'all')
                                    Category: <span class="text-[#f95716]">{{ $categories->firstWhere('slug', $selectedCategorySlug)->name ?? $selectedCategorySlug }}</span>
                                @elseif(!empty($searchQuery))
                                    Search: <span class="text-[#f95716]">"{{ $searchQuery }}"</span>
                                @else
                                    {{ get_content('articles', 'archive', 'title', 'All Published Dispatches') }}
                                @endif
                            </h2>
                        </div>

                        <!-- Active Filter Reset Button -->
                        @if(!empty($selectedCategorySlug) || !empty($searchQuery))
                            <a href="{{ route('public.articles.index') }}"
                                class="inline-flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-slate-500 hover:text-[#f95716] transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                <span>{{ get_content('articles', 'archive', 'reset_text', 'Reset Filter') }}</span>
                            </a>
                        @else
                            <span class="text-xs font-mono text-slate-500">
                                Showing {{ $articles->total() }} Articles
                            </span>
                        @endif
                    </div>

                    <!-- Articles Listing Grid / Cards -->
                    <div id="blog-articles-grid" class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        @forelse($articles as $index => $article)
                            <article
                                class="blog-article-card group bg-[#f8f7f4] rounded-2xl overflow-hidden border border-slate-200/80 hover:border-[#f95716]/40 transition-all duration-300 flex flex-col justify-between shadow-sm hover:shadow-xl h-full">

                                <div>
                                    <!-- Image Plate -->
                                    <div class="relative aspect-[16/10.5] overflow-hidden bg-slate-900">
                                        <img src="{{ $article->image_url }}" alt="{{ $article->title }}"
                                            class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                            loading="lazy" />

                                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                                        <!-- Category Pill -->
                                        <div class="absolute top-4 left-4 z-10">
                                            <span class="inline-flex items-center px-3 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                                {{ $article->category->name ?? 'Field Report' }}
                                            </span>
                                        </div>

                                        <!-- Bottom Date & Read Time -->
                                        <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-xs font-mono text-slate-200 z-10">
                                            @if($article->published_at)
                                                <span>{{ $article->published_at->format('M d, Y') }}</span>
                                            @endif
                                            @if($article->read_time)
                                                <span>{{ $article->read_time }} {{ get_content('articles', 'archive', 'read_time_suffix', 'MIN READ') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Content Body -->
                                    <div class="p-6">
                                        @if($article->author_name)
                                            <div class="text-xs font-bold uppercase tracking-[0.16em] text-[#f95716] mb-2">
                                                {{ $article->author_name }}
                                            </div>
                                        @endif

                                        <h3 class="font-heading font-black uppercase text-slate-950 group-hover:text-[#f95716] text-xl tracking-tight leading-tight transition-colors duration-200 m-0 mb-3 line-clamp-2">
                                            <a href="{{ route('public.articles.show', $article->slug) }}">
                                                {{ $article->title }}
                                            </a>
                                        </h3>

                                        <p class="text-slate-600 text-sm font-normal leading-relaxed m-0 line-clamp-3">
                                            {{ $article->summary ?? 'Technical field documentation detailing project planning, materials engineering, and structural milestone validations.' }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Footer Link -->
                                <div class="px-6 pb-6 pt-0 mt-auto border-t border-slate-200/60 flex items-center justify-between">
                                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-slate-900 transition-colors">
                                        {{ get_content('articles', 'archive', 'read_more_text', 'Read Dispatch') }}
                                    </span>

                                    <a href="{{ route('public.articles.show', $article->slug) }}"
                                        class="w-9 h-9 rounded-full bg-slate-200/80 group-hover:bg-[#f95716] text-slate-900 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm"
                                        aria-label="Read {{ $article->title }}">
                                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7V17" />
                                        </svg>
                                    </a>
                                </div>

                            </article>
                        @empty
                            <div class="col-span-full py-16 text-center text-slate-500 bg-[#f8f7f4] rounded-2xl border border-slate-200 p-8">
                                <svg class="w-12 h-12 mx-auto text-slate-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                                <p class="text-lg font-medium text-slate-700">
                                    {{ get_content('articles', 'archive', 'no_results_text', 'No published articles match your criteria.') }}
                                </p>
                                <a href="{{ route('public.articles.index') }}" class="mt-3 inline-block text-sm font-bold text-[#f95716] uppercase tracking-wider hover:underline">
                                    ← {{ get_content('articles', 'archive', 'view_all_text', 'View All Dispatches') }}
                                </a>
                            </div>
                        @endforelse
                    </div>

                    <!-- Pagination -->
                    @if($articles->hasPages())
                        <div class="pt-8 border-t border-slate-200">
                            {{ $articles->links() }}
                        </div>
                    @endif

                </div>

                <!-- RIGHT SIDE (4 Cols): Sidebar (Search, Category List, Recent Blogs) -->
                <aside id="blog-sidebar" class="lg:col-span-4 space-y-8">

                    <!-- 1. Search Box Widget -->
                    <div class="sidebar-widget bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm">
                        <h3 class="text-xs font-mono uppercase tracking-widest text-slate-900 font-bold border-b border-slate-200 pb-3 mb-4">
                            {{ get_content('articles', 'sidebar', 'search_title', 'Search Articles') }}
                        </h3>

                        <form action="{{ route('public.articles.index') }}" method="GET" class="relative">
                            @if(!empty($selectedCategorySlug) && $selectedCategorySlug !== 'all')
                                <input type="hidden" name="category" value="{{ $selectedCategorySlug }}">
                            @endif
                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}"
                                placeholder="{{ get_content('articles', 'sidebar', 'search_placeholder', 'Search keyword, topic, or author...') }}"
                                class="w-full px-4 py-3 pr-11 text-sm bg-white rounded-xl border border-slate-300 focus:border-[#f95716] focus:ring-1 focus:ring-[#f95716] text-slate-900 placeholder-slate-400 transition-colors shadow-sm outline-none" />
                            <button type="submit"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 w-8 h-8 rounded-lg bg-[#f95716] hover:bg-[#ea4907] text-white flex items-center justify-center transition-colors shadow-sm cursor-pointer"
                                aria-label="Search">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- 2. Category List Widget -->
                    <div class="sidebar-widget bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm">
                        <div class="flex items-center justify-between border-b border-slate-200 pb-3 mb-4">
                            <h3 class="text-xs font-mono uppercase tracking-widest text-slate-900 font-bold">
                                {{ get_content('articles', 'sidebar', 'categories_title', 'Categories') }}
                            </h3>
                            <span class="text-xs font-mono text-slate-400">Total ({{ $categories->sum('articles_count') }})</span>
                        </div>

                        <ul class="space-y-2 list-none p-0 m-0">
                            <li>
                                <a href="{{ route('public.articles.index') }}"
                                    class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ empty($selectedCategorySlug) || $selectedCategorySlug === 'all' ? 'bg-[#0b0f17] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/70 hover:text-[#f95716]' }}">
                                    <span class="flex items-center gap-2">
                                        <span class="w-2 h-2 rounded-full {{ empty($selectedCategorySlug) || $selectedCategorySlug === 'all' ? 'bg-[#f95716]' : 'bg-slate-400' }}"></span>
                                        <span>{{ get_content('articles', 'sidebar', 'all_categories_label', 'All Categories') }}</span>
                                    </span>
                                    <span class="text-xs font-mono {{ empty($selectedCategorySlug) || $selectedCategorySlug === 'all' ? 'text-white/80' : 'text-slate-400' }}">
                                        {{ $categories->sum('articles_count') }}
                                    </span>
                                </a>
                            </li>
                            @foreach($categories as $category)
                                @php
                                    $isActive = ($selectedCategorySlug === $category->slug);
                                @endphp
                                <li>
                                    <a href="{{ route('public.articles.index', ['category' => $category->slug]) }}"
                                        class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ $isActive ? 'bg-[#0b0f17] text-white shadow-sm' : 'text-slate-700 hover:bg-slate-200/70 hover:text-[#f95716]' }}">
                                        <span class="flex items-center gap-2">
                                            <span class="w-2 h-2 rounded-full {{ $isActive ? 'bg-[#f95716]' : 'bg-slate-400' }}"></span>
                                            <span>{{ $category->name }}</span>
                                        </span>
                                        <span class="text-xs font-mono {{ $isActive ? 'text-white/80' : 'text-slate-400' }}">
                                            {{ $category->articles_count }}
                                        </span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- 3. Recent Blogs List Widget -->
                    @if(isset($recentArticles) && $recentArticles->count() > 0)
                        <div class="sidebar-widget bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 sm:p-7 shadow-sm">
                            <h3 class="text-xs font-mono uppercase tracking-widest text-slate-900 font-bold border-b border-slate-200 pb-3 mb-5">
                                {{ get_content('articles', 'sidebar', 'recent_title', 'Recent Dispatches') }}
                            </h3>

                            <div class="space-y-4">
                                @foreach($recentArticles as $rArticle)
                                    <article class="flex items-center gap-3.5 group">
                                        <!-- Thumbnail -->
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-900 flex-shrink-0 border border-slate-200">
                                            <img src="{{ $rArticle->image_url }}" alt="{{ $rArticle->title }}"
                                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                                loading="lazy">
                                        </div>

                                        <!-- Info -->
                                        <div class="flex-1 min-w-0">
                                            <div class="text-[11px] font-mono text-slate-400 mb-0.5">
                                                {{ $rArticle->published_at ? $rArticle->published_at->format('M d, Y') : 'Recent' }}
                                            </div>
                                            <h4 class="font-heading font-bold uppercase text-slate-900 group-hover:text-[#f95716] text-xs sm:text-sm tracking-tight leading-snug transition-colors line-clamp-2 m-0">
                                                <a href="{{ route('public.articles.show', $rArticle->slug) }}">
                                                    {{ $rArticle->title }}
                                                </a>
                                            </h4>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- 4. Direct Engineering Consultation CTA Widget -->
                    <div class="sidebar-widget bg-[#0b0f17] rounded-2xl p-6 sm:p-7 text-white text-center space-y-4 shadow-xl">
                        <div class="w-12 h-12 rounded-full bg-[#f95716]/20 text-[#f95716] flex items-center justify-center mx-auto">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h4 class="font-heading font-black uppercase text-lg sm:text-xl m-0">
                            {{ get_content('articles', 'sidebar', 'cta_title', 'Require Structural Consultation?') }}
                        </h4>
                        <p class="text-xs sm:text-sm text-slate-300 m-0 leading-relaxed">
                            {{ get_content('articles', 'sidebar', 'cta_description', 'Connect directly with our civil engineering leads for blueprint reviews, material testing, and tender documentation.') }}
                        </p>
                        <a href="{{ get_content('articles', 'sidebar', 'cta_btn_url', route('home') . '#footer') }}"
                            class="w-full inline-flex items-center justify-center px-5 py-3.5 bg-[#f95716] hover:bg-[#ea4907] text-white font-bold text-xs uppercase tracking-wider rounded-lg transition-all shadow-md shadow-[#f95716]/25">
                            {{ get_content('articles', 'sidebar', 'cta_btn_text', 'Consult With Engineers') }}
                        </a>
                    </div>

                </aside>

            </div>

        </div>
    </section>
@endsection
