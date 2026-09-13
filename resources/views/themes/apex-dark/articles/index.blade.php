@extends('themes.apex-dark.layouts.app')

@section('title', 'Engineering Journal & Technical Insights — Apex Engineering')

@section('content')
    <!-- Articles Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[13vw]">
            JOURNAL
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#DFFE40] animate-ping"></span>
                        {{ get_content('articles', 'hero', 'badge', 'TECHNICAL JOURNAL & SITE INTELLIGENCE') }}
                    </div>
                    <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight leading-[0.95]">
                        {!! get_content('articles', 'hero', 'title', 'Structural Research & <span class="text-[#DFFE40]">Civil Insights</span>.') !!}
                    </h1>
                </div>
                <p class="text-slate-300 text-sm sm:text-base max-w-md font-light leading-relaxed">
                    {{ get_content('articles', 'hero', 'subtitle', 'Technical publications, computational civil research, BIM innovations, and site methodology reports from our practicing engineering leads.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Articles Section -->
    <section class="py-24 bg-[#080d1a] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Articles Stream (8 cols) -->
                <div class="lg:col-span-8 space-y-10">
                    @if(isset($articles) && $articles->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            @foreach($articles as $article)
                                <article class="wilmer-card bg-[#0a101d] border border-white/10 flex flex-col justify-between group">
                                    <div>
                                        <div class="relative h-60 overflow-hidden bg-slate-900">
                                            <div class="wilmer-badge-sq">■</div>
                                            <img src="{{ $article->featured_image_url ?: asset('images/hero-project-main.jpg') }}" 
                                                 alt="{{ $article->title }}" 
                                                 class="w-full h-full object-cover filter contrast-105 group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a101d] via-transparent to-transparent"></div>
                                            
                                            @if($article->category)
                                                <div class="absolute bottom-3 left-4">
                                                    <span class="px-2.5 py-0.5 bg-[#DFFE40] text-slate-950 font-black font-['Barlow_Condensed'] text-xs font-bold uppercase tracking-widest shadow-md">
                                                        {{ $article->category->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-6 space-y-3">
                                            <div class="flex items-center gap-3 text-[11px] font-mono text-slate-400">
                                                <span class="text-[#DFFE40] font-bold"><i class="ri-calendar-line me-1"></i>{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                                                <span class="text-white/20">•</span>
                                                <span><i class="ri-time-line me-1"></i>{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} min read</span>
                                            </div>

                                            <h3 class="font-['Barlow_Condensed'] text-2xl font-bold uppercase tracking-wide text-white group-hover:text-[#DFFE40] transition-colors line-clamp-2 leading-tight">
                                                <a href="{{ route('public.articles.show', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>

                                            <p class="text-xs text-slate-400 line-clamp-3 leading-relaxed font-light">
                                                {{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-6 pt-0 border-t border-white/5 flex items-center justify-between">
                                        <a href="{{ route('public.articles.show', $article->slug) }}" 
                                           class="text-xs font-['Barlow_Condensed'] font-bold text-white uppercase tracking-widest group-hover:text-[#DFFE40] inline-flex items-center gap-1.5 transition-colors">
                                            <span>Read Publication</span>
                                            <i class="ri-arrow-right-line text-[#DFFE40]"></i>
                                        </a>
                                        <span class="text-[10px] font-mono text-slate-500 uppercase">{{ $article->author_name ?? 'Apex Directorate' }}</span>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pt-8">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-[#0a101d] border border-white/10 p-12">
                            <i class="ri-newspaper-line text-5xl text-[#DFFE40] mb-4 block"></i>
                            <h3 class="font-['Barlow_Condensed'] text-3xl font-black uppercase text-white tracking-wide mb-2">No Articles Found</h3>
                            <p class="text-slate-400 text-xs font-mono">No engineering publications match your search filter criteria.</p>
                        </div>
                    @endif
                </div>

                <!-- Right: Search & Categories Sidebar (4 cols) -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Search Widget -->
                    <div class="bg-[#0a101d] p-6 border border-white/10 relative space-y-4">
                        <div class="wilmer-badge-sq">■</div>
                        <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">ARCHIVES</span>
                        <h4 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white tracking-wide">Search Repository</h4>
                        <form action="{{ route('public.articles.index') }}" method="GET" class="relative">
                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}" 
                                   placeholder="Search engineering papers..." 
                                   class="w-full px-4 py-3 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">
                            <button type="submit" class="absolute right-3 top-3 text-[#DFFE40] hover:text-[#e8ff66]">
                                <i class="ri-search-line text-lg"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Category List -->
                    @if(isset($categories) && $categories->count() > 0)
                        <div class="bg-[#0a101d] p-6 border border-white/10 relative space-y-4">
                            <div class="wilmer-badge-sq">■</div>
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">DISCIPLINES</span>
                            <h4 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white tracking-wide">Research Domains</h4>
                            <div class="space-y-2">
                                <a href="{{ route('public.articles.index') }}" 
                                   class="flex items-center justify-between py-2.5 px-3 text-xs font-['Barlow_Condensed'] font-bold uppercase tracking-wider {{ empty($selectedCategorySlug) ? 'bg-[#DFFE40] text-slate-950 font-black' : 'text-slate-300 hover:text-white bg-white/[0.02] border border-white/5' }} transition-colors">
                                    <span>All Domains</span>
                                    <i class="ri-arrow-right-s-line"></i>
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}" 
                                       class="flex items-center justify-between py-2.5 px-3 text-xs font-['Barlow_Condensed'] font-bold uppercase tracking-wider {{ ($selectedCategorySlug ?? '') === $cat->slug ? 'bg-[#DFFE40] text-slate-950 font-black' : 'text-slate-300 hover:text-white bg-white/[0.02] border border-white/5' }} transition-colors">
                                        <span>{{ $cat->name }}</span>
                                        <span class="px-2 py-0.5 bg-black/40 text-[10px] font-mono text-slate-300">{{ $cat->articles_count ?? 0 }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Recent Highlights -->
                    @if(isset($recentArticles) && $recentArticles->count() > 0)
                        <div class="bg-[#0a101d] p-6 border border-white/10 relative space-y-4">
                            <div class="wilmer-badge-sq">■</div>
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">LATEST BRIEFS</span>
                            <h4 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white tracking-wide">Recent Briefings</h4>
                            <div class="space-y-4">
                                @foreach($recentArticles->take(4) as $recent)
                                    <div class="space-y-1 pb-3 border-b border-white/5 last:border-0 last:pb-0">
                                        <span class="text-[10px] font-mono text-[#DFFE40] font-bold uppercase tracking-wider block">{{ $recent->created_at->format('M d, Y') }}</span>
                                        <a href="{{ route('public.articles.show', $recent->slug) }}" class="font-['Barlow_Condensed'] text-base font-bold text-white uppercase hover:text-[#DFFE40] transition-colors line-clamp-2 leading-tight">
                                            {{ $recent->title }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
