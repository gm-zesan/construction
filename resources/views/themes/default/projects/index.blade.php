@extends('themes.default.layouts.app')

@section('content')
    <!-- 1. Projects Hero Section -->
    <section id="projects-hero"
        class="relative min-h-[85vh] lg:min-h-[92vh] flex items-center overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-24 bg-[#080c14] text-white">

        <!-- Background Cinematic Photography with Dark Multilayer Architectural Gradient -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <img id="projects-hero-bg-img"
                src="{{ get_content_image('projects', 'hero', 'bg_image', asset('images/project-commercial-tower.jpg')) }}"
                alt="Commercial Engineering and Construction Projects"
                class="absolute -top-[10%] left-0 w-full h-[125%] object-cover object-center opacity-45 will-change-transform scale-105"
                loading="eager" fetchpriority="high" />
            <div class="absolute inset-0 bg-[#080c14]/40"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#080c14]/95 via-[#080c14]/85 to-black/60"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-black/50"></div>
            <!-- Atmospheric Architectural Blueprint Matrix Grid -->
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Main Container -->
        <div
            class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 w-full py-8 lg:py-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

                <!-- Left Column: Main Heading, Eyebrow & Jump Actions (7 Cols) -->
                <div id="projects-hero-content-col"
                    class="lg:col-span-7 parallax-text-layers parallax-layers flex flex-col items-start text-left relative will-change-transform">
                    <!-- Back Watermark Parallax Text -->
                    <span
                        class="parallax-text-back back text-white">{{ get_content('projects', 'hero', 'watermark', 'BUILDS') }}</span>

                    <!-- Sub Heading / Eyebrow -->
                    <div
                        class="projects-hero-fade parallax-text-front front sub-heading inline-flex items-center gap-3 mb-6 relative z-10 animate-fade-in">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#f95716]">
                            {{ get_content('projects', 'hero', 'badge', 'PROJECT PORTFOLIO & CASE STUDIES') }}
                        </span>
                    </div>

                    <!-- Main Hero Headline -->
                    <h1 id="projects-hero-heading"
                        class="projects-hero-fade parallax-text-mid mid section-title font-heading font-extrabold uppercase text-white tracking-tight leading-[0.98] text-4xl sm:text-6xl md:text-7xl lg:text-[76px] xl:text-[84px] mb-6 sm:mb-8 relative z-10">
                        {!! get_content_html('projects', 'hero', 'title', 'Engineering Skylines, Infrastructure & <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Sustainable</span> Landmarks.') !!}
                    </h1>

                    <!-- Quick Jump Action Links -->
                    <div
                        class="projects-hero-fade w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-4 relative z-10">
                        <a href="#projects-archive"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all duration-300 rounded-sm shadow-xl shadow-[#f95716]/25 hover:shadow-2xl hover:shadow-[#f95716]/40 hover:scale-[1.02] cursor-pointer">
                            <span>Explore Portfolio</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                        <a href="#featured-project-spotlight"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 text-xs sm:text-sm font-semibold uppercase tracking-wider text-white border border-white/25 hover:border-[#f95716] hover:bg-[#f95716]/10 transition-all duration-300 rounded-sm backdrop-blur-sm">
                            <span>Flagship Spotlight</span>
                        </a>
                    </div>
                </div>

                <!-- Right Column: Editorial Visuals, Circular Action Stamp & Live Snapshot (5 Cols) -->
                <div
                    class="lg:col-span-5 flex flex-col items-start lg:items-end justify-between space-y-8 sm:space-y-10 lg:space-y-12">

                    <!-- Editorial Supporting Paragraph -->
                    <div class="projects-hero-fade max-w-md lg:text-right">
                        <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed m-0">
                            {{ get_content('projects', 'hero', 'subheadline', 'Every structural commission represents disciplined constructability reviews, seismic isolation, real-time BIM clash detection, and certified quality compliance.') }}
                        </p>
                    </div>

                    <!-- Overlapping Circular Interactive Action Badge -->
                    <div id="projects-hero-action-badge"
                        class="projects-hero-fade flex items-center -space-x-3 sm:-space-x-4 lg:self-end will-change-transform">

                        <!-- Rotating Orange Circular Stamp -->
                        <div
                            class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#f95716] shadow-xl shadow-[#f95716]/20 flex items-center justify-center z-10">
                            <svg class="w-full h-full animate-spin-slow p-1" viewBox="0 0 100 100">
                                <defs>
                                    <path id="projectsTextCircle"
                                        d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                                </defs>
                                <text class="text-[9.5px] font-black uppercase tracking-[2px] fill-white">
                                    <textPath href="#projectsTextCircle">
                                        {{ get_content('projects', 'hero', 'stamp_text', '• CERTIFIED BUILDS • VIEW SPECS') }}
                                    </textPath>
                                </text>
                            </svg>
                            <!-- Center Architectural Motif -->
                            <div class="absolute inset-0 flex items-center justify-center pointer-events-none text-white">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <circle cx="12" cy="12" r="3" />
                                    <path
                                        d="M12 2v3m0 14v3M2 12h3m14 0h3m-4.93-7.07l-2.12 2.12m-5.9 5.9l-2.12 2.12m0-10.14l2.12 2.12m5.9 5.9l2.12 2.12"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none" />
                                </svg>
                            </div>
                        </div>

                        <!-- White Overlapping Circle with Downward Arrow -->
                        <a href="#projects-archive"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-950 shadow-2xl hover:bg-slate-100 transition-colors duration-200 z-20 group"
                            aria-label="Scroll down to portfolio directory">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-950 transition-transform duration-200 group-hover:translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>

                    </div>

                    <!-- Architectural Project Snapshot & Stats Badge -->
                    <div id="projects-hero-snapshot-badge"
                        class="projects-hero-fade flex items-center gap-4 p-3.5 sm:p-4 rounded-xl bg-black/50 border border-white/15 backdrop-blur-md shadow-2xl lg:self-end will-change-transform max-w-sm">

                        <!-- Construction Thumbnail Photo -->
                        <div
                            class="w-20 h-16 sm:w-24 sm:h-18 rounded-lg overflow-hidden flex-shrink-0 border border-white/20 bg-slate-900">
                            <img src="{{ get_content_image('projects', 'hero', 'thumbnail_image', asset('images/project-commercial-tower.jpg')) }}"
                                alt="Construction engineering project" class="w-full h-full object-cover object-center"
                                loading="lazy">
                        </div>

                        <!-- Stat Highlights -->
                        <div class="pr-2">
                            <div
                                class="font-heading text-2xl sm:text-3xl font-black text-white leading-none tracking-tight">
                                {{ get_content('projects', 'hero', 'stat_val', '420k+') }}
                            </div>
                            <div
                                class="text-[11px] sm:text-xs font-semibold text-slate-300 uppercase tracking-wider mt-1 flex items-center gap-1.5">
                                {{ get_content('projects', 'hero', 'stat_label', 'Sq.Ft Commercial Footprint') }}
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- 2. Interactive Projects Showcase & Category Filter Grid -->
    <section id="projects-archive"
        class="projects-archive-section relative py-20 sm:py-24 lg:py-32 bg-[#ffffff] text-slate-900 overflow-hidden border-t border-slate-200">

        <!-- Blueprint Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-35">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header & Filter Tabs -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12 sm:mb-16">

                <!-- Left: Title with Watermark -->
                <div class="parallax-text-layers parallax-layers relative will-change-transform">
                    <!-- Watermark -->
                    <span
                        class="parallax-text-back back text-slate-950">{{ get_content('projects', 'showcase', 'watermark', 'PORTFOLIO') }}</span>

                    <!-- Eyebrow -->
                    <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            {{ get_content('projects', 'showcase', 'badge', 'SIGNATURE BUILDS') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2
                        class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[48px] xl:text-[54px] m-0 relative z-10">
                        {!! get_content_html('projects', 'showcase', 'title', 'Disciplined Execution Across <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Diverse</span> Sectors') !!}
                    </h2>
                </div>

                <!-- Right: Subtitle & Dynamic Filter Buttons -->
                <div class="flex flex-col sm:items-start lg:items-end space-y-5 max-w-lg">
                    <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed lg:text-right m-0">
                        {{ get_content('projects', 'showcase', 'subtitle', 'Filter our verified case studies by operational sector to explore structural blueprints, geotechnical specifications, and photographic construction timelines.') }}
                    </p>

                    <!-- Filter Pill Bar -->
                    <div id="projects-filter-bar" class="flex flex-wrap items-center gap-2 pt-2">
                        <button type="button" data-filter="*"
                            class="project-filter-pill active px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-300 bg-[#0b0f17] text-white shadow-md cursor-pointer border border-transparent">
                            All Projects ({{ $projects->count() }})
                        </button>
                        @foreach($categories as $category)
                            @php
                                $catSlug = \Illuminate\Support\Str::slug($category);
                                $catCount = $projects->where('category', $category)->count();
                            @endphp
                            <button type="button" data-filter=".cat-{{ $catSlug }}"
                                class="project-filter-pill px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-300 bg-slate-100 hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200/80 cursor-pointer">
                                {{ $category }} ({{ $catCount }})
                            </button>
                        @endforeach
                    </div>
                </div>

            </div>

            <!-- Isotope Editorial Project Grid -->
            <div id="projects-grid" class="projects-isotope-grid relative -mx-3 sm:-mx-4 lg:-mx-5 flex flex-wrap">

                @forelse($projects as $index => $project)
                    @php
                        $catSlug = \Illuminate\Support\Str::slug($project->category ?? 'commercial');
                        $cardImg = $project->main_image_url;
                        $projectIndex = str_pad($index + 1, 2, '0', STR_PAD_LEFT);
                        $statusLabel = $project->completion_date
                            ? 'Completed ' . $project->completion_date->format('Y')
                            : ($project->status ? $project->status->label() : 'Active Contract');
                    @endphp

                    <div class="project-card-item cat-{{ $catSlug }} w-full md:w-1/2 px-3 sm:px-4 lg:px-5 pb-8 lg:pb-10">
                        <article
                            class="group relative bg-[#f8f7f4] rounded-2xl overflow-hidden border border-slate-200/80 hover:border-[#f95716]/40 transition-all duration-500 flex flex-col justify-between shadow-sm hover:shadow-xl h-full">

                            <div>
                                <!-- High-Res Image Box (Clean, without reveal curtain) -->
                                <div class="relative aspect-[16/10.5] overflow-hidden bg-slate-900 rounded-t-2xl">
                                    <img src="{{ $cardImg }}" alt="{{ $project->title }}"
                                        class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                        loading="lazy" />

                                    <!-- Ambient Gradient Overlay -->
                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none">
                                    </div>

                                    <!-- Top Badges Row -->
                                    <div class="absolute top-5 left-5 right-5 flex items-center justify-between z-10">
                                        <!-- Category Pill -->
                                        <span
                                            class="inline-flex items-center px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                            {{ $project->category ?? 'General Build' }}
                                        </span>

                                        <!-- Index Numeral -->
                                        <span
                                            class="font-heading font-black text-white/90 text-sm sm:text-base tracking-wider bg-black/40 backdrop-blur-md px-2.5 py-0.5 rounded-md border border-white/10">
                                            #{{ $projectIndex }}
                                        </span>
                                    </div>

                                    <!-- Bottom Overlay Stats (Location & Status) -->
                                    <div
                                        class="absolute bottom-4 left-5 right-5 flex items-center justify-between z-10 text-xs font-semibold text-white/90">
                                        @if($project->location)
                                            <div class="flex items-center gap-1.5 text-slate-200 text-xs">
                                                <svg class="w-3.5 h-3.5 text-[#f95716]" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                                <span class="truncate max-w-[200px]">{{ $project->location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Content Body -->
                                <div class="p-6 sm:p-8">
                                    <!-- Client Name -->
                                    @if($project->client_name)
                                        <div
                                            class="text-xs font-bold uppercase tracking-[0.16em] text-[#f95716] mb-2 flex items-center gap-2">
                                            <span>{{ $project->client_name }}</span>
                                        </div>
                                    @endif

                                    <!-- Project Title -->
                                    <h3
                                        class="font-heading font-black uppercase text-slate-950 group-hover:text-[#f95716] text-2xl sm:text-3xl tracking-tight leading-tight transition-colors duration-300 m-0 mb-3">
                                        <a href="{{ route('public.projects.show', $project->slug) }}"
                                            class="focus:outline-none">
                                            {{ $project->title }}
                                        </a>
                                    </h3>

                                    <!-- Short Description -->
                                    <p
                                        class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed m-0 mb-6 line-clamp-2">
                                        {{ $project->short_description ?? 'Full-scale structural engineering and commercial contractor execution delivered with zero-incident discipline.' }}
                                    </p>
                                </div>
                            </div>

                            <!-- Card Footer Action -->
                            <div
                                class="px-6 sm:px-8 pb-6 sm:pb-8 pt-0 flex items-center justify-between border-t border-slate-200/60 mt-auto">
                                <span
                                    class="text-xs font-bold uppercase tracking-wider text-slate-400 group-hover:text-slate-900 transition-colors">
                                    Technical Specs & Case Study
                                </span>

                                <a href="{{ route('public.projects.show', $project->slug) }}"
                                    class="w-10 h-10 rounded-full bg-slate-200/80 group-hover:bg-[#f95716] text-slate-900 group-hover:text-white flex items-center justify-center transition-all duration-300 shadow-sm group-hover:shadow-md cursor-pointer"
                                    aria-label="Explore {{ $project->title }} case study">
                                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M7 17L17 7M17 7H7M17 7V17" />
                                    </svg>
                                </a>
                            </div>

                        </article>
                    </div>
                @empty
                    <div class="w-full py-16 text-center text-slate-500">
                        <p class="text-lg font-medium">No published projects found in this category.</p>
                    </div>
                @endforelse

            </div>

    </section>

    <!-- 3. Flagship Project Spotlight -->
    @if($flagshipProject)
        <section id="featured-project-spotlight"
            class="flagship-spotlight-section relative py-20 sm:py-28 lg:py-32 bg-[#080c14] text-white overflow-hidden border-t border-white/10">

            <!-- Soft Architectural Ambient Glow -->
            <div class="absolute top-1/3 -left-32 w-[550px] h-[550px] rounded-full bg-[#f95716]/10 blur-[150px] pointer-events-none"></div>

            <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

                <!-- Clean Section Header -->
                <div class="relative mb-12 sm:mb-16">
                    <div class="flex items-center gap-3 mb-3">
                        <span class="w-8 sm:w-10 h-[2px] bg-[#f95716] rounded-full flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            {{ get_content('projects', 'spotlight', 'badge', 'FLAGSHIP CASE STUDY') }}
                        </span>
                    </div>

                    <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6">
                        <h2 class="font-heading font-black uppercase text-white tracking-tight leading-[1.08] text-3xl sm:text-4xl lg:text-[44px] m-0 max-w-2xl">
                            {!! get_content_html('projects', 'spotlight', 'title', 'Engineering Benchmark & <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.1em] tracking-normal inline-block transform -rotate-1">Architectural</span> Milestone') !!}
                        </h2>
                        <p class="text-slate-400 text-sm sm:text-base leading-relaxed max-w-lg m-0">
                            {{ get_content('projects', 'spotlight', 'subtitle', 'An in-depth look at our highest-complexity engineering commission, showcasing advanced construction technologies and zero-tolerance structural execution.') }}
                        </p>
                    </div>
                </div>

                <!-- Showcase Canvas -->
                <div class="rounded-2xl sm:rounded-3xl bg-[#0e1422] border border-white/10 p-6 sm:p-8 lg:p-12 shadow-2xl">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-14 items-center">

                        <!-- Left: Cinematic Architectural Visual Plate (7 Cols) -->
                        <div class="lg:col-span-7">
                            <div class="relative w-full aspect-[16/10] rounded-xl sm:rounded-2xl overflow-hidden bg-slate-900 border border-white/10 shadow-lg group">
                                <img src="{{ $flagshipProject->main_image_url }}" alt="{{ $flagshipProject->title }}"
                                    class="w-full h-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105"
                                    loading="lazy" />

                                <!-- Subtle Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/20 pointer-events-none"></div>

                                <!-- Status Tag -->
                                <div class="absolute top-4 left-4 sm:top-5 sm:left-5 z-10">
                                    <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full text-xs font-semibold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/15 shadow-sm">
                                        <span class="w-2 h-2 rounded-full {{ $flagshipProject->status && $flagshipProject->status->value === 'completed' ? 'bg-emerald-400' : 'bg-[#f95716]' }} animate-pulse"></span>
                                        {{ $flagshipProject->status ? $flagshipProject->status->label() : 'Completed Build' }}
                                    </span>
                                </div>

                                <!-- Location Tag -->
                                @if($flagshipProject->location)
                                    <div class="absolute bottom-4 left-4 sm:bottom-5 sm:left-5 z-10">
                                        <span class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-lg text-xs font-medium text-white/90 bg-black/60 backdrop-blur-md border border-white/10">
                                            <svg class="w-3.5 h-3.5 text-[#f95716]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            {{ $flagshipProject->location }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Right: Clean Editorial Info & Specs (5 Cols) -->
                        <div class="lg:col-span-5 flex flex-col justify-between">
                            <div>
                                @if($flagshipProject->category)
                                    <span class="inline-block text-xs font-bold uppercase tracking-[0.2em] text-[#f95716] mb-2.5">
                                        {{ $flagshipProject->category }}
                                    </span>
                                @endif

                                <h3 class="font-heading font-black uppercase text-white text-2xl sm:text-3xl lg:text-4xl tracking-tight leading-tight mb-4">
                                    {{ $flagshipProject->title }}
                                </h3>

                                <p class="text-slate-300 text-sm sm:text-base leading-relaxed m-0 mb-6">
                                    {{ $flagshipProject->short_description ?? 'A definitive benchmark in modern structural engineering and precision civil execution, delivered with zero safety compromises.' }}
                                </p>
                            </div>

                            <!-- Minimal Specifications Strip -->
                            <div class="grid grid-cols-2 gap-y-4 gap-x-6 py-5 border-y border-white/10 mb-6">
                                <div>
                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Client</span>
                                    <span class="block text-sm font-medium text-white mt-0.5 truncate">
                                        {{ $flagshipProject->client_name ?? 'Confidential' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Delivery Year</span>
                                    <span class="block text-sm font-medium text-white mt-0.5 font-mono">
                                        {{ $flagshipProject->completion_date ? $flagshipProject->completion_date->format('Y') : '2024' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Sector</span>
                                    <span class="block text-sm font-medium text-white mt-0.5 truncate">
                                        {{ $flagshipProject->category ?? 'Commercial' }}
                                    </span>
                                </div>
                                <div>
                                    <span class="block text-[11px] font-semibold uppercase tracking-wider text-slate-400">Status</span>
                                    <span class="block text-sm font-medium text-white mt-0.5 truncate">
                                        {{ $flagshipProject->status ? $flagshipProject->status->label() : 'Completed' }}
                                    </span>
                                </div>
                            </div>

                            <!-- CTA Button -->
                            <div>
                                <a href="{{ route('public.projects.show', $flagshipProject->slug) }}"
                                    class="inline-flex items-center justify-center gap-3 px-8 py-3.5 text-xs sm:text-sm font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all duration-200 rounded-full shadow-lg shadow-[#f95716]/20 hover:shadow-xl hover:shadow-[#f95716]/30 group w-full sm:w-auto">
                                    <span>Explore Full Case Study</span>
                                    <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </section>
    @endif

    <!-- 4. Complete Project Directory Index with Hover-Reveal Floating Preview Matrix -->
    <section id="project-index-matrix"
        class="project-index-section relative py-20 sm:py-24 lg:py-28 bg-[#fbfbf9] text-slate-900 overflow-visible border-t border-slate-200">

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header -->
            <div class="parallax-text-layers parallax-layers relative mb-12 sm:mb-16 will-change-transform">
                <!-- Watermark -->
                <span
                    class="parallax-text-back back text-slate-950">{{ get_content('projects', 'index_matrix', 'watermark', 'ARCHIVE') }}</span>

                <!-- Eyebrow -->
                <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                    <span
                        class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                        {{ get_content('projects', 'index_matrix', 'badge', 'COMPLETE ARCHITECTURAL INDEX') }}
                    </span>
                </div>

                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 relative z-10">
                    <div>
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[48px] m-0">
                            {!! get_content_html('projects', 'index_matrix', 'title', 'Enterprise Project <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Directory</span> & Delivery Log') !!}
                        </h2>
                    </div>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl m-0">
                        {{ get_content('projects', 'index_matrix', 'subtitle', 'Hover over any contract record to preview construction imagery, location coordinates, client entities, and full engineering deliverables.') }}
                    </p>
                </div>
            </div>

            <!-- Interactive Index Rows -->
            <div class="space-y-3 sm:space-y-4 relative">
                @foreach($projects as $pIdx => $project)
                    @php
                        $pIndexFormatted = str_pad($pIdx + 1, 2, '0', STR_PAD_LEFT);
                        $yearText = $project->completion_date ? $project->completion_date->format('Y') : ($project->start_date ? $project->start_date->format('Y') : '2024');
                    @endphp

                    <div
                        class="project-index-row group relative z-10 hover:z-40 flex items-center justify-between px-6 sm:px-10 lg:px-12 py-5 sm:py-6 rounded-2xl bg-[#ecebe6] hover:bg-[#f95716] border border-slate-300/70 hover:border-[#f95716] transition-all duration-300 ease-out cursor-pointer select-none">

                        <!-- Left: Index & Year -->
                        <div class="flex items-center gap-4 sm:gap-8 w-24 sm:w-36 flex-shrink-0 relative z-10">
                            <span
                                class="font-mono text-xs font-bold text-slate-400 group-hover:text-white/80 transition-colors">
                                #{{ $pIndexFormatted }}
                            </span>
                            <span
                                class="font-heading font-black text-slate-600 group-hover:text-white text-base sm:text-lg transition-colors">
                                {{ $yearText }}
                            </span>
                        </div>

                        <!-- Center: Title, Client & Category -->
                        <div class="flex-1 px-4 sm:px-8 relative z-10">
                            <h3
                                class="font-heading font-black uppercase text-slate-950 group-hover:text-white text-lg sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-200 m-0 leading-tight">
                                <a href="{{ route('public.projects.show', $project->slug) }}" class="focus:outline-none">
                                    {{ $project->title }}
                                </a>
                            </h3>
                            <div
                                class="flex items-center gap-3 text-xs sm:text-sm text-slate-500 group-hover:text-white/80 transition-colors duration-200 mt-1 font-medium">
                                <span>{{ $project->category }}</span>
                                @if($project->location)
                                    <span>·</span>
                                    <span>{{ $project->location }}</span>
                                @endif
                                @if($project->client_name)
                                    <span>·</span>
                                    <span class="hidden sm:inline">{{ $project->client_name }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Floating Hover-Reveal Image Preview (Centered cursor tracking preview) -->
                        <div
                            class="project-preview-anchor absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none z-50 hidden sm:block">
                            <div
                                class="project-preview-box opacity-0 scale-75 rotate-[-2deg] transition-all duration-300 ease-out group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0 w-52 sm:w-60 md:w-72 aspect-[16/11] rounded-2xl overflow-hidden shadow-2xl border-4 border-white bg-slate-900">
                                <img src="{{ $project->main_image_url }}" alt="{{ $project->title }}"
                                    class="w-full h-full object-cover" loading="lazy" />
                            </div>
                        </div>

                        <!-- Right: Action Arrow Button -->
                        <div class="text-right flex-shrink-0 relative z-10">
                            <a href="{{ route('public.projects.show', $project->slug) }}"
                                class="w-10 h-10 rounded-full bg-white/60 group-hover:bg-white text-slate-900 flex items-center justify-center transition-all duration-200 shadow-sm"
                                aria-label="View {{ $project->title }}">
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-0.5 group-hover:-translate-y-0.5"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M7 17L17 7M17 7H7M17 7V17" />
                                </svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

        </div>

    </section>
@endsection