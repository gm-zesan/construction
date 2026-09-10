@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Project Showcase Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="absolute inset-0 z-0">
            <img src="{{ $project->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                 alt="{{ $project->title }}" 
                 class="w-full h-full object-cover opacity-20 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-[#070a12] via-[#070a12]/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-4">
                <a href="{{ route('public.projects.index') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                    <span>← Return to Portfolio</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-8 space-y-4">
                    <span class="px-3.5 py-1.5 rounded-full bg-amber-400/10 text-amber-400 border border-amber-500/20 text-xs font-bold uppercase tracking-widest inline-block">
                        {{ $project->category ?? 'Architecture & Engineering' }}
                    </span>
                    <h1 class="font-syne text-3xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                        {{ $project->title }}
                    </h1>
                    @if($project->short_description)
                        <p class="text-base sm:text-lg text-slate-300 font-light leading-relaxed">
                            {{ $project->short_description }}
                        </p>
                    @endif
                </div>

                <!-- Project Quick Stats Box -->
                <div class="lg:col-span-4 apex-card rounded-2xl p-6 space-y-4 border border-white/10">
                    <h3 class="font-syne text-sm font-bold uppercase tracking-widest text-amber-400 pb-3 border-b border-white/10">
                        Project Telemetry
                    </h3>
                    <div class="space-y-3 text-xs">
                        @if($project->client_name)
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Client / Developer</span>
                                <span class="font-bold text-white">{{ $project->client_name }}</span>
                            </div>
                        @endif
                        @if($project->location)
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Location</span>
                                <span class="font-bold text-white">{{ $project->location }}</span>
                            </div>
                        @endif
                        @if($project->completion_date)
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Delivery Date</span>
                                <span class="font-bold text-white">{{ $project->completion_date->format('F Y') }}</span>
                            </div>
                        @endif
                        @if($project->total_floors)
                            <div class="flex justify-between items-center py-1 border-b border-white/5">
                                <span class="text-slate-400">Structural Scope</span>
                                <span class="font-bold text-white">{{ $project->total_floors }} Levels</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Narrative & Content -->
    <section class="py-24 bg-[#090d16] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Full Image & Narrative -->
                <div class="lg:col-span-8 space-y-12">
                    <!-- High-Res Main Hero Image -->
                    <div class="rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                        <img src="{{ $project->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                             alt="{{ $project->title }}" 
                             class="w-full max-h-[500px] object-cover">
                    </div>

                    <!-- Narrative Body -->
                    <div class="space-y-6 text-slate-300 text-base sm:text-lg leading-relaxed font-light prose prose-invert max-w-none">
                        {!! $project->description !!}
                    </div>

                    <!-- Project Milestones Timeline if available -->
                    @if(isset($project->milestones) && $project->milestones->count() > 0)
                        <div class="pt-8 border-t border-white/10">
                            <h3 class="font-syne text-2xl font-bold text-white mb-8">
                                Execution Milestones & Delivery Phases
                            </h3>
                            <div class="space-y-6">
                                @foreach($project->milestones as $milestone)
                                    <div class="p-6 rounded-2xl bg-white/[0.02] border border-white/5 flex items-start gap-4">
                                        <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-sm shrink-0">
                                            {{ $loop->iteration }}
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-3">
                                                <h4 class="font-syne font-bold text-white text-base">{{ $milestone->title }}</h4>
                                                @if($milestone->target_date)
                                                    <span class="text-xs text-amber-400 font-semibold">{{ $milestone->target_date->format('M Y') }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-400 mt-1 leading-relaxed">{{ $milestone->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Consultation Card -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="apex-card rounded-2xl p-8 space-y-6 border border-white/10 sticky top-28">
                        <div class="w-12 h-12 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center text-2xl">
                            <i class="ri-compasses-2-line"></i>
                        </div>
                        <h3 class="font-syne text-xl font-bold text-white">
                            Planning a Similar Project?
                        </h3>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">
                            Our lead structural engineering consortium offers confidential architectural audits and feasibility assessments for landmark builds.
                        </p>
                        <a href="{{ route('contact', ['project_id' => $project->id]) }}" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-syne font-bold text-xs uppercase tracking-wider text-center block hover:from-amber-300 hover:to-amber-400 transition-all duration-300 shadow-xl shadow-amber-500/20">
                            Request Technical Briefing →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Projects -->
    @if(isset($relatedProjects) && $relatedProjects->count() > 0)
        <section class="py-20 bg-[#070a12] border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-12">
                    <h2 class="font-syne text-2xl sm:text-3xl font-bold text-white">
                        Related Landmark Builds
                    </h2>
                    <a href="{{ route('public.projects.index') }}" class="text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                        View All Projects →
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedProjects as $rel)
                        <div class="apex-card rounded-2xl overflow-hidden group">
                            <div class="relative h-60 overflow-hidden bg-slate-900">
                                <img src="{{ $rel->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                                     alt="{{ $rel->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-6 space-y-2">
                                <span class="text-xs text-amber-400 font-bold uppercase tracking-wider block">{{ $rel->category }}</span>
                                <h3 class="font-syne text-base font-bold text-white group-hover:text-amber-400 transition-colors line-clamp-1">
                                    <a href="{{ route('public.projects.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h3>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
