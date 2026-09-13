@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Projects Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#080e1a] border-b border-white/[0.06]">
        <div class="wilmer-watermark">PORTFOLIO</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                        {{ get_content('projects', 'hero', 'badge', 'LANDMARK PORTFOLIO') }}
                    </span>
                </div>
                <h1 class="font-barlow font-black text-4xl sm:text-6xl text-white uppercase tracking-wider leading-none">
                    {!! get_content('projects', 'hero', 'title', 'LANDMARK <span class="text-[#DFFE40]">SUPERSTRUCTURES.</span>') !!}
                </h1>
                <p class="text-slate-300 text-base sm:text-lg font-light leading-relaxed">
                    {{ get_content('projects', 'hero', 'subtitle', 'Explore our signature portfolio of commercial towers, civic superstructures, and industrial facilities delivered with zero deviance.') }}
                </p>
            </div>

            <!-- Category Filter Pills -->
            @if(isset($categories) && count($categories) > 0)
                <div class="flex flex-wrap items-center gap-2 pt-10 font-barlow font-bold text-xs tracking-wider uppercase">
                    <a href="{{ route('public.projects.index') }}" 
                       class="px-6 py-3 transition-all {{ empty($selectedCategory) || strtolower($selectedCategory) === 'all' ? 'bg-[#DFFE40] text-slate-950 font-black' : 'bg-[#0e172a] text-slate-300 hover:text-white hover:bg-[#131f38] border border-white/10' }}">
                        ALL DISCIPLINES
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('public.projects.index', ['category' => $category]) }}" 
                           class="px-6 py-3 transition-all {{ strtolower($selectedCategory ?? '') === strtolower($category) ? 'bg-[#DFFE40] text-slate-950 font-black' : 'bg-[#0e172a] text-slate-300 hover:text-white hover:bg-[#131f38] border border-white/10' }}">
                            {{ strtoupper($category) }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Projects Grid Section -->
    <section class="py-20 bg-[#050912]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($projects) && $projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <div class="wilmer-card group overflow-hidden">
                            <div class="wilmer-badge-sq">■</div>
                            <div class="relative h-64 sm:h-72 overflow-hidden">
                                <img src="{{ $project->featured_image ?: ($project->featured_image_url ?: asset('images/project-commercial-tower.jpg')) }}" 
                                     alt="{{ $project->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 filter contrast-110">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#080e1a] via-transparent to-transparent opacity-80"></div>
                            </div>
                            <div class="p-6 space-y-3">
                                <span class="text-xs font-barlow font-bold tracking-widest text-[#DFFE40] uppercase block">
                                    {{ $project->category ?? 'Commercial Superstructure' }}
                                </span>
                                <h3 class="font-barlow font-black text-xl sm:text-2xl text-white uppercase tracking-wide group-hover:text-[#DFFE40] transition-colors line-clamp-1">
                                    <a href="{{ route('public.projects.show', $project->slug) }}">{{ $project->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-400 font-light line-clamp-2">
                                    {{ $project->short_description ?? Str::limit(strip_tags($project->description), 110) }}
                                </p>
                                <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                                    <a href="{{ route('public.projects.show', $project->slug) }}" class="text-xs font-barlow font-bold text-[#DFFE40] hover:text-white uppercase tracking-wider flex items-center gap-1.5">
                                        <span>VIEW PROJECT</span>
                                        <i class="ri-arrow-right-line"></i>
                                    </a>
                                    <span class="text-[11px] font-mono text-slate-500">{{ $project->location ?? 'Site' }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-[#0e172a] border border-white/10">
                    <i class="ri-building-line text-4xl text-slate-600 mb-4 block"></i>
                    <h3 class="font-barlow font-black text-2xl text-white uppercase">No Projects Found</h3>
                    <p class="text-slate-400 text-sm">No landmark builds match your selected filter.</p>
                </div>
            @endif
        </div>
    </section>
@endsection

