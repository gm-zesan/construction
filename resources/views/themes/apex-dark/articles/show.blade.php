@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Article Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 space-y-6">
            <div>
                <a href="{{ route('public.articles.index') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                    <span>← Return to Journal</span>
                </a>
            </div>

            @if($article->category)
                <span class="px-3.5 py-1.5 rounded-full bg-amber-400/10 text-amber-400 border border-amber-500/20 text-xs font-bold uppercase tracking-widest inline-block">
                    {{ $article->category->name }}
                </span>
            @endif

            <h1 class="font-syne text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                {{ $article->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-6 pt-4 border-t border-white/10 text-xs text-slate-400">
                <div class="flex items-center gap-2">
                    <i class="ri-user-3-line text-amber-400"></i>
                    <span class="text-white font-medium">{{ $article->author_name ?? 'Apex Technical Council' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-calendar-line text-amber-400"></i>
                    <span>{{ $article->published_at ? $article->published_at->format('F d, Y') : $article->created_at->format('F d, Y') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="ri-time-line text-amber-400"></i>
                    <span>{{ ceil(str_word_count(strip_tags($article->content ?? '')) / 200) }} Minute Read</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Article Body -->
    <section class="py-20 bg-[#090d16] relative">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Featured Image -->
            <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl mb-12">
                <img src="{{ $article->featured_image_url ?: asset('images/hero-project-main.jpg') }}" 
                     alt="{{ $article->title }}" 
                     class="w-full max-h-[500px] object-cover">
            </div>

            <!-- Content Area -->
            <div class="prose prose-invert prose-amber max-w-none text-slate-300 text-base sm:text-lg leading-relaxed font-light space-y-6">
                {!! $article->content !!}
            </div>

            <!-- Author & Sharing Footer -->
            <div class="mt-16 pt-8 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold font-syne text-lg">
                        {{ strtoupper(substr($article->author_name ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <span class="font-syne font-bold text-white text-sm block">{{ $article->author_name ?? 'Apex Engineering Directorate' }}</span>
                        <span class="text-xs text-slate-400">Technical Research & Engineering Division</span>
                    </div>
                </div>

                <a href="{{ route('public.articles.index') }}" class="px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-white font-syne font-bold text-xs uppercase tracking-wider border border-white/10 transition-all">
                    More Research Briefings →
                </a>
            </div>
        </div>
    </section>

    <!-- Related Articles Carousel/Grid -->
    @if(isset($recentArticles) && $recentArticles->count() > 0)
        <section class="py-20 bg-[#070a12] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-syne text-2xl font-bold text-white mb-8">
                    More Technical Publications
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($recentArticles->where('id', '!=', $article->id)->take(3) as $rel)
                        <div class="apex-card rounded-2xl p-6 space-y-3">
                            <span class="text-[10px] text-amber-400 font-bold uppercase tracking-wider block">{{ $rel->category ? $rel->category->name : 'Insights' }}</span>
                            <h3 class="font-syne text-base font-bold text-white hover:text-amber-400 transition-colors line-clamp-2">
                                <a href="{{ route('public.articles.show', $rel->slug) }}">{{ $rel->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 line-clamp-2">{{ $rel->summary ?? Str::limit(strip_tags($rel->content), 80) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
