@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Projects Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        {{ get_content('projects', 'hero', 'badge', 'Landmark Portfolio') }}
                    </div>
                    <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                        {!! get_content('projects', 'hero', 'title', 'Masterpieces of <span class="apex-gradient-text">Structural Engineering</span>.') !!}
                    </h1>
                </div>
                <p class="text-slate-300 text-base max-w-md font-light leading-relaxed">
                    {{ get_content('projects', 'hero', 'subtitle', 'Explore our signature portfolio of commercial towers, civic superstructures, and industrial facilities delivered with zero deviance.') }}
                </p>
            </div>

            <!-- Category Filter Pills -->
            @if(isset($categories) && count($categories) > 0)
                <div class="flex flex-wrap items-center gap-2 pt-12">
                    <a href="{{ route('public.projects.index') }}" 
                       class="px-5 py-2.5 rounded-xl font-syne font-bold text-xs uppercase tracking-wider transition-all duration-300 {{ empty($selectedCategory) || strtolower($selectedCategory) === 'all' ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 border border-white/10' }}">
                        All Disciplines
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('public.projects.index', ['category' => $category]) }}" 
                           class="px-5 py-2.5 rounded-xl font-syne font-bold text-xs uppercase tracking-wider transition-all duration-300 {{ strtolower($selectedCategory ?? '') === strtolower($category) ? 'bg-amber-400 text-slate-950 shadow-lg shadow-amber-500/20' : 'bg-white/5 text-slate-300 hover:bg-white/10 border border-white/10' }}">
                            {{ $category }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <!-- Projects Grid Section -->
    <section class="py-24 bg-[#090d16] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($projects) && $projects->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <div class="apex-card rounded-2xl overflow-hidden group flex flex-col justify-between">
                            <div>
                                <!-- Image Container -->
                                <div class="relative h-72 overflow-hidden bg-slate-900">
                                    <img src="{{ $project->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                                         alt="{{ $project->title }}" 
                                         class="w-full h-full object-cover filter contrast-110 group-hover:scale-110 transition-transform duration-700">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>
                                    
                                    <!-- Badge -->
                                    <div class="absolute top-4 left-4">
                                        <span class="px-3 py-1 rounded-full bg-slate-950/80 backdrop-blur-md text-amber-400 border border-amber-500/30 text-xs font-bold uppercase tracking-wider">
                                            {{ $project->category ?? 'Architecture' }}
                                        </span>
                                    </div>
                                    
                                    @if($project->completion_date)
                                        <div class="absolute top-4 right-4">
                                            <span class="px-3 py-1 rounded-full bg-emerald-500/20 text-emerald-400 border border-emerald-500/30 text-xs font-bold">
                                                {{ $project->completion_date->format('Y') }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <!-- Text Body -->
                                <div class="p-6 space-y-3">
                                    @if($project->location)
                                        <div class="flex items-center gap-1.5 text-xs text-slate-400">
                                            <i class="ri-map-pin-line text-amber-400"></i>
                                            <span>{{ $project->location }}</span>
                                        </div>
                                    @endif

                                    <h3 class="font-syne text-xl font-bold text-white group-hover:text-amber-400 transition-colors line-clamp-1">
                                        <a href="{{ route('public.projects.show', $project->slug) }}">
                                            {{ $project->title }}
                                        </a>
                                    </h3>

                                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed font-light">
                                        {{ $project->short_description ?? Str::limit(strip_tags($project->description), 110) }}
                                    </p>
                                </div>
                            </div>

                            <!-- Card Footer -->
                            <div class="p-6 pt-0">
                                <a href="{{ route('public.projects.show', $project->slug) }}" 
                                   class="w-full py-3 rounded-xl bg-white/5 hover:bg-amber-400 hover:text-slate-950 font-syne font-bold text-xs uppercase tracking-wider text-center block transition-all duration-300">
                                    Inspect Case Study →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/[0.02] rounded-3xl border border-white/5">
                    <i class="ri-building-line text-4xl text-slate-600 mb-4 block"></i>
                    <h3 class="font-syne text-xl font-bold text-white mb-2">No Projects Found</h3>
                    <p class="text-slate-400 text-sm">No landmark builds match your selected criteria.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
