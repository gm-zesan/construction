@extends('themes.apex-dark.layouts.app')

@section('title', ($project->title ?? 'Project Case Study') . ' — Apex Engineering')

@section('content')
    <!-- Project Showcase Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[12vw]">
            CASE STUDY
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-6 flex items-center gap-3">
                <a href="{{ route('public.projects.index') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-wider transition-colors">
                    <i class="ri-arrow-left-line"></i>
                    <span>Return to Portfolio</span>
                </a>
                <span class="text-white/20">/</span>
                <span class="text-xs text-slate-400 font-mono">{{ $project->category ?? 'Architecture' }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-8 space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                        <span>● {{ $project->category ?? 'Landmark Structural Project' }}</span>
                    </div>
                    <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight leading-[0.95]">
                        {{ $project->title }}
                    </h1>
                    @if($project->short_description)
                        <p class="text-base sm:text-lg text-slate-300 font-light leading-relaxed max-w-3xl">
                            {{ $project->short_description }}
                        </p>
                    @endif
                </div>

                <!-- Project Quick Stats Box -->
                <div class="lg:col-span-4 bg-[#0a101d] p-6 sm:p-8 space-y-5 border border-white/10 relative">
                    <div class="wilmer-badge-sq">■</div>
                    <div class="border-b border-white/10 pb-3">
                        <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">PROJECT METRICS</span>
                        <h3 class="font-['Barlow_Condensed'] text-xl font-black uppercase text-white tracking-wide">
                            Engineering Specs
                        </h3>
                    </div>
                    
                    <div class="space-y-3.5 text-xs">
                        @if($project->client_name)
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-slate-400 uppercase tracking-wider font-mono text-[11px]">Developer</span>
                                <span class="font-bold text-white text-right">{{ $project->client_name }}</span>
                            </div>
                        @endif
                        @if($project->location)
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-slate-400 uppercase tracking-wider font-mono text-[11px]">Location</span>
                                <span class="font-bold text-white text-right">{{ $project->location }}</span>
                            </div>
                        @endif
                        @if($project->completion_date)
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-slate-400 uppercase tracking-wider font-mono text-[11px]">Handover</span>
                                <span class="font-bold text-[#DFFE40] text-right">{{ $project->completion_date->format('F Y') }}</span>
                            </div>
                        @endif
                        @if($project->total_floors)
                            <div class="flex justify-between items-center py-1.5 border-b border-white/5">
                                <span class="text-slate-400 uppercase tracking-wider font-mono text-[11px]">Vertical Scope</span>
                                <span class="font-bold text-white text-right">{{ $project->total_floors }} Levels</span>
                            </div>
                        @endif
                        <div class="flex justify-between items-center py-1.5">
                            <span class="text-slate-400 uppercase tracking-wider font-mono text-[11px]">Status</span>
                            <span class="inline-flex items-center gap-1.5 px-2 py-0.5 bg-emerald-500/10 text-emerald-400 text-[10px] font-bold uppercase tracking-wider border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Delivered & Verified
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Narrative & Content -->
    <section class="py-24 bg-[#080d1a] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <!-- Left: Full Image & Narrative -->
                <div class="lg:col-span-8 space-y-12">
                    <!-- High-Res Main Hero Image with Wilmer Badge -->
                    <div class="relative overflow-hidden border border-white/10 shadow-2xl group">
                        <div class="wilmer-badge-sq">■</div>
                        <img src="{{ $project->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                             alt="{{ $project->title }}" 
                             class="w-full max-h-[540px] object-cover filter contrast-105 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-[#080d1a] via-[#080d1a]/40 to-transparent p-6 flex items-end justify-between">
                            <span class="text-xs font-mono text-slate-300 tracking-wider">CIVIL ARCHITECTURE SPECIFICATION</span>
                            <span class="text-xs font-mono text-[#DFFE40] uppercase font-bold">FIG 01. EXECUTION VIEW</span>
                        </div>
                    </div>

                    <!-- Architectural Highlights Quote -->
                    <div class="bg-[#0e172a] border-l-4 border-[#DFFE40] p-8 relative">
                        <i class="ri-double-quotes-l text-4xl text-[#DFFE40]/20 absolute top-4 right-4"></i>
                        <p class="font-['Barlow_Condensed'] text-2xl sm:text-3xl font-bold uppercase text-white leading-tight">
                            "Precision engineering is the intersection where computational structural analysis meets enduring architectural form."
                        </p>
                        <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-wider block mt-3">— Lead Consulting Engineer & Project Directorate</span>
                    </div>

                    <!-- Narrative Body -->
                    <div class="space-y-6 text-slate-300 text-base sm:text-lg leading-relaxed font-light prose prose-invert max-w-none">
                        {!! $project->description !!}
                    </div>

                    <!-- Project Milestones Timeline if available -->
                    @if(isset($project->milestones) && $project->milestones->count() > 0)
                        <div class="pt-10 border-t border-white/10">
                            <div class="mb-8">
                                <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">PROJECT LIFECYCLE</span>
                                <h3 class="font-['Barlow_Condensed'] text-3xl font-black uppercase text-white tracking-wide">
                                    Execution Milestones & Delivery Phases
                                </h3>
                            </div>
                            
                            <div class="space-y-4">
                                @foreach($project->milestones as $milestone)
                                    <div class="p-6 bg-[#0a101d] border border-white/5 flex items-start gap-5 hover:border-[#DFFE40]/40 transition-all">
                                        <div class="w-12 h-12 bg-[#DFFE40] text-slate-950 font-black flex items-center justify-center font-['Barlow_Condensed'] font-black text-xl shrink-0 shadow-lg shadow-[#DFFE40]/20">
                                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                        </div>
                                        <div class="flex-1">
                                            <div class="flex flex-wrap items-center justify-between gap-2">
                                                <h4 class="font-['Barlow_Condensed'] font-bold text-white text-xl uppercase tracking-wide">{{ $milestone->title }}</h4>
                                                @if($milestone->target_date)
                                                    <span class="text-xs font-mono text-[#DFFE40] font-bold px-2 py-0.5 bg-[#DFFE40]/10 border border-[#DFFE40]/30">{{ $milestone->target_date->format('M Y') }}</span>
                                                @endif
                                            </div>
                                            <p class="text-xs text-slate-400 mt-2 leading-relaxed font-light">{{ $milestone->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Right: Consultation Card -->
                <div class="lg:col-span-4 space-y-8">
                    <div class="bg-[#0a101d] p-8 space-y-6 border border-white/10 relative sticky top-28">
                        <div class="wilmer-badge-sq">■</div>
                        <div class="w-14 h-14 bg-[#DFFE40]/10 border border-[#DFFE40]/30 text-[#DFFE40] flex items-center justify-center text-3xl">
                            <i class="ri-compasses-2-line"></i>
                        </div>
                        <div>
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">EXECUTIVE CONSULTATION</span>
                            <h3 class="font-['Barlow_Condensed'] text-2xl font-black uppercase text-white tracking-wide mt-1">
                                Planning a Similar Build?
                            </h3>
                        </div>
                        <p class="text-xs text-slate-400 leading-relaxed font-light">
                            Our licensed structural engineering consortium offers confidential architectural audits, parametric feasibility, and turnkey construction management.
                        </p>
                        <a href="{{ route('contact', ['project_id' => $project->id]) }}" class="w-full py-4 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-['Barlow_Condensed'] font-black text-sm uppercase tracking-widest text-center flex items-center justify-center gap-2 transition-all duration-300 shadow-xl shadow-[#DFFE40]/20">
                            <span>Request Technical Briefing</span>
                            <i class="ri-arrow-right-line"></i>
                        </a>
                        
                        <div class="pt-4 border-t border-white/10 space-y-2 text-xs text-slate-400">
                            <div class="flex items-center gap-2">
                                <i class="ri-shield-check-line text-[#DFFE40]"></i>
                                <span>ISO 9001:2015 & LEED Platinum Certified</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="ri-time-line text-[#DFFE40]"></i>
                                <span>24-Hour Executive Turnaround</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Projects -->
    @if(isset($relatedProjects) && $relatedProjects->count() > 0)
        <section class="py-24 bg-[#050912] border-t border-white/5 relative overflow-hidden">
            <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[10vw]">
                RELATED
            </div>
            
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">PORTFOLIO</span>
                        <h2 class="font-['Barlow_Condensed'] text-3xl sm:text-4xl font-black uppercase text-white tracking-wide mt-1">
                            Related Landmark Builds
                        </h2>
                    </div>
                    <a href="{{ route('public.projects.index') }}" class="text-xs font-['Barlow_Condensed'] font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-widest flex items-center gap-1">
                        <span>View Entire Portfolio</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedProjects as $rel)
                        <div class="wilmer-card group">
                            <div class="relative h-64 overflow-hidden bg-slate-900">
                                <div class="wilmer-badge-sq">■</div>
                                <img src="{{ $rel->featured_image_url ?: asset('images/project-commercial-tower.jpg') }}" 
                                     alt="{{ $rel->title }}" 
                                     class="w-full h-full object-cover filter contrast-105 group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#080d1a] via-transparent to-transparent"></div>
                                <div class="absolute bottom-3 left-4">
                                    <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest font-bold bg-[#080d1a]/90 px-2 py-0.5">{{ $rel->category }}</span>
                                </div>
                            </div>
                            <div class="p-6 space-y-2 bg-[#0a101d] border border-t-0 border-white/10">
                                <h3 class="font-['Barlow_Condensed'] text-xl font-bold text-white uppercase tracking-wide group-hover:text-[#DFFE40] transition-colors line-clamp-1">
                                    <a href="{{ route('public.projects.show', $rel->slug) }}">{{ $rel->title }}</a>
                                </h3>
                                <p class="text-xs text-slate-400 font-light line-clamp-2">{{ $rel->short_description }}</p>
                                <div class="pt-3 border-t border-white/5 flex justify-between items-center">
                                    <a href="{{ route('public.projects.show', $rel->slug) }}" class="text-xs font-['Barlow_Condensed'] font-bold text-white uppercase tracking-widest group-hover:text-[#DFFE40] flex items-center gap-1">
                                        <span>Case Study</span>
                                        <i class="ri-arrow-right-line text-[#DFFE40]"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
