@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- 1. HERO SECTION (Exact Wilmer Construction Superstructure Layout) -->
    <section class="relative min-h-[88vh] lg:min-h-[92vh] flex items-center pt-24 sm:pt-28 pb-20 overflow-hidden bg-slate-100">
        <!-- Bright Full-Scale Construction Superstructure Background -->
        <div class="absolute inset-0 z-0 overflow-hidden">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Wilmer Construction Superstructure" class="w-full h-full object-cover object-center filter contrast-105">
            <!-- Subtle atmospheric overlay for text contrast -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-white/70 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-white/40 via-transparent to-transparent"></div>
        </div>

        <!-- Giant Outline Ghost Watermark: SCHEDULE -->
        <div class="absolute left-4 sm:left-12 lg:left-24 top-1/2 -translate-y-1/2 font-['Barlow_Condensed'] text-[15vw] font-black leading-none text-transparent select-none pointer-events-none tracking-widest uppercase z-0 opacity-80 whitespace-nowrap" 
             style="-webkit-text-stroke: 1.5px rgba(255, 255, 255, 0.85);">
            SCHEDULE
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="max-w-3xl space-y-6">
                <!-- Eyebrow Badge -->
                <div class="inline-flex items-center gap-2">
                    <span class="text-xs font-mono font-bold tracking-[0.25em] text-[#0b163f] uppercase">
                        {{ get_content('home', 'hero', 'badge', '// EXPLORE THE FEATURES') }}
                    </span>
                </div>

                <!-- Main Heading (Wilmer Ultra-Bold Deep Navy Headline) -->
                <h1 class="font-['Barlow_Condensed'] text-6xl sm:text-8xl lg:text-9xl font-black text-[#0b163f] leading-[0.88] tracking-tight uppercase">
                    {!! get_content('home', 'hero', 'headline', 'BUILD A BETTER<br>TOMORROW') !!}
                </h1>

                <!-- Subtitle -->
                <p class="text-slate-700 text-base sm:text-lg max-w-xl font-normal leading-relaxed">
                    {!! get_content('home', 'hero', 'subheadline', 'Etiam scelerisque tortor at lectus dapibus, nec fermentum diam feugiat. Morbi rutrum magna et dui.') !!}
                </p>

                <!-- CTAs -->
                <div class="flex flex-wrap items-center gap-4 pt-4">
                    <a href="{{ route('public.projects.index') }}" class="px-8 py-4 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-['Barlow_Condensed'] font-black text-base uppercase tracking-widest shadow-xl shadow-[#DFFE40]/25 transition-all flex items-center gap-3 group">
                        <span>{{ get_content('home', 'hero', 'primary_btn_text', 'EXPLORE PORTFOLIO') }}</span>
                        <i class="ri-arrow-right-line text-lg group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-[#0b163f] hover:bg-[#14235e] text-white font-['Barlow_Condensed'] font-bold text-base uppercase tracking-widest transition-all flex items-center gap-2 shadow-lg">
                        <span>{{ get_content('home', 'hero', 'secondary_btn_text', 'TECHNICAL BRIEFING') }}</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. SERVICES & CAPABILITIES SECTION (With Giant "SERVICES" Watermark) -->
    <section class="py-24 bg-[#080e1a] relative overflow-hidden border-t border-white/[0.06]">
        <div class="wilmer-watermark">SERVICES</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Title -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                        {{ get_content('home', 'services', 'badge', 'CAPABILITIES & PROCESS') }}
                    </span>
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                </div>
                <h2 class="font-barlow font-black text-4xl sm:text-5xl text-white uppercase tracking-wider">
                    {!! get_content('home', 'services', 'title', 'SPECIALIZED SERVICES') !!}
                </h2>
                <p class="text-slate-400 text-sm mt-3 font-light">
                    {{ get_content('home', 'services', 'subtitle', 'Comprehensive architectural engineering, BIM coordination, and turnkey construction management.') }}
                </p>
            </div>

            <!-- 4 Top Horizontal Capability Bars -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
                @php
                    $capabilities = [
                        ['title' => 'Project Planning', 'sub' => 'Site survey & parametric modeling', 'num' => '01'],
                        ['title' => 'General Contracting', 'sub' => 'Superstructure construction', 'num' => '02'],
                        ['title' => 'Virtual Design & BIM', 'sub' => 'Level 3 coordinate auditing', 'num' => '03'],
                        ['title' => 'Interior Architecture', 'sub' => 'Luxury spatial engineering', 'num' => '04'],
                    ];
                @endphp
                @foreach($capabilities as $cap)
                    <div class="p-6 bg-[#0e172a] border-t-2 border-[#DFFE40] border-x border-b border-white/[0.06] hover:bg-[#131f38] transition-all group">
                        <span class="font-barlow font-black text-2xl text-[#DFFE40] block mb-2">{{ $cap['num'] }}</span>
                        <h4 class="font-barlow font-bold text-lg text-white uppercase tracking-wider group-hover:text-[#DFFE40] transition-colors">
                            {{ $cap['title'] }}
                        </h4>
                        <p class="text-xs text-slate-400 mt-1 font-light">{{ $cap['sub'] }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Interactive Spotlight Card (Left: Tablet Blueprint photo, Right: Full project management card) -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center bg-[#0e172a] border border-white/[0.08] p-6 sm:p-8 lg:p-12 relative">
                <div class="wilmer-badge-sq">■</div>
                <div class="lg:col-span-6 overflow-hidden">
                    <img src="{{ asset('images/about-engineer-tablet.jpg') }}" alt="Full Project Management" class="w-full h-80 sm:h-96 object-cover filter contrast-110 hover:scale-105 transition-transform duration-500">
                </div>
                <div class="lg:col-span-6 space-y-6 lg:pl-6">
                    <div class="inline-flex items-center gap-2 text-xs font-barlow font-bold text-[#DFFE40] tracking-widest uppercase">
                        <i class="ri-settings-4-fill"></i>
                        <span>TURNKEY EXECUTION DISCIPLINE</span>
                    </div>
                    <h3 class="font-barlow font-black text-3xl sm:text-4xl text-white uppercase tracking-wide leading-tight">
                        Full project management
                    </h3>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                        We supervise the entire structural lifecycle from parametric BIM coordination to high-tolerance concrete pours and facade enclosure. Every phase is managed by chartered civil engineers with zero deviation tolerance.
                    </p>
                    <div class="pt-2">
                        <a href="{{ route('about') }}" class="px-7 py-3.5 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-barlow font-black text-xs uppercase tracking-widest inline-flex items-center gap-2 shadow-lg shadow-[#DFFE40]/20">
                            <span>READ MORE</span>
                            <i class="ri-arrow-right-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. PROJECTS SECTION (Deep Navy with Giant "PROJECTS" Watermark) -->
    <section class="py-24 bg-[#050912] relative overflow-hidden border-t border-white/[0.06]" id="projects">
        <div class="wilmer-watermark">PROJECTS</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header & Filter Tabs -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                        <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                            {{ get_content('home', 'projects', 'badge', 'LANDMARK PORTFOLIO') }}
                        </span>
                    </div>
                    <h2 class="font-barlow font-black text-4xl sm:text-5xl text-white uppercase tracking-wider">
                        {!! get_content('home', 'projects', 'title', 'PROJECTS') !!}
                    </h2>
                </div>

                <div class="flex flex-wrap items-center gap-2 font-barlow font-bold text-xs tracking-wider uppercase">
                    <a href="{{ route('public.projects.index') }}" class="px-5 py-2.5 bg-[#DFFE40] text-slate-950 font-black">ALL</a>
                    <a href="{{ route('public.projects.index', ['category' => 'commercial']) }}" class="px-5 py-2.5 bg-[#0e172a] text-slate-300 hover:text-white hover:bg-[#131f38] border border-white/10">COMMERCIAL</a>
                    <a href="{{ route('public.projects.index', ['category' => 'residential']) }}" class="px-5 py-2.5 bg-[#0e172a] text-slate-300 hover:text-white hover:bg-[#131f38] border border-white/10">RESIDENTIAL</a>
                    <a href="{{ route('public.projects.index', ['category' => 'infrastructure']) }}" class="px-5 py-2.5 bg-[#0e172a] text-slate-300 hover:text-white hover:bg-[#131f38] border border-white/10">CIVIL</a>
                </div>
            </div>

            <!-- Projects Grid -->
            @php
                $featuredProjects = \App\Models\Project::with('media')->published()->ordered()->take(3)->get();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($featuredProjects as $project)
                    <div class="wilmer-card group overflow-hidden">
                        <div class="wilmer-badge-sq">■</div>
                        <div class="relative h-64 sm:h-72 overflow-hidden">
                            <img src="{{ $project->featured_image ?: asset('images/project-commercial-tower.jpg') }}" 
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
                                {{ Str::limit(strip_tags($project->short_description ?? $project->description), 110) }}
                            </p>
                            <div class="pt-3 border-t border-white/10 flex items-center justify-between">
                                <a href="{{ route('public.projects.show', $project->slug) }}" class="text-xs font-barlow font-bold text-[#DFFE40] hover:text-white uppercase tracking-wider flex items-center gap-1.5">
                                    <span>VIEW PROJECT</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                                <span class="text-[11px] font-mono text-slate-500">{{ $project->completion_year ?? '2025' }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Fallback Project Cards -->
                    @for($i = 1; $i <= 3; $i++)
                        <div class="wilmer-card group overflow-hidden">
                            <div class="wilmer-badge-sq">■</div>
                            <div class="relative h-64 sm:h-72 overflow-hidden">
                                <img src="{{ asset('images/project-commercial-tower.jpg') }}" alt="Project" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            </div>
                            <div class="p-6 space-y-3">
                                <span class="text-xs font-barlow font-bold tracking-widest text-[#DFFE40] uppercase block">High-Rise Commercial</span>
                                <h3 class="font-barlow font-black text-xl text-white uppercase tracking-wide">Skyline Tower Build {{ $i }}</h3>
                                <p class="text-xs text-slate-400 font-light">Precision architectural high-rise execution.</p>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- 4. PARTNER STRIP (Wilmer Style Vibrant Orange Bar) -->
    <section class="bg-[#DFFE40] py-10 px-4 relative z-10">
        <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-8 text-white font-barlow font-black text-xl tracking-widest uppercase opacity-90">
            <span class="flex items-center gap-2"><i class="ri-building-4-fill text-2xl"></i> MONOLITHIC</span>
            <span class="flex items-center gap-2"><i class="ri-hammer-fill text-2xl"></i> STEELWORKS</span>
            <span class="flex items-center gap-2"><i class="ri-scan-2-line text-2xl"></i> BIM DYNAMICS</span>
            <span class="flex items-center gap-2"><i class="ri-leaf-fill text-2xl"></i> ECO-CONCRETE</span>
            <span class="flex items-center gap-2"><i class="ri-shield-check-fill text-2xl"></i> SEISMIC PRO</span>
        </div>
    </section>

    <!-- 5. FEATURED BENTO SECTION (With Giant "FEATURED" Watermark) -->
    <section class="py-24 bg-[#080e1a] relative overflow-hidden">
        <div class="wilmer-watermark">FEATURED</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Section Header -->
            <div class="text-center max-w-3xl mx-auto mb-16">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                        CORE CAPABILITIES
                    </span>
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                </div>
                <h2 class="font-barlow font-black text-4xl sm:text-5xl text-white uppercase tracking-wider">
                    FEATURED EXPERTISE
                </h2>
            </div>

            <!-- 6-Grid Bento Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- 1. Blueprint Box -->
                <div class="bg-[#0e172a] border border-white/[0.08] p-8 flex flex-col justify-between h-72 relative overflow-hidden group">
                    <div class="wilmer-badge-sq">■</div>
                    <div class="space-y-2 relative z-10">
                        <span class="font-mono text-xs text-[#DFFE40]">COORDINATE: 40.7128° N, 74.0060° W</span>
                        <h4 class="font-barlow font-black text-2xl text-white uppercase tracking-wider">BLUEPRINT DRAFTING</h4>
                        <p class="text-xs text-slate-400 font-light">Parametric computational drafting with zero-deviance spatial tolerance.</p>
                    </div>
                    <i class="ri-compasses-2-line text-7xl text-white/5 absolute -bottom-4 -right-4"></i>
                </div>

                <!-- 2. Feature Card 1 -->
                <div class="bg-white text-[#080e1a] p-8 flex flex-col justify-center text-center items-center h-72 relative shadow-2xl">
                    <div class="wilmer-badge-sq">■</div>
                    <div class="w-14 h-14 bg-[#DFFE40]/10 text-[#DFFE40] flex items-center justify-center text-3xl mb-4">
                        <i class="ri-ruler-2-line"></i>
                    </div>
                    <h4 class="font-barlow font-black text-2xl uppercase tracking-wider mb-2">Pre-Planning</h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed max-w-xs">
                        Rigorous feasibility studies, geotechnical surveys, and cost modeling prior to ground breaking.
                    </p>
                </div>

                <!-- 3. Photo Card 1 -->
                <div class="relative h-72 overflow-hidden border border-white/10 group">
                    <div class="wilmer-badge-sq">■</div>
                    <img src="{{ asset('images/why-choose-engineers.jpg') }}" alt="Site Engineer" class="w-full h-full object-cover filter contrast-110 group-hover:scale-110 transition-transform duration-500">
                </div>

                <!-- 4. Feature Card 2 -->
                <div class="bg-white text-[#080e1a] p-8 flex flex-col justify-center text-center items-center h-72 relative shadow-2xl">
                    <div class="wilmer-badge-sq">■</div>
                    <div class="w-14 h-14 bg-[#DFFE40]/10 text-[#DFFE40] flex items-center justify-center text-3xl mb-4">
                        <i class="ri-building-line"></i>
                    </div>
                    <h4 class="font-barlow font-black text-2xl uppercase tracking-wider mb-2">Virtual Design</h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed max-w-xs">
                        BIM Level 3 4D timeline scheduling and structural conflict resolution in virtual space.
                    </p>
                </div>

                <!-- 5. Photo Card 2 -->
                <div class="relative h-72 overflow-hidden border border-white/10 group">
                    <div class="wilmer-badge-sq">■</div>
                    <img src="{{ asset('images/project-commercial-tower.jpg') }}" alt="Modern Facade" class="w-full h-full object-cover filter contrast-110 group-hover:scale-110 transition-transform duration-500">
                </div>

                <!-- 6. Feature Card 3 -->
                <div class="bg-white text-[#080e1a] p-8 flex flex-col justify-center text-center items-center h-72 relative shadow-2xl">
                    <div class="wilmer-badge-sq">■</div>
                    <div class="w-14 h-14 bg-[#DFFE40]/10 text-[#DFFE40] flex items-center justify-center text-3xl mb-4">
                        <i class="ri-shield-flash-line"></i>
                    </div>
                    <h4 class="font-barlow font-black text-2xl uppercase tracking-wider mb-2">Turnkey Build</h4>
                    <p class="text-xs text-slate-600 font-medium leading-relaxed max-w-xs">
                        Complete superstructure execution with rigorous on-site health and environmental protocols.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. CALLOUT HIGHLIGHT BANNER (Wilmer Signature Orange Block Split) -->
    <section class="bg-[#050912] border-y border-white/[0.08] overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12 items-stretch">
            <div class="lg:col-span-6 relative min-h-[340px]">
                <img src="{{ asset('images/why-choose-crane.jpg') }}" alt="Crane Construction" class="w-full h-full object-cover filter contrast-125">
            </div>
            <div class="lg:col-span-6 bg-[#DFFE40] text-slate-950 font-black p-10 sm:p-14 lg:p-16 flex flex-col justify-center space-y-5 relative">
                <div class="wilmer-badge-sq bg-[#080e1a] text-white">■</div>
                <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em]">
                    EXECUTIVE PROJECT DIRECTION
                </span>
                <h3 class="font-barlow font-black text-3xl sm:text-5xl uppercase tracking-wider leading-none">
                    Full project management
                </h3>
                <p class="text-slate-900 text-sm sm:text-base leading-relaxed font-light">
                    Innovative structural solutions combined with safety standards, strict milestone delivery, and comprehensive contractor management.
                </p>
                <div class="pt-2">
                    <a href="{{ route('contact') }}" class="px-8 py-4 bg-white hover:bg-slate-100 text-[#080e1a] font-barlow font-black text-sm uppercase tracking-widest inline-flex items-center gap-2 shadow-2xl">
                        <span>START CONSULTATION</span>
                        <i class="ri-arrow-right-line text-[#DFFE40]"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. TELEMETRY & METRIC COUNTERS -->
    <section class="py-16 bg-[#080e1a] border-b border-white/[0.06]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-y md:divide-y-0 md:divide-x divide-white/10">
                <div class="p-4">
                    <span class="font-barlow font-black text-5xl sm:text-6xl text-white block">34<span class="text-[#DFFE40]">+</span></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.2em] text-slate-400 mt-1 block">Awards Won</span>
                </div>
                <div class="p-4">
                    <span class="font-barlow font-black text-5xl sm:text-6xl text-white block">97<span class="text-[#DFFE40]">%</span></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.2em] text-slate-400 mt-1 block">Client Satisfaction</span>
                </div>
                <div class="p-4">
                    <span class="font-barlow font-black text-5xl sm:text-6xl text-white block">15<span class="text-[#DFFE40]">+</span></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.2em] text-slate-400 mt-1 block">Mega Towers</span>
                </div>
                <div class="p-4">
                    <span class="font-barlow font-black text-5xl sm:text-6xl text-white block">62<span class="text-[#DFFE40]">+</span></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.2em] text-slate-400 mt-1 block">Chartered Engineers</span>
                </div>
            </div>
        </div>
    </section>

    <!-- 8. DUAL TESTIMONIALS (Navy Card + White Card) -->
    <section class="py-24 bg-[#050912] relative overflow-hidden border-b border-white/[0.06]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">TESTIMONIALS</span>
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                </div>
                <h2 class="font-barlow font-black text-4xl text-white uppercase tracking-wider">CLIENT ENDORSEMENTS</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Card 1: Navy Background with Orange Quote -->
                <div class="bg-[#0e172a] border border-white/[0.08] p-8 sm:p-10 relative">
                    <div class="wilmer-badge-sq">■</div>
                    <i class="ri-double-quotes-l text-4xl text-[#DFFE40] mb-4 block"></i>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light mb-6">
                        "Apex delivered our 42-storey commercial tower with absolute geometric precision and completed structural handoff two months ahead of schedule."
                    </p>
                    <div class="flex items-center gap-4 pt-4 border-t border-white/10">
                        <div class="w-12 h-12 bg-[#DFFE40] text-slate-950 font-black font-barlow font-black text-xl flex items-center justify-center">
                            JS
                        </div>
                        <div>
                            <h4 class="font-barlow font-bold text-base text-white uppercase tracking-wider">Jonathan Sterling</h4>
                            <span class="text-xs text-[#DFFE40] font-medium block">Managing Director, Horizon Developments</span>
                        </div>
                    </div>
                </div>

                <!-- Card 2: White Background with Navy Quote -->
                <div class="bg-white text-[#080e1a] p-8 sm:p-10 relative shadow-2xl">
                    <div class="wilmer-badge-sq">■</div>
                    <i class="ri-double-quotes-l text-4xl text-[#080e1a] mb-4 block"></i>
                    <p class="text-slate-700 text-sm sm:text-base leading-relaxed font-medium mb-6">
                        "Their computational BIM coordination eliminated on-site clashes completely. An exceptional engineering firm with unmatched structural discipline."
                    </p>
                    <div class="flex items-center gap-4 pt-4 border-t border-slate-200">
                        <div class="w-12 h-12 bg-[#080e1a] text-white font-barlow font-black text-xl flex items-center justify-center">
                            EM
                        </div>
                        <div>
                            <h4 class="font-barlow font-bold text-base text-[#080e1a] uppercase tracking-wider">Elena Rostova</h4>
                            <span class="text-xs text-[#DFFE40] font-bold block">Chief Architect, Urban Infrastructure Consortium</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 9. PROFESSIONALS / TECHNICAL DIRECTORATE (With Giant "PROFESSIONALS" Watermark) -->
    <section class="py-24 bg-[#080e1a] relative overflow-hidden border-b border-white/[0.06]" id="team">
        <div class="wilmer-watermark">PROFESSIONALS</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- Header -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                        <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                            TECHNICAL DIRECTORS
                        </span>
                    </div>
                    <h2 class="font-barlow font-black text-4xl sm:text-5xl text-white uppercase tracking-wider">
                        PROFESSIONALS
                    </h2>
                </div>
                <a href="{{ route('team') }}" class="font-barlow font-bold text-xs text-[#DFFE40] hover:text-white uppercase tracking-widest flex items-center gap-2">
                    <span>VIEW FULL DIRECTORATE</span>
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            <!-- 4 Team Cards -->
            @php
                $teamLeaders = \App\Models\TeamMember::with('media')->active()->ordered()->take(4)->get();
            @endphp
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($teamLeaders as $member)
                    <div class="wilmer-card group overflow-hidden">
                        <div class="wilmer-badge-sq">■</div>
                        <div class="h-80 overflow-hidden relative">
                            <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover object-top filter contrast-110 group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-[#080e1a] via-transparent to-transparent opacity-80"></div>
                        </div>
                        <div class="p-5 text-center">
                            <h4 class="font-barlow font-bold text-lg text-white uppercase tracking-wider group-hover:text-[#DFFE40] transition-colors">
                                <a href="{{ route('team.show', $member->id) }}">{{ $member->name }}</a>
                            </h4>
                            <span class="text-xs text-[#DFFE40] font-medium block mt-0.5 uppercase tracking-wider">{{ $member->designation }}</span>
                        </div>
                    </div>
                @empty
                    @for($t = 1; $t <= 4; $t++)
                        <div class="wilmer-card group overflow-hidden">
                            <div class="wilmer-badge-sq">■</div>
                            <div class="h-80 overflow-hidden">
                                <img src="{{ asset('images/team-' . (($t % 3) + 1) . '.jpg') }}" alt="Team Lead" class="w-full h-full object-cover">
                            </div>
                            <div class="p-5 text-center">
                                <h4 class="font-barlow font-bold text-lg text-white uppercase">Marcus Vance</h4>
                                <span class="text-xs text-[#DFFE40] font-medium block">Lead Structural Engineer</span>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>

    <!-- 10. RADIAL PROGRESS METRICS & ACCORDION SECTION -->
    <section class="py-24 bg-[#050912] relative overflow-hidden border-b border-white/[0.06]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <!-- 3 Radial Counters -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-20 text-center">
                <div class="p-6 bg-[#0e172a] border border-white/[0.06] flex items-center justify-center gap-6">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-white/10" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-[#DFFE40]" stroke-dasharray="86, 100" stroke-width="3" stroke-linecap="square" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <span class="absolute font-barlow font-black text-xl text-white">86%</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-barlow font-bold text-lg text-white uppercase">Site Safety Score</h4>
                        <span class="text-xs text-slate-400 font-light">Zero incident protocols</span>
                    </div>
                </div>

                <div class="p-6 bg-[#0e172a] border border-white/[0.06] flex items-center justify-center gap-6">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-white/10" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-[#DFFE40]" stroke-dasharray="75, 100" stroke-width="3" stroke-linecap="square" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <span class="absolute font-barlow font-black text-xl text-white">75%</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-barlow font-bold text-lg text-white uppercase">Carbon Reduction</h4>
                        <span class="text-xs text-slate-400 font-light">Eco-concrete formulations</span>
                    </div>
                </div>

                <div class="p-6 bg-[#0e172a] border border-white/[0.06] flex items-center justify-center gap-6">
                    <div class="relative w-20 h-20 flex items-center justify-center">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                            <path class="text-white/10" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                            <path class="text-[#DFFE40]" stroke-dasharray="68, 100" stroke-width="3" stroke-linecap="square" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"/>
                        </svg>
                        <span class="absolute font-barlow font-black text-xl text-white">68%</span>
                    </div>
                    <div class="text-left">
                        <h4 class="font-barlow font-bold text-lg text-white uppercase">BIM Automation</h4>
                        <span class="text-xs text-slate-400 font-light">4D coordinate audits</span>
                    </div>
                </div>
            </div>

            <!-- Accordion Process Box -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-center">
                <div class="lg:col-span-5">
                    <div class="relative overflow-hidden border border-white/10 shadow-2xl">
                        <div class="wilmer-badge-sq">■</div>
                        <img src="{{ asset('images/about-main.jpg') }}" alt="Technical Planning" class="w-full h-[420px] object-cover filter contrast-110">
                    </div>
                </div>

                <div class="lg:col-span-7 space-y-4" x-data="{ active: 1 }">
                    <div class="border border-white/[0.08] bg-[#0e172a]">
                        <button @click="active = active === 1 ? 0 : 1" class="w-full p-5 text-left font-barlow font-bold text-lg text-white uppercase tracking-wider flex items-center justify-between">
                            <span>01. Project Feasibility & Computational Survey</span>
                            <i class="ri-add-line text-[#DFFE40]" :class="{ 'ri-subtract-line': active === 1, 'ri-add-line': active !== 1 }"></i>
                        </button>
                        <div x-show="active === 1" class="p-5 pt-0 text-sm text-slate-300 font-light leading-relaxed border-t border-white/5">
                            Comprehensive site topology analysis, load calculation, soil geotech verification, and regulatory compliance mapping.
                        </div>
                    </div>

                    <div class="border border-white/[0.08] bg-[#0e172a]">
                        <button @click="active = active === 2 ? 0 : 2" class="w-full p-5 text-left font-barlow font-bold text-lg text-white uppercase tracking-wider flex items-center justify-between">
                            <span>02. Parametric BIM Coordination & Metallurgy</span>
                            <i class="ri-add-line text-[#DFFE40]" :class="{ 'ri-subtract-line': active === 2, 'ri-add-line': active !== 2 }"></i>
                        </button>
                        <div x-show="active === 2" class="p-5 pt-0 text-sm text-slate-300 font-light leading-relaxed border-t border-white/5">
                            3D parametric models audited with engineering lead contractors for clash detection and structural optimization before site deployment.
                        </div>
                    </div>

                    <div class="border border-white/[0.08] bg-[#0e172a]">
                        <button @click="active = active === 3 ? 0 : 3" class="w-full p-5 text-left font-barlow font-bold text-lg text-white uppercase tracking-wider flex items-center justify-between">
                            <span>03. Superstructure Concrete & Steel Erection</span>
                            <i class="ri-add-line text-[#DFFE40]" :class="{ 'ri-subtract-line': active === 3, 'ri-add-line': active !== 3 }"></i>
                        </button>
                        <div x-show="active === 3" class="p-5 pt-0 text-sm text-slate-300 font-light leading-relaxed border-t border-white/5">
                            High-strength reinforced concrete core casting, heavy steel truss placement, and continuous laser-guided verticality checks.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 11. LATEST NEWS / JOURNAL (With Giant "LATEST NEWS" Watermark) -->
    <section class="py-24 bg-[#080e1a] relative overflow-hidden" id="news">
        <div class="wilmer-watermark">LATEST NEWS</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-14">
                <div>
                    <div class="inline-flex items-center gap-2 mb-2">
                        <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                        <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                            TECHNICAL DISPATCHES
                        </span>
                    </div>
                    <h2 class="font-barlow font-black text-4xl sm:text-5xl text-white uppercase tracking-wider">
                        LATEST NEWS
                    </h2>
                </div>
                <a href="{{ route('public.articles.index') }}" class="font-barlow font-bold text-xs text-[#DFFE40] hover:text-white uppercase tracking-widest flex items-center gap-2">
                    <span>VIEW ALL ARTICLES</span>
                    <i class="ri-arrow-right-line"></i>
                </a>
            </div>

            @php
                $latestNews = \App\Models\Article::with('media')->published()->ordered()->take(3)->get();
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @forelse($latestNews as $article)
                    <div class="wilmer-card group overflow-hidden">
                        <div class="wilmer-badge-sq">■</div>
                        <div class="relative h-60 overflow-hidden">
                            <img src="{{ $article->featured_image ?: asset('images/blog-1.jpg') }}" 
                                 alt="{{ $article->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700 filter contrast-110">
                            <div class="absolute bottom-3 left-3 px-3 py-1 bg-[#DFFE40] text-slate-950 font-black font-barlow font-bold text-xs uppercase tracking-wider">
                                {{ $article->category->name ?? 'ENGINEERING' }}
                            </div>
                        </div>
                        <div class="p-6 space-y-3">
                            <span class="text-[11px] font-mono text-slate-500 uppercase">
                                {{ $article->published_at ? $article->published_at->format('M d, Y') : date('M d, Y') }}
                            </span>
                            <h3 class="font-barlow font-black text-xl text-white uppercase tracking-wide group-hover:text-[#DFFE40] transition-colors line-clamp-2">
                                <a href="{{ route('public.articles.show', $article->slug) }}">{{ $article->title }}</a>
                            </h3>
                            <p class="text-xs text-slate-400 font-light line-clamp-2">
                                {{ Str::limit(strip_tags($article->content), 100) }}
                            </p>
                            <div class="pt-3 border-t border-white/10">
                                <a href="{{ route('public.articles.show', $article->slug) }}" class="text-xs font-barlow font-bold text-[#DFFE40] hover:text-white uppercase tracking-wider flex items-center gap-1">
                                    <span>READ ARTICLE</span>
                                    <i class="ri-arrow-right-line"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    @for($b = 1; $b <= 3; $b++)
                        <div class="wilmer-card group overflow-hidden">
                            <div class="wilmer-badge-sq">■</div>
                            <div class="h-60 overflow-hidden">
                                <img src="{{ asset('images/blog-' . $b . '.jpg') }}" alt="News" class="w-full h-full object-cover">
                            </div>
                            <div class="p-6 space-y-3">
                                <h3 class="font-barlow font-black text-xl text-white uppercase">Advanced Metallurgy in High-Rise Structures</h3>
                                <p class="text-xs text-slate-400 font-light">Site analysis on concrete performance.</p>
                            </div>
                        </div>
                    @endfor
                @endforelse
            </div>
        </div>
    </section>
@endsection
