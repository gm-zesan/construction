@extends('themes.default.layouts.app')

@section('title', ($project->title ?? 'Project Case Study') . ' | ' . get_setting('company_name', 'COMPANY NAME'))
@section('meta_description', Str::limit(strip_tags($project->short_description ?? $project->description), 160))

@section('content')
    <main class="w-full bg-[#fbfbf9] text-slate-900 overflow-hidden">

        {{-- =========================================================================
        1. PROJECT HERO / HEADER SECTION
        ========================================================================= --}}
        @php
            $mainImage = $project->getFirstMediaUrl('main_image');
            if (empty($mainImage)) {
                $mainImage = asset('images/project-commercial-tower.jpg');
            }
            $statusEnum = $project->status instanceof \App\Enums\ProjectStatus ? $project->status : \App\Enums\ProjectStatus::tryFrom($project->status);
            $statusLabel = $statusEnum ? $statusEnum->label() : ($project->status ?? 'Active');
        @endphp

        <section id="project-detail-hero"
            class="relative bg-[#080c14] text-white pt-32 sm:pt-36 lg:pt-44 pb-16 sm:pb-20 lg:pb-24 overflow-hidden border-b border-white/10">

            <!-- Background Cinematic Architectural Imagery with Dark Multi-Layer Gradient -->
            <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
                <img id="project-detail-bg-img" src="{{ $mainImage }}" alt="{{ $project->title }}"
                    class="absolute -top-[10%] left-0 w-full h-[125%] object-cover object-center opacity-30 will-change-transform scale-105"
                    loading="eager" fetchpriority="high" />
                <div class="absolute inset-0 bg-gradient-to-r from-[#080c14] via-[#080c14]/90 to-[#080c14]/70"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-black/60"></div>
                <!-- Atmospheric Architectural Blueprint Matrix Grid -->
                <div
                    class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff06_1px,transparent_1px),linear-gradient(to_bottom,#ffffff06_1px,transparent_1px)] bg-[size:4rem_4rem]">
                </div>
            </div>

            <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

                <!-- Breadcrumb Navigation -->
                <nav class="project-detail-hero-fade flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 mb-8 will-change-transform" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#f95716] transition-colors">Home</a>
                    <span class="text-white/20">/</span>
                    <a href="{{ route('public.projects.index') }}" class="hover:text-[#f95716] transition-colors">Projects</a>
                    <span class="text-white/20">/</span>
                    <span class="text-slate-200 truncate max-w-[200px] sm:max-w-xs">{{ $project->title }}</span>
                </nav>

                <div class="max-w-4xl">

                    <!-- Eyebrow & Category Strip -->
                    <div class="project-detail-hero-fade flex items-center gap-3 mb-5 will-change-transform">
                        <span class="w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            {{ $project->category ?? 'Case Study' }}
                        </span>
                        @if($project->featured)
                            <span
                                class="px-2.5 py-0.5 rounded text-[10px] font-bold uppercase tracking-wider bg-white/10 text-slate-300 border border-white/10">
                                Featured Build
                            </span>
                        @endif
                    </div>

                    <!-- Grand Main Title -->
                    <h1
                        class="project-detail-hero-fade font-heading font-black uppercase text-white tracking-tight leading-[1.02] text-3xl sm:text-5xl md:text-6xl lg:text-[68px] xl:text-[76px] m-0 mb-6 will-change-transform">
                        {{ $project->title }}
                    </h1>

                    <!-- Jump Action Buttons -->
                    <div class="project-detail-hero-fade flex flex-wrap items-center gap-4 pt-2 will-change-transform">
                        <a href="#engineering-narrative"
                            class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-xl shadow-[#f95716]/25 hover:scale-[1.02] group">
                            <span>Technical Overview</span>
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-y-0.5" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                        <a href="{{ route('public.projects.index') }}"
                            class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 border border-white/15 backdrop-blur-sm">
                            <span>All Projects</span>
                        </a>
                    </div>

                </div>

                <!-- Integrated 4-Metric Parameter Bar -->
                <div id="project-detail-stats-bar" class="mt-12 sm:mt-16 pt-8 border-t border-white/10 grid grid-cols-2 md:grid-cols-4 gap-6 sm:gap-8">
                    <div class="project-detail-stat-item space-y-1 will-change-transform">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Client / Developer</div>
                        <div class="text-sm sm:text-base font-semibold text-white truncate">
                            {{ $project->client_name ?? 'Confidential Corporate Client' }}
                        </div>
                    </div>

                    <div class="project-detail-stat-item space-y-1 will-change-transform">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Location</div>
                        <div class="text-sm sm:text-base font-semibold text-white truncate">
                            {{ $project->location ?? 'Metropolitan Sector' }}
                        </div>
                    </div>

                    <div class="project-detail-stat-item space-y-1 will-change-transform">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Execution Timeline</div>
                        <div class="text-sm sm:text-base font-semibold text-white font-mono">
                            {{ $project->start_date ? $project->start_date->format('M Y') : 'Q1 2024' }} —
                            {{ $project->completion_date ? $project->completion_date->format('M Y') : 'Delivered' }}
                        </div>
                    </div>

                    <div class="project-detail-stat-item space-y-1 will-change-transform">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Delivery Status</div>
                        <div class="text-sm sm:text-base font-semibold text-[#f95716]">
                            {{ $statusLabel }}
                        </div>
                    </div>
                </div>

            </div>

        </section>

        {{-- =========================================================================
        2. PRIMARY SITE VISUALIZATION PLATE
        ========================================================================= --}}

        <section id="project-detail-visual" class="py-12 sm:py-16 bg-[#fbfbf9] border-b border-slate-200/80">
            <div class="container-fluid max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
                <div
                    class="project-detail-plate-box relative rounded-2xl overflow-hidden shadow-xl border border-slate-200 bg-slate-900 aspect-[16/9] lg:aspect-[21/9] will-change-transform">
                    <img src="{{ $mainImage }}" alt="{{ $project->title }}" class="w-full h-full object-cover object-center"
                        loading="lazy">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent pointer-events-none">
                    </div>
                    <div
                        class="absolute bottom-5 left-5 right-5 flex items-end justify-between text-white pointer-events-none">
                        <div>
                            <div class="text-[11px] font-bold uppercase tracking-widest text-[#f95716]">Primary Site Plate
                            </div>
                            <div class="font-heading font-black uppercase text-base sm:text-xl">{{ $project->title }}</div>
                        </div>
                        @if($project->location)
                            <span
                                class="text-xs font-mono text-slate-300 hidden sm:inline-block bg-black/50 backdrop-blur-md px-3 py-1 rounded-md border border-white/10">
                                {{ $project->location }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================================
        3. ARCHITECTURAL NARRATIVE & SPECIFICATIONS
        ========================================================================= --}}

        <section id="engineering-narrative" class="py-20 lg:py-28 relative">
            {{-- Watermark --}}
            <div class="pointer-events-none select-none absolute top-20 right-0 z-0 overflow-hidden hidden lg:block">
                <span
                    class="parallax-text-back back text-slate-950 font-heading font-black uppercase text-[10vw] leading-none tracking-tighter">
                    {{ get_content('project_detail', 'narrative', 'watermark', 'ANALYSIS') }}
                </span>
            </div>

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">
                    {{-- Left: Deep Dive Prose --}}
                    <div class="lg:col-span-8 space-y-8">
                        <div class="narrative-header-fade will-change-transform">
                            <span
                                class="text-primary font-mono text-xs uppercase tracking-widest font-semibold block mb-2">
                                {{ get_content('project_detail', 'narrative', 'badge', 'Scope & Methodology') }}
                            </span>
                            <h2
                                class="text-2xl sm:text-3xl lg:text-4xl font-heading font-black tracking-tight text-slate-900 uppercase">
                                {{ get_content('project_detail', 'narrative', 'title', 'Architectural & Engineering Execution') }}
                            </h2>
                        </div>

                        <div class="narrative-body-fade prose prose-lg text-slate-600 font-light leading-relaxed max-w-none space-y-6 will-change-transform">
                            @if($project->description)
                                {!! $project->description !!}
                            @else
                                <p>
                                    {{ get_content('project_detail', 'narrative', 'default_p1', "This landmark project demonstrates ApexBuild's commitment to high-tolerance civil construction, advanced seismic engineering, and low-carbon materials integration. From initial site excavation through structural steel erection and final interior fit-out, every milestone adhered to rigorous ISO 9001 and LEED Gold benchmarks.") }}
                                </p>
                                <p>
                                    {{ get_content('project_detail', 'narrative', 'default_p2', "Our multidisciplinary project team employed Real-time BIM clash detection and 4D progress scheduling to mitigate logistical friction across dense urban operating zones. The resulting architectural footprint provides an enduring, resilient asset optimized for sustainable lifecycle performance.") }}
                                </p>
                            @endif
                        </div>

                        {{-- Technical Highlight Cards --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6">
                            <div class="tech-highlight-card p-6 rounded-xl bg-white border border-slate-200 shadow-sm will-change-transform">
                                <div
                                    class="w-10 h-10 rounded bg-primary/10 text-primary flex items-center justify-center mb-4 font-mono font-bold text-sm">
                                    {{ get_content('project_detail', 'highlights', 'card_1_num', '01') }}
                                </div>
                                <h3 class="text-lg font-heading font-bold text-slate-900 uppercase mb-2">
                                    {{ get_content('project_detail', 'highlights', 'card_1_title', 'Precision Structural Engineering') }}
                                </h3>
                                <p class="text-sm text-slate-500 font-light leading-relaxed">
                                    {{ get_content('project_detail', 'highlights', 'card_1_text', 'High-tensile reinforced concrete core with post-tensioned floor plates, engineered for zero-deflection structural performance under extreme seismic loads.') }}
                                </p>
                            </div>
                            <div class="tech-highlight-card p-6 rounded-xl bg-white border border-slate-200 shadow-sm will-change-transform">
                                <div
                                    class="w-10 h-10 rounded bg-slate-900 text-white flex items-center justify-center mb-4 font-mono font-bold text-sm">
                                    {{ get_content('project_detail', 'highlights', 'card_2_num', '02') }}
                                </div>
                                <h3 class="text-lg font-heading font-bold text-slate-900 uppercase mb-2">
                                    {{ get_content('project_detail', 'highlights', 'card_2_title', 'Sustainable Material Integrity') }}
                                </h3>
                                <p class="text-sm text-slate-500 font-light leading-relaxed">
                                    {{ get_content('project_detail', 'highlights', 'card_2_text', '35% reduction in embodied carbon achieved through geopolymer slag mixes and recycled structural steel, certified for high durability environments.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Right: Project Parameters Sidebar --}}
                    <div class="lg:col-span-4">
                        <div
                            class="tech-sidebar-card sticky top-28 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm space-y-6 will-change-transform">
                            <h3
                                class="text-base font-mono uppercase tracking-widest text-slate-900 font-bold border-b border-slate-200 pb-4">
                                {{ get_content('project_detail', 'sidebar', 'title', 'Technical Data Sheet') }}
                            </h3>

                            <dl class="divide-y divide-slate-100 text-sm">
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Project ID</dt>
                                    <dd class="font-mono font-semibold text-slate-900">
                                        PRJ-{{ str_pad($project->id, 4, '0', STR_PAD_LEFT) }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Sector</dt>
                                    <dd class="font-semibold text-slate-900">{{ $project->category ?? 'Civil Engineering' }}
                                    </dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Client Entity</dt>
                                    <dd class="font-semibold text-slate-900 text-right">
                                        {{ $project->client_name ?? 'Private Client' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Location</dt>
                                    <dd class="font-semibold text-slate-900 text-right">
                                        {{ $project->location ?? 'Corporate HQ' }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Status</dt>
                                    <dd class="font-semibold text-slate-900 capitalize">{{ $statusLabel }}</dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Start Date</dt>
                                    <dd class="font-mono text-slate-900">
                                        {{ $project->start_date ? $project->start_date->format('M d, Y') : 'Jan 15, 2024' }}
                                    </dd>
                                </div>
                                <div class="py-3 flex justify-between">
                                    <dt class="text-slate-500 font-mono text-xs uppercase">Delivery</dt>
                                    <dd class="font-mono text-slate-900">
                                        {{ $project->completion_date ? $project->completion_date->format('M d, Y') : 'In Progress' }}
                                    </dd>
                                </div>
                            </dl>

                            <div class="pt-4 border-t border-slate-200">
                                <a href="{{ get_content('project_detail', 'sidebar', 'btn_url', '#inquiry-cta') }}"
                                    class="w-full inline-flex items-center justify-center px-5 py-3 bg-slate-900 hover:bg-primary text-white font-medium text-xs uppercase tracking-widest rounded transition-colors duration-300">
                                    <span>{{ get_content('project_detail', 'sidebar', 'btn_text', 'Inquire About Similar Scope') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================================
        4. PROJECT MEDIA GALLERY
        ========================================================================= --}}

        @php
            $galleryImages = $project->getMedia('gallery');
        @endphp
        @if($galleryImages->count() > 0)
            <section id="project-detail-gallery" class="py-20 bg-slate-900 text-white relative">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="gallery-header-fade flex flex-col md:flex-row md:items-end justify-between mb-12 will-change-transform">
                        <div>
                            <span
                                class="text-primary font-mono text-xs uppercase tracking-widest font-semibold block mb-2">
                                {{ get_content('project_detail', 'gallery', 'badge', 'Field Documentation') }}
                            </span>
                            <h2
                                class="text-2xl sm:text-3xl lg:text-4xl font-heading font-black tracking-tight text-white uppercase">
                                {{ get_content('project_detail', 'gallery', 'title', 'Site & Structural Gallery') }}
                            </h2>
                        </div>
                        <p class="mt-4 md:mt-0 text-slate-400 font-mono text-xs uppercase">
                            {{ $galleryImages->count() }} Media Records Available
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($galleryImages as $media)
                            <div class="gallery-card-item relative group rounded-xl overflow-hidden bg-slate-800 border border-white/10 aspect-[4/3] will-change-transform">
                                <img src="{{ $media->getUrl() }}" alt="{{ $project->title }} - Image {{ $loop->iteration }}"
                                    class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105"
                                    loading="lazy">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end p-6">
                                    <span class="text-xs font-mono tracking-wider text-white uppercase">
                                        Record #{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }} — {{ $media->file_name }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- =========================================================================
        5. CHRONOLOGICAL CONSTRUCTION MILESTONES TIMELINE
        ========================================================================= --}}
        @if($project->milestones && $project->milestones->count() > 0)
            <section id="project-detail-milestones" class="py-20 lg:py-28 relative bg-[#fbfbf9]">
                {{-- Watermark --}}
                <div class="pointer-events-none select-none absolute top-10 left-10 z-0 overflow-hidden hidden lg:block">
                    <span
                        class="parallax-text-back back text-slate-950 font-heading font-black uppercase text-[10vw] leading-none tracking-tighter">
                        {{ get_content('project_detail', 'milestones', 'watermark', 'PHASES') }}
                    </span>
                </div>

                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                    <div class="milestone-header-fade max-w-2xl mb-16 will-change-transform">
                        <span class="text-primary font-mono text-xs uppercase tracking-widest font-semibold block mb-2">
                            {{ get_content('project_detail', 'milestones', 'badge', 'Project Execution Progress') }}
                        </span>
                        <h2
                            class="text-2xl sm:text-3xl lg:text-4xl font-heading font-black tracking-tight text-slate-900 uppercase">
                            {{ get_content('project_detail', 'milestones', 'title', 'Chronological Milestones') }}
                        </h2>
                        <p class="mt-4 text-slate-600 font-light">
                            {{ get_content('project_detail', 'milestones', 'subtitle', 'Phased delivery schedule, QA validation gates, and certified structural completions.') }}
                        </p>
                    </div>

                    <div id="milestones-timeline-wrapper" class="relative ml-4 md:ml-32 space-y-12">
                        <!-- Static Background Track Line -->
                        <div class="absolute left-0 top-3 bottom-3 w-[2px] bg-slate-200 pointer-events-none"></div>
                        <!-- Dynamic Theme Color Progress Fill Line -->
                        <div id="milestone-progress-line" class="absolute left-0 top-3 bottom-3 w-[2.5px] bg-[#f95716] origin-top scale-y-0 pointer-events-none shadow-[0_0_10px_rgba(249,87,22,0.6)] z-10"></div>

                        @foreach($project->milestones->sortBy('target_date') as $milestone)
                            <div class="timeline-milestone-item relative pl-8 md:pl-12 group will-change-transform z-20">
                                {{-- Milestone Marker Dot --}}
                                <div
                                    class="milestone-dot absolute -left-[7px] top-1.5 w-4 h-4 rounded-full border-2 border-white {{ $milestone->completed_at ? 'bg-emerald-500' : 'bg-slate-300' }} transition-all duration-500 group-hover:scale-125 z-20"
                                    data-completed="{{ $milestone->completed_at ? '1' : '' }}">
                                </div>

                                {{-- Date Label for Desktop --}}
                                <div
                                    class="md:absolute md:-left-36 md:top-0 md:text-right md:w-28 font-mono text-xs uppercase tracking-wider text-slate-400 font-semibold mb-1 md:mb-0">
                                    {{ $milestone->target_date ? $milestone->target_date->format('M Y') : 'Phase ' . $loop->iteration }}
                                </div>

                                <div
                                    class="bg-white rounded-xl border border-slate-200 p-6 shadow-sm group-hover:shadow-md transition-shadow">
                                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                                        <h3 class="text-lg font-heading font-bold text-slate-900 uppercase">
                                            {{ $milestone->title }}
                                        </h3>
                                        @if($milestone->completed_at)
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-emerald-50 text-emerald-700 border border-emerald-200">
                                                Completed on {{ $milestone->completed_at->format('M d, Y') }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded text-[11px] font-mono font-semibold bg-amber-50 text-amber-700 border border-amber-200">
                                                In Execution
                                            </span>
                                        @endif
                                    </div>
                                    @if($milestone->description)
                                        <p class="text-sm text-slate-600 font-light leading-relaxed">
                                            {{ $milestone->description }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif


        {{-- =========================================================================
        6. PROJECT INQUIRY / RFP CTA
        ========================================================================= --}}
        <section id="inquiry-cta" class="relative bg-[#0b0f17] text-white py-24 lg:py-28 overflow-hidden">
            <div
                class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:32px_32px] opacity-10 pointer-events-none">
            </div>

            <div class="inquiry-cta-content max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center will-change-transform">
                <span
                    class="inline-flex items-center px-3.5 py-1.5 rounded-full text-xs font-mono uppercase tracking-widest font-semibold bg-primary/20 text-primary border border-primary/30 mb-6">
                    {{ get_content('project_detail', 'cta', 'badge', 'Consultation & Tender Inquiries') }}
                </span>
                <h2
                    class="text-3xl sm:text-4xl lg:text-5xl font-heading font-black tracking-tight text-white uppercase leading-tight">
                    {{ get_content('project_detail', 'cta', 'title', 'Planning A High-Tolerance Construction Project?') }}
                </h2>
                <p class="mt-6 text-base sm:text-lg text-slate-300 font-light max-w-2xl mx-auto leading-relaxed">
                    {{ get_content('project_detail', 'cta', 'description', 'Connect with our civil engineering directors to review blueprints, structural calculations, and procurement schedules for your forthcoming development.') }}
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ get_content('project_detail', 'cta', 'btn_1_url', route('home') . '#footer') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-primary hover:bg-primary-hover text-white font-medium text-sm uppercase tracking-wider rounded transition-all duration-300 shadow-xl shadow-primary/25 hover:scale-[1.02]">
                        <span>{{ get_content('project_detail', 'cta', 'btn_1_text', 'Request Engineering Proposal') }}</span>
                        <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                    <a href="{{ route('public.projects.index') }}"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white/5 hover:bg-white/10 text-white font-medium text-sm uppercase tracking-wider rounded border border-white/10 transition-all duration-300">
                        <span>{{ get_content('project_detail', 'cta', 'btn_2_text', 'Back to Portfolio') }}</span>
                    </a>
                </div>
            </div>
        </section>

        {{-- =========================================================================
        7. RELATED PROJECTS
        ========================================================================= --}}
        @if(isset($relatedProjects) && $relatedProjects->count() > 0)
            <section id="project-detail-related" class="py-20 bg-slate-100 border-t border-slate-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="related-header-fade flex flex-col md:flex-row md:items-end justify-between mb-12 will-change-transform">
                        <div>
                            <span
                                class="text-primary font-mono text-xs uppercase tracking-widest font-semibold block mb-2">
                                {{ get_content('project_detail', 'related', 'badge', 'Relevant Portfolio') }}
                            </span>
                            <h2 class="text-2xl sm:text-3xl font-heading font-black tracking-tight text-slate-900 uppercase">
                                {{ get_content('project_detail', 'related', 'title', 'Related Engineering Projects') }}
                            </h2>
                        </div>
                        <a href="{{ route('public.projects.index') }}"
                            class="mt-4 md:mt-0 text-sm font-mono uppercase tracking-wider text-primary hover:text-primary-hover font-semibold inline-flex items-center">
                            <span>{{ get_content('project_detail', 'related', 'link_text', 'View Full Portfolio') }}</span>
                            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3" />
                            </svg>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        @foreach($relatedProjects as $rel)
                            @php
                                $relImg = $rel->getFirstMediaUrl('main_image');
                                if (empty($relImg)) {
                                    $relImg = asset('images/project-commercial-tower.jpg');
                                }
                            @endphp
                            <a href="{{ route('public.projects.show', $rel->slug) }}"
                                class="related-project-card group bg-white rounded-xl overflow-hidden border border-slate-200 hover:border-primary/50 transition-all duration-300 shadow-sm hover:shadow-xl flex flex-col will-change-transform">
                                <div class="aspect-[16/10] overflow-hidden bg-slate-900">
                                    <img src="{{ $relImg }}" alt="{{ $rel->title }}"
                                        class="w-full h-full object-cover transform transition-transform duration-700 ease-out group-hover:scale-105"
                                        loading="lazy">
                                </div>
                                <div class="p-6 flex-1 flex flex-col justify-between">
                                    <div>
                                        <span
                                            class="text-xs font-mono uppercase text-primary tracking-wider font-semibold block mb-1">
                                            {{ $rel->category ?? 'Civil Project' }}
                                        </span>
                                        <h3
                                            class="text-lg font-heading font-bold text-slate-900 uppercase group-hover:text-primary transition-colors">
                                            {{ $rel->title }}
                                        </h3>
                                    </div>
                                    <div
                                        class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between text-xs font-mono text-slate-400">
                                        <span>{{ $rel->location ?? 'Location Alpha' }}</span>
                                        <span class="text-primary font-bold">Inspect →</span>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

    </main>
@endsection