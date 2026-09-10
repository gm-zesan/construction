@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Articles Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        {{ get_content('articles', 'hero', 'badge', 'Engineering Journal & Insights') }}
                    </div>
                    <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                        {!! get_content('articles', 'hero', 'title', 'Material Science & <span class="apex-gradient-text">Site Intelligence</span>.') !!}
                    </h1>
                </div>
                <p class="text-slate-300 text-base max-w-md font-light leading-relaxed">
                    {{ get_content('articles', 'hero', 'subtitle', 'Technical publications, computational civil research, and site methodology reports from our practicing engineering leads.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Articles Section -->
    <section class="py-24 bg-[#090d16] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Articles Stream (8 cols) -->
                <div class="lg:col-span-8 space-y-12">
                    @if(isset($articles) && $articles->count() > 0)
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                            @foreach($articles as $article)
                                <article class="apex-card rounded-2xl overflow-hidden group flex flex-col justify-between">
                                    <div>
                                        <div class="relative h-60 overflow-hidden bg-slate-900">
                                            <img src="{{ $article->featured_image_url ?: asset('images/hero-project-main.jpg') }}" 
                                                 alt="{{ $article->title }}" 
                                                 class="w-full h-full object-cover filter contrast-110 group-hover:scale-105 transition-transform duration-500">
                                            <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>
                                            
                                            @if($article->category)
                                                <div class="absolute top-4 left-4">
                                                    <span class="px-3 py-1 rounded-full bg-slate-950/80 backdrop-blur-md text-amber-400 border border-amber-500/30 text-xs font-bold uppercase tracking-wider">
                                                        {{ $article->category->name }}
                                                    </span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="p-6 space-y-3">
                                            <div class="flex items-center gap-3 text-xs text-slate-400">
                                                <span><i class="ri-calendar-line text-amber-400 me-1"></i>{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</span>
                                                <span>•</span>
                                                <span><i class="ri-time-line text-amber-400 me-1"></i>{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} min read</span>
                                            </div>

                                            <h3 class="font-syne text-lg font-bold text-white group-hover:text-amber-400 transition-colors line-clamp-2">
                                                <a href="{{ route('public.articles.show', $article->slug) }}">
                                                    {{ $article->title }}
                                                </a>
                                            </h3>

                                            <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed font-light">
                                                {{ $article->summary ?? Str::limit(strip_tags($article->content), 120) }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="p-6 pt-0">
                                        <a href="{{ route('public.articles.show', $article->slug) }}" 
                                           class="text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider inline-flex items-center gap-1">
                                            <span>Read Dossier</span>
                                            <span>→</span>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="pt-8">
                            {{ $articles->links() }}
                        </div>
                    @else
                        <div class="text-center py-20 bg-white/[0.02] rounded-3xl border border-white/5">
                            <i class="ri-newspaper-line text-4xl text-slate-600 mb-4 block"></i>
                            <h3 class="font-syne text-xl font-bold text-white mb-2">No Articles Found</h3>
                            <p class="text-slate-400 text-sm">No engineering publications match your search filter.</p>
                        </div>
                    @endif
                </div>

                <!-- Right: Search & Categories Sidebar (4 cols) -->
                <div class="lg:col-span-4 space-y-8">
                    <!-- Search Widget -->
                    <div class="apex-card rounded-2xl p-6 border border-white/10 space-y-4">
                        <h4 class="font-syne text-sm font-bold text-white uppercase tracking-widest text-amber-400">Search Archives</h4>
                        <form action="{{ route('public.articles.index') }}" method="GET" class="relative">
                            <input type="text" name="search" value="{{ $searchQuery ?? '' }}" 
                                   placeholder="Search engineering papers..." 
                                   class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">
                            <button type="submit" class="absolute right-3 top-2.5 text-slate-400 hover:text-amber-400">
                                <i class="ri-search-line text-lg"></i>
                            </button>
                        </form>
                    </div>

                    <!-- Category List -->
                    @if(isset($categories) && $categories->count() > 0)
                        <div class="apex-card rounded-2xl p-6 border border-white/10 space-y-4">
                            <h4 class="font-syne text-sm font-bold text-white uppercase tracking-widest text-amber-400">Research Domains</h4>
                            <div class="space-y-2">
                                <a href="{{ route('public.articles.index') }}" 
                                   class="flex items-center justify-between py-2 text-xs {{ empty($selectedCategorySlug) ? 'text-amber-400 font-bold' : 'text-slate-300 hover:text-white' }} border-b border-white/5">
                                    <span>All Domains</span>
                                    <span class="text-slate-500">→</span>
                                </a>
                                @foreach($categories as $cat)
                                    <a href="{{ route('public.articles.index', ['category' => $cat->slug]) }}" 
                                       class="flex items-center justify-between py-2 text-xs {{ ($selectedCategorySlug ?? '') === $cat->slug ? 'text-amber-400 font-bold' : 'text-slate-300 hover:text-white' }} border-b border-white/5">
                                        <span>{{ $cat->name }}</span>
                                        <span class="px-2 py-0.5 rounded-full bg-white/5 text-[10px] text-slate-400">{{ $cat->articles_count ?? 0 }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Recent Highlights -->
                    @if(isset($recentArticles) && $recentArticles->count() > 0)
                        <div class="apex-card rounded-2xl p-6 border border-white/10 space-y-4">
                            <h4 class="font-syne text-sm font-bold text-white uppercase tracking-widest text-amber-400">Recent Briefings</h4>
                            <div class="space-y-4">
                                @foreach($recentArticles->take(4) as $recent)
                                    <div class="space-y-1 pb-3 border-b border-white/5 last:border-0 last:pb-0">
                                        <span class="text-[10px] text-amber-400 font-semibold uppercase tracking-wider block">{{ $recent->created_at->format('M d, Y') }}</span>
                                        <a href="{{ route('public.articles.show', $recent->slug) }}" class="font-syne text-xs font-bold text-white hover:text-amber-400 transition-colors line-clamp-2">
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
