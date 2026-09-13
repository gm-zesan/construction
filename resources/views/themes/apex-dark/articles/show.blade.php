@extends('themes.apex-dark.layouts.app')

@section('title', ($article->title ?? 'Technical Publication') . ' — Apex Engineering Journal')

@section('content')
    <!-- Article Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[12vw]">
            INSIGHTS
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
            <div class="flex items-center gap-3">
                <a href="{{ route('public.articles.index') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-wider transition-colors">
                    <i class="ri-arrow-left-line"></i>
                    <span>Return to Journal</span>
                </a>
                <span class="text-white/20">/</span>
                <span class="text-xs text-slate-400 font-mono">{{ $article->category->name ?? 'Engineering' }}</span>
            </div>

            @if($article->category)
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                    <span>● {{ $article->category->name }}</span>
                </div>
            @endif

            <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight leading-[0.95]">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 pt-6 border-t border-white/10 text-xs font-mono text-slate-400">
                <div class="flex items-center gap-2">
                    <i class="ri-user-3-line text-[#DFFE40]"></i>
                    <span class="text-white font-bold uppercase">{{ $article->author_name ?? 'Apex Technical Council' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-calendar-line text-[#DFFE40]"></i>
                    <span>{{ $article->published_at ? $article->published_at->format('F d, Y') : $article->created_at->format('F d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-time-line text-[#DFFE40]"></i>
                    <span>{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} Minute Read</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Article Body -->
    <section class="py-24 bg-[#080d1a] relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Image with Wilmer Badge -->
            <div class="relative overflow-hidden border border-white/10 shadow-2xl mb-12 group">
                <div class="wilmer-badge-sq">■</div>
                <img src="{{ $article->featured_image_url ?: asset('images/hero-project-main.jpg') }}" 
                     alt="{{ $article->title }}" 
                     class="w-full max-h-[500px] object-cover filter contrast-105">
                <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-[#080d1a] via-[#080d1a]/40 to-transparent p-4 flex items-end justify-between">
                    <span class="text-[10px] font-mono text-slate-300">TECHNICAL DOSSIER // APEX ARCHIVE</span>
                    <span class="text-[10px] font-mono text-[#DFFE40] uppercase font-bold">VERIFIED ANALYSIS</span>
                </div>
            </div>

            <!-- Content Area -->
            <div class="prose prose-invert prose-orange max-w-none text-slate-300 text-base sm:text-lg leading-relaxed font-light space-y-6">
                {!! $article->content !!}
            </div>

            <!-- Author & Sharing Footer -->
            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6 bg-[#0a101d] p-8 border border-white/10 relative">
                <div class="wilmer-badge-sq">■</div>
                <div class="flex items-center gap-4">
                    <div class="w-14 h-14 bg-[#DFFE40] text-slate-950 font-black flex items-center justify-center font-['Barlow_Condensed'] font-black text-2xl shadow-lg shadow-[#DFFE40]/20 shrink-0">
                        {{ strtoupper(substr($article->author_name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <span class="font-['Barlow_Condensed'] text-xl font-bold uppercase tracking-wide text-white block">{{ $article->author_name ?? 'Apex Technical Council' }}</span>
                        <span class="text-xs font-mono text-slate-400">Technical Research & Engineering Division</span>
                    </div>
                </div>

                <a href="{{ route('public.articles.index') }}" class="px-6 py-3.5 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-['Barlow_Condensed'] font-black text-xs uppercase tracking-widest transition-all shadow-md shadow-[#DFFE40]/20">
                    More Research Briefings →
                </a>
            </div>
        </div>
    </section>

    <!-- Related Articles Grid -->
    @if(isset($recentArticles) && $recentArticles->count() > 0)
        <section class="py-24 bg-[#050912] border-t border-white/5 relative overflow-hidden">
            <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[10vw]">
                ARCHIVES
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">JOURNAL</span>
                        <h2 class="font-['Barlow_Condensed'] text-3xl sm:text-4xl font-black uppercase text-white tracking-wide mt-1">
                            More Technical Publications
                        </h2>
                    </div>
                    <a href="{{ route('public.articles.index') }}" class="text-xs font-['Barlow_Condensed'] font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-widest flex items-center gap-1">
                        <span>View All Publications</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentArticles->where('id', '!=', $article->id)->take(3) as $rel)
                        <div class="wilmer-card bg-[#0a101d] p-6 space-y-3 border border-white/10 group">
                            <span class="text-[10px] font-mono text-[#DFFE40] font-bold uppercase tracking-wider block">{{ $rel->category ? $rel->category->name : 'Insights' }}</span>
                            <h3 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white group-hover:text-[#DFFE40] transition-colors line-clamp-2 leading-tight">
                                <a href="{{ route('public.articles.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 font-light line-clamp-2">{{ $rel->summary ?? Str::limit(strip_tags($rel->content), 80) }}</p>
                            <div class="pt-3 border-t border-white/5">
                                <a href="{{ route('public.articles.show', $rel->slug) }}" class="text-xs font-['Barlow_Condensed'] font-bold text-white uppercase tracking-widest group-hover:text-[#DFFE40] flex items-center gap-1">
                                    <span>Read Briefing</span>
                                    <i class="ri-arrow-right-line text-[#DFFE40]"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
