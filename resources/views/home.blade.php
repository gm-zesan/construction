@extends('layouts.app')

@section('content')
    <!-- Hero Section -->
    <section id="hero"
        class="relative min-h-[90vh] lg:min-h-screen flex items-center overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-24">

        <!-- Background Photography -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <img id="hero-bg-img" src="{{ asset('images/hero-bg.jpg') }}"
                alt="Commercial construction skyline and structural engineering"
                class="absolute -top-[10%] left-0 w-full h-[120%] object-cover object-center transform will-change-transform scale-105"
                loading="eager" fetchpriority="high">

            <!-- Dark Overlay -->
            <div class="absolute inset-0 bg-[#080c14]/40"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#080c14]/90 via-[#080c14]/80 to-black/50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-black/40"></div>
        </div>

        <!-- Main Container -->
        <div class="relative z-10 w-full max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

                <!-- Left Side: Main Heading & CTAs -->
                <div id="hero-content-col"
                    class="parallax-text-layers parallax-layers lg:col-span-7 flex flex-col items-start text-left relative">
                    <!-- Back Watermark Parallax Text -->
                    <span class="parallax-text-back back text-white">CONSTRUCT</span>

                    <!-- Eyebrow -->
                    <div
                        class="parallax-text-front front inline-flex items-center gap-3 mb-6 relative z-10 animate-fade-in">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-bold tracking-[0.25em] text-[#f95716] uppercase">
                            CONSTRUCTION & DEVELOPMENT
                        </span>
                    </div>

                    <!-- Main Heading -->
                    <h1 id="hero-content"
                        class="parallax-text-mid mid section-title font-heading font-extrabold uppercase text-white tracking-tight leading-[0.96] text-4xl sm:text-6xl md:text-7xl lg:text-8xl mb-8 sm:mb-10 relative z-10 animate-fade-in">
                        Construction, from planning to completion.
                    </h1>

                    <!-- Action Buttons -->
                    <div
                        class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-4 animate-fade-in">

                        <!-- Primary Action -->
                        <a href="#projects"
                            class="inline-flex items-center justify-center px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all duration-200 rounded-sm shadow-lg shadow-[#f95716]/25 hover:shadow-xl hover:shadow-[#f95716]/40">
                            View Projects
                        </a>

                        <!-- Secondary Action -->
                        <a href="#footer"
                            class="inline-flex items-center justify-center px-8 py-4 text-xs sm:text-sm font-semibold uppercase tracking-wider text-white border border-white/30 hover:border-[#f95716] hover:bg-[#f95716]/10 transition-colors rounded-sm">
                            Contact Us
                        </a>

                    </div>

                </div>

                <!-- Right Side: Editorial & Interactive Visuals -->
                <div
                    class="lg:col-span-5 flex flex-col items-start lg:items-end justify-between space-y-8 sm:space-y-10 lg:space-y-12">

                    <!-- Editorial Supporting Text -->
                    <div class="max-w-md lg:text-right animate-fade-in">
                        <p class="text-slate-200 text-sm sm:text-base md:text-lg font-normal leading-relaxed">
                            Projects delivered with careful planning, clear coordination and attention to detail.
                        </p>
                    </div>

                    <!-- Overlapping Circular Action Badge -->
                    <div id="hero-action-badge"
                        class="flex items-center -space-x-3 sm:-space-x-4 lg:self-end animate-fade-in will-change-transform">

                        <!-- Rotating Orange Circular Stamp -->
                        <div
                            class="relative w-20 h-20 sm:w-24 sm:h-24 rounded-full bg-[#f95716] shadow-xl shadow-[#f95716]/20 flex items-center justify-center z-10">
                            <svg class="w-full h-full animate-spin-slow p-1" viewBox="0 0 100 100">
                                <defs>
                                    <path id="textCircle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0" />
                                </defs>
                                <text class="text-[9.5px] font-black uppercase tracking-[2px] fill-white">
                                    <textPath href="#textCircle">
                                        • EXPLORE WORK • VIEW PROJECTS
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
                        <a href="#about"
                            class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-white border-2 border-dashed border-slate-300 flex items-center justify-center text-slate-950 shadow-2xl hover:bg-slate-100 transition-colors duration-200 z-20 group"
                            aria-label="Scroll down to about section">
                            <svg class="w-5 h-5 sm:w-6 sm:h-6 text-slate-950 transition-transform duration-200 group-hover:translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>

                    </div>

                    <!-- Project Snapshot & Stat Badge -->
                    <div id="hero-snapshot-badge"
                        class="flex items-center gap-4 p-3 sm:p-3.5 rounded-lg bg-black/40 border border-white/15 backdrop-blur-md shadow-2xl lg:self-end animate-fade-in will-change-transform">

                        <!-- Construction Thumbnail Photo -->
                        <div
                            class="w-20 h-14 sm:w-24 sm:h-16 rounded-md overflow-hidden flex-shrink-0 border border-white/20 bg-slate-900">
                            <img src="{{ asset('images/hero-project-detail.jpg') }}" alt="Construction engineering project"
                                class="w-full h-full object-cover object-center" loading="lazy">
                        </div>

                        <!-- Stat Highlight -->
                        <div class="pr-2">
                            <div id="hero-stat-number"
                                class="font-heading text-3xl sm:text-4xl font-black text-white leading-none tracking-tight">
                                24k+
                            </div>
                            <div
                                class="text-[11px] sm:text-xs font-semibold text-slate-300 uppercase tracking-wider mt-1 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-[#f95716]"></span>
                                Project Success
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about"
        class="relative py-20 sm:py-28 lg:py-32 bg-[#ffffff] text-slate-900 overflow-hidden border-t border-slate-200">
        <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-12 items-end">

                <!-- Left Column: Previous Content, Mixed Typography, CTA & 01 Project Approach Card -->
                <div class="lg:col-span-5 flex flex-col justify-between space-y-8 z-10">

                    <div>
                        <div class="parallax-text-layers parallax-layers relative">
                            <!-- Back Watermark Parallax Text -->
                            <span class="parallax-text-back back text-slate-950">PRECISION</span>

                            <!-- Eyebrow -->
                            <div
                                class="parallax-text-front front about-fade-el flex items-center gap-3 mb-5 sm:mb-6 relative z-10">
                                <span
                                    class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                                <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-slate-950">
                                    ABOUT CONSTRUCTION
                                </span>
                            </div>

                            <!-- Editorial Heading with Mixed Typography -->
                            <h2
                                class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.02] text-4xl sm:text-5xl lg:text-[50px] xl:text-[56px] mb-6 sm:mb-8 relative z-10">
                                Construction built around <span
                                    class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">precision,</span>
                                planning & detail.
                            </h2>
                        </div>

                        <!-- Description -->
                        <p
                            class="about-fade-el text-slate-600 text-base sm:text-lg font-normal leading-relaxed mb-8 sm:mb-10 max-w-lg">
                            We approach every project with careful planning, coordinated execution and close attention to
                            the details that shape the finished work.
                        </p>

                        <!-- Primary CTA Button -->
                        <div class="about-fade-el">
                            <a href="#projects"
                                class="inline-flex items-center justify-center gap-3 px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all duration-200 rounded-full shadow-lg shadow-[#f95716]/25 hover:shadow-xl hover:shadow-[#f95716]/35 group">
                                <span>DISCOVER MORE</span>
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M7 17L17 7M17 7H7M17 7V17" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Experience Stat Card -->
                    <div id="about-experience-card"
                        class="about-fade-el w-fit min-w-[240px] sm:min-w-[270px] p-6 sm:p-7 bg-[#0b0f17] text-white rounded-2xl border border-white/10 shadow-2xl flex items-center gap-5 sm:gap-6 will-change-transform">
                        <div class="flex items-baseline">
                            <span id="experience-stat-number"
                                class="font-heading text-6xl sm:text-7xl font-extrabold text-white leading-none tracking-tight">12</span>
                            <span class="text-[#f95716] text-3xl sm:text-4xl font-black leading-none ml-1.5">+</span>
                        </div>
                        <div class="border-l border-white/15 pl-4 sm:pl-5">
                            <span
                                class="block text-sm sm:text-base font-bold text-white uppercase tracking-wider leading-tight">
                                Years of
                            </span>
                            <span class="block text-xs sm:text-sm font-medium text-slate-400 tracking-wide mt-0.5">
                                Experience.
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Middle Column: Secondary Project Image (Engineers Discussing Blueprint) -->
                <div class="lg:col-span-3 w-full">
                    <div class="reveal-image-container relative w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-xl ring-1 ring-slate-900/5 bg-[#f95716] group"
                        data-reveal-delay="100">
                        <!-- Theme Color Curtain Overlay -->
                        <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                        <img src="{{ asset('images/about-consulting-duo.jpg') }}"
                            alt="Civil engineers discussing architectural blueprints on construction site"
                            class="reveal-image w-full h-full object-cover object-center" loading="lazy">
                    </div>
                </div>

                <!-- Right Column: Large Primary Project Image (Female Engineer on Site) -->
                <div class="lg:col-span-4 w-full">
                    <div class="reveal-image-container relative w-full aspect-[9/13] rounded-xl overflow-hidden shadow-2xl ring-1 ring-slate-900/5 bg-[#f95716] group"
                        data-reveal-delay="260">
                        <!-- Theme Color Curtain Overlay -->
                        <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                        <img src="{{ asset('images/about-engineer-tablet.jpg') }}"
                            alt="Female civil engineer with digital tablet on building construction site"
                            class="reveal-image w-full h-full object-cover object-center" loading="lazy" />
                    </div>
                </div>
            </div>

        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="relative py-24 sm:py-28 lg:py-36 bg-[#080c14] text-white overflow-hidden">

        <!-- Cinematic Background with Engineers and Site Architecture -->
        <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
            <img id="services-bg-img" src="{{ asset('images/services-bg.jpg') }}"
                alt="Civil engineers reviewing structural plans on commercial construction site"
                class="absolute -top-[12%] left-0 w-full h-[125%] object-cover object-center transform will-change-transform"
                loading="lazy" />

            <!-- Atmospheric Dark Overlays for Photo Visibility & Contrast -->
            <div class="absolute inset-0 bg-[#080c14]/50"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-[#080c14]/70"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#080c14]/60 via-transparent to-[#080c14]/60"></div>
        </div>

        <!-- Main Container -->
        <div class="relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header (Editorial & Mixed Typography) -->
            <div id="services-header"
                class="flex flex-col md:flex-row md:items-end justify-between gap-6 sm:gap-8 mb-14 sm:mb-16 lg:mb-20">
                <div class="parallax-text-layers parallax-layers relative">
                    <!-- Back Watermark Parallax Text -->
                    <span class="parallax-text-back back text-white">SERVICES</span>

                    <!-- Eyebrow -->
                    <div class="parallax-text-front front flex items-center gap-3 mb-4 sm:mb-5 relative z-10">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-[#f95716]">
                            CORE CAPABILITIES
                        </span>
                    </div>

                    <!-- Editorial Headline -->
                    <h2
                        class="parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.02] text-3xl sm:text-5xl lg:text-[54px] xl:text-[60px] relative z-10">
                        Structured Scopes. <br>
                        <span
                            class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">Direct</span>
                        Site Execution.
                    </h2>
                </div>

                <!-- Supporting Lead Copy -->
                <div class="max-w-md">
                    <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed">
                        Clear project scopes, realistic floor cycle timelines, and full-time site superintendence for
                        commercial and structural projects.
                    </p>
                </div>
            </div>

            <!-- Editorial Service Rows -->
            <div id="services-list" class="divide-y divide-white/10 border-t border-b border-white/10">

                <!-- Service Row 01: Design & Planning -->
                <a href="#contact"
                    class="service-row group block py-8 sm:py-10 lg:py-12 transition-all duration-300 hover:bg-white/[0.02]">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8 items-center">
                        <!-- Index & Line -->
                        <div class="lg:col-span-2 flex items-center gap-4">
                            <span
                                class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-slate-500 group-hover:text-[#f95716] transition-colors tracking-tight">
                                01
                            </span>
                            <span
                                class="w-8 h-[1px] bg-white/20 group-hover:w-12 group-hover:bg-[#f95716] transition-all duration-300 hidden sm:block"></span>
                        </div>

                        <!-- Title -->
                        <div class="lg:col-span-4">
                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl lg:text-[32px] text-white group-hover:text-[#f95716] transition-colors tracking-tight leading-snug">
                                Design & Planning
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="lg:col-span-5">
                            <p
                                class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                                Project planning, architectural drafting, structural calculations, and technical site
                                preparation.
                            </p>
                        </div>

                        <!-- Interactive Arrow -->
                        <div class="lg:col-span-1 flex justify-start lg:justify-end mt-2 lg:mt-0">
                            <div
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 flex items-center justify-center text-slate-400 group-hover:border-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Service Row 02: General Construction -->
                <a href="#contact"
                    class="service-row group block py-8 sm:py-10 lg:py-12 transition-all duration-300 hover:bg-white/[0.02]">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8 items-center">
                        <!-- Index & Line -->
                        <div class="lg:col-span-2 flex items-center gap-4">
                            <span
                                class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-slate-500 group-hover:text-[#f95716] transition-colors tracking-tight">
                                02
                            </span>
                            <span
                                class="w-8 h-[1px] bg-white/20 group-hover:w-12 group-hover:bg-[#f95716] transition-all duration-300 hidden sm:block"></span>
                        </div>

                        <!-- Title -->
                        <div class="lg:col-span-4">
                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl lg:text-[32px] text-white group-hover:text-[#f95716] transition-colors tracking-tight leading-snug">
                                General Construction
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="lg:col-span-5">
                            <p
                                class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                                Direct site execution, reinforced concrete framing, steel erection, and superintendent
                                management.
                            </p>
                        </div>

                        <!-- Interactive Arrow -->
                        <div class="lg:col-span-1 flex justify-start lg:justify-end mt-2 lg:mt-0">
                            <div
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 flex items-center justify-center text-slate-400 group-hover:border-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Service Row 03: Project Management -->
                <a href="#contact"
                    class="service-row group block py-8 sm:py-10 lg:py-12 transition-all duration-300 hover:bg-white/[0.02]">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8 items-center">
                        <!-- Index & Line -->
                        <div class="lg:col-span-2 flex items-center gap-4">
                            <span
                                class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-slate-500 group-hover:text-[#f95716] transition-colors tracking-tight">
                                03
                            </span>
                            <span
                                class="w-8 h-[1px] bg-white/20 group-hover:w-12 group-hover:bg-[#f95716] transition-all duration-300 hidden sm:block"></span>
                        </div>

                        <!-- Title -->
                        <div class="lg:col-span-4">
                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl lg:text-[32px] text-white group-hover:text-[#f95716] transition-colors tracking-tight leading-snug">
                                Project Management
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="lg:col-span-5">
                            <p
                                class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                                Critical-path milestone scheduling, trade coordination, and site safety compliance.
                            </p>
                        </div>

                        <!-- Interactive Arrow -->
                        <div class="lg:col-span-1 flex justify-start lg:justify-end mt-2 lg:mt-0">
                            <div
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 flex items-center justify-center text-slate-400 group-hover:border-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Service Row 04: Renovation -->
                <a href="#contact"
                    class="service-row group block py-8 sm:py-10 lg:py-12 transition-all duration-300 hover:bg-white/[0.02]">
                    <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-6 lg:gap-8 items-center">
                        <!-- Index & Line -->
                        <div class="lg:col-span-2 flex items-center gap-4">
                            <span
                                class="font-heading font-black text-2xl sm:text-3xl lg:text-4xl text-slate-500 group-hover:text-[#f95716] transition-colors tracking-tight">
                                04
                            </span>
                            <span
                                class="w-8 h-[1px] bg-white/20 group-hover:w-12 group-hover:bg-[#f95716] transition-all duration-300 hidden sm:block"></span>
                        </div>

                        <!-- Title -->
                        <div class="lg:col-span-4">
                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl lg:text-[32px] text-white group-hover:text-[#f95716] transition-colors tracking-tight leading-snug">
                                Renovation
                            </h3>
                        </div>

                        <!-- Description -->
                        <div class="lg:col-span-5">
                            <p
                                class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                                Interior and structural renovation work, commercial fit-outs, and architectural adaptive
                                reuse.
                            </p>
                        </div>

                        <!-- Interactive Arrow -->
                        <div class="lg:col-span-1 flex justify-start lg:justify-end mt-2 lg:mt-0">
                            <div
                                class="w-11 h-11 sm:w-12 sm:h-12 rounded-full border border-white/15 flex items-center justify-center text-slate-400 group-hover:border-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300">
                                <svg class="w-5 h-5 transform transition-transform duration-300 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </a>

            </div>

        </div>

    </section>

    <!-- Projects Section -->
    <section id="projects"
        class="relative py-24 sm:py-28 lg:py-36 bg-[#ffffff] text-slate-900 overflow-hidden border-t border-slate-200">
        <div class="relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header (Editorial & Filter Tabs) -->
            <div id="projects-header"
                class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-14 sm:mb-16 lg:mb-20">
                <div class="parallax-text-layers parallax-layers relative">
                    <!-- Back Watermark Parallax Text -->
                    <span class="parallax-text-back back text-slate-950">PROJECTS</span>

                    <!-- Eyebrow -->
                    <div class="parallax-text-front front flex items-center gap-3 mb-4 sm:mb-5 relative z-10">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-slate-950">
                            RECENT PROJECTS
                        </span>
                    </div>

                    <!-- Editorial Headline -->
                    <h2
                        class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.02] text-3xl sm:text-5xl lg:text-[54px] xl:text-[60px] relative z-10">
                        Featured
                        <span
                            class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">Engineering
                        </span> <br />
                        & Construction Work
                    </h2>
                </div>

                <!-- Supporting Lead Copy & Filter Tabs -->
                <div class="flex flex-col sm:items-start lg:items-end space-y-6 max-w-md">
                    <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed lg:text-right">
                        Explore our signature portfolio of commercial towers, industrial logistics facilities, civic
                        architecture, and civil infrastructure.
                    </p>

                    <!-- Category Filter Buttons -->
                    <div id="project-filters" class="flex flex-wrap items-center gap-2">
                        <button type="button" data-filter="all"
                            class="project-filter-btn active px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-200 bg-[#0b0f17] text-white shadow-md">
                            All Work
                        </button>
                        <button type="button" data-filter="commercial"
                            class="project-filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-200 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-950">
                            Commercial
                        </button>
                        <button type="button" data-filter="structural"
                            class="project-filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-200 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-950">
                            Structural
                        </button>
                        <button type="button" data-filter="infrastructure"
                            class="project-filter-btn px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-200 bg-slate-100 text-slate-700 hover:bg-slate-200 hover:text-slate-950">
                            Infrastructure
                        </button>
                    </div>
                </div>
            </div>

            <!-- 4-Project Showcase Grid -->
            <div id="projects-grid" class="grid grid-cols-1 md:grid-cols-2 gap-8 lg:gap-10" style="perspective: 1400px;">

                <!-- Project 01: Metropolitan Skyway & Commercial Tower -->
                <article
                    class="project-card group bg-slate-50 rounded-xl overflow-hidden border border-slate-200/80 hover:shadow-lg duration-300 flex flex-col justify-between"
                    data-category="commercial">
                    <div>
                        <!-- Photo Container with Smooth Hover Zoom -->
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-900">
                            <img src="{{ asset('images/project-commercial-tower.jpg') }}"
                                alt="Metropolitan Skyway & Commercial Tower high-rise under construction"
                                class="project-card-img w-full h-full object-cover object-center" loading="lazy" />

                            <!-- Top Gradient Overlay & Badges -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none">
                            </div>

                            <!-- Category Pill (Top Left) -->
                            <div class="absolute top-5 left-5 z-10">
                                <span
                                    class="inline-flex items-center px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                    Commercial High-Rise
                                </span>
                            </div>

                            <!-- Scale / Storey Tag (Bottom Left) -->
                            <div class="absolute bottom-4 left-5 z-10 text-white text-xs font-semibold tracking-wide">
                                <span class="text-[#f95716] font-bold">38 Storeys</span> • Downtown Central Core
                            </div>
                        </div>

                        <!-- Project Content -->
                        <div class="p-6 sm:p-8">
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-xs font-black text-[#f95716] tracking-widest uppercase">01</span>
                                <span class="w-4 h-[1px] bg-slate-300"></span>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Completed
                                    2025</span>
                            </div>

                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl text-slate-950 tracking-tight leading-snug mb-3 group-hover:text-[#f95716] transition-colors">
                                Metropolitan Skyway & Commercial Tower
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-[15px] font-normal leading-relaxed">
                                38-Storey reinforced concrete core, post-tensioned floor slabs, structural steel crown, and
                                unitized curtain wall glazing.
                            </p>
                        </div>
                    </div>

                    <!-- Action Link Footer -->
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-2">
                        <a href="#contact"
                            class="inline-flex items-center justify-between w-full pt-4 border-t border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-950 group-hover:text-[#f95716] transition-colors">
                            <span>VIEW CASE STUDY</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Project 02: Apex Industrial Logistics Hub -->
                <article
                    class="project-card group bg-slate-50 rounded-xl overflow-hidden border border-slate-200/80 hover:shadow-lg duration-300 flex flex-col justify-between"
                    data-category="structural">
                    <div>
                        <!-- Photo Container with Smooth Hover Zoom -->
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-900">
                            <img src="{{ asset('images/project-industrial-hub.jpg') }}"
                                alt="Apex Industrial Logistics Hub pre-engineered steel superstructure"
                                class="project-card-img w-full h-full object-cover object-center" loading="lazy" />

                            <!-- Top Gradient Overlay & Badges -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none">
                            </div>

                            <!-- Category Pill (Top Left) -->
                            <div class="absolute top-5 left-5 z-10">
                                <span
                                    class="inline-flex items-center px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                    Heavy Industrial
                                </span>
                            </div>

                            <!-- Scale Tag (Bottom Left) -->
                            <div class="absolute bottom-4 left-5 z-10 text-white text-xs font-semibold tracking-wide">
                                <span class="text-[#f95716] font-bold">45,000 m²</span> • Metro Industrial Park
                            </div>
                        </div>

                        <!-- Project Content -->
                        <div class="p-6 sm:p-8">
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-xs font-black text-[#f95716] tracking-widest uppercase">02</span>
                                <span class="w-4 h-[1px] bg-slate-300"></span>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Completed
                                    2024</span>
                            </div>

                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl text-slate-950 tracking-tight leading-snug mb-3 group-hover:text-[#f95716] transition-colors">
                                Apex Industrial Logistics Hub
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-[15px] font-normal leading-relaxed">
                                45,000 m² pre-engineered steel superstructure, heavy-duty laser-screeded slab, and automated
                                multi-bay loading docks.
                            </p>
                        </div>
                    </div>

                    <!-- Action Link Footer -->
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-2">
                        <a href="#contact"
                            class="inline-flex items-center justify-between w-full pt-4 border-t border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-950 group-hover:text-[#f95716] transition-colors">
                            <span>VIEW CASE STUDY</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Project 03: Meridian Waterfront Civic Center -->
                <article
                    class="project-card group bg-slate-50 rounded-xl overflow-hidden border border-slate-200/80 hover:shadow-lg duration-300 flex flex-col justify-between"
                    data-category="commercial">
                    <div>
                        <!-- Photo Container with Smooth Hover Zoom -->
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-900">
                            <img src="{{ asset('images/project-civic-center.jpg') }}"
                                alt="Meridian Waterfront Civic Center modern architecture"
                                class="project-card-img w-full h-full object-cover object-center" loading="lazy" />

                            <!-- Top Gradient Overlay & Badges -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none">
                            </div>

                            <!-- Category Pill (Top Left) -->
                            <div class="absolute top-5 left-5 z-10">
                                <span
                                    class="inline-flex items-center px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                    Civic & Institutional
                                </span>
                            </div>

                            <!-- Scale Tag (Bottom Left) -->
                            <div class="absolute bottom-4 left-5 z-10 text-white text-xs font-semibold tracking-wide">
                                <span class="text-[#f95716] font-bold">LEED Gold</span> • Waterfront Plaza
                            </div>
                        </div>

                        <!-- Project Content -->
                        <div class="p-6 sm:p-8">
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-xs font-black text-[#f95716] tracking-widest uppercase">03</span>
                                <span class="w-4 h-[1px] bg-slate-300"></span>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Completed
                                    2025</span>
                            </div>

                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl text-slate-950 tracking-tight leading-snug mb-3 group-hover:text-[#f95716] transition-colors">
                                Meridian Waterfront Civic Center
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-[15px] font-normal leading-relaxed">
                                Long-span steel truss roof, exposed architectural concrete, seismic dampening systems, and
                                LEED Gold energy rating.
                            </p>
                        </div>
                    </div>

                    <!-- Action Link Footer -->
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-2">
                        <a href="#contact"
                            class="inline-flex items-center justify-between w-full pt-4 border-t border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-950 group-hover:text-[#f95716] transition-colors">
                            <span>VIEW CASE STUDY</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Project 04: Crestview Multi-Tier Transit Terminal -->
                <article
                    class="project-card group bg-slate-50 rounded-xl overflow-hidden border border-slate-200/80 hover:shadow-lg duration-300 flex flex-col justify-between"
                    data-category="infrastructure">
                    <div>
                        <!-- Photo Container with Smooth Hover Zoom -->
                        <div class="relative w-full aspect-[16/10] overflow-hidden bg-slate-900">
                            <img src="{{ asset('images/project-transit-terminal.jpg') }}"
                                alt="Crestview Multi-Tier Transit Terminal engineering"
                                class="project-card-img w-full h-full object-cover object-center" loading="lazy" />

                            <!-- Top Gradient Overlay & Badges -->
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-black/20 pointer-events-none">
                            </div>

                            <!-- Category Pill (Top Left) -->
                            <div class="absolute top-5 left-5 z-10">
                                <span
                                    class="inline-flex items-center px-3.5 py-1 text-[11px] font-bold uppercase tracking-wider text-white bg-black/60 backdrop-blur-md border border-white/20 rounded-full">
                                    Civil Infrastructure
                                </span>
                            </div>

                            <!-- Scale Tag (Bottom Left) -->
                            <div class="absolute bottom-4 left-5 z-10 text-white text-xs font-semibold tracking-wide">
                                <span class="text-[#f95716] font-bold">Civil Transit</span> • Multi-Tier Canopy
                            </div>
                        </div>

                        <!-- Project Content -->
                        <div class="p-6 sm:p-8">
                            <div class="flex items-baseline gap-2 mb-2">
                                <span class="text-xs font-black text-[#f95716] tracking-widest uppercase">04</span>
                                <span class="w-4 h-[1px] bg-slate-300"></span>
                                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Completed
                                    2024</span>
                            </div>

                            <h3
                                class="font-heading font-black uppercase text-2xl sm:text-3xl text-slate-950 tracking-tight leading-snug mb-3 group-hover:text-[#f95716] transition-colors">
                                Crestview Multi-Tier Transit Terminal
                            </h3>

                            <p class="text-slate-600 text-sm sm:text-[15px] font-normal leading-relaxed">
                                Heavy structural steel cantilever canopies, precast bridge beams, high-traffic terrazzo
                                flooring, and integrated utility conduits.
                            </p>
                        </div>
                    </div>

                    <!-- Action Link Footer -->
                    <div class="px-6 sm:px-8 pb-6 sm:pb-8 pt-2">
                        <a href="#contact"
                            class="inline-flex items-center justify-between w-full pt-4 border-t border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-950 group-hover:text-[#f95716] transition-colors">
                            <span>VIEW CASE STUDY</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

            </div>

        </div>
    </section>

    <!-- Core Features Section -->
    <section id="features"
        class="feature-section-2 relative py-16 sm:py-20 lg:py-24 bg-[#16171a] text-white overflow-hidden border-t border-white/10">

        <!-- Atmospheric Dark Backdrop -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff03_1px,transparent_1px),linear-gradient(to_bottom,#ffffff03_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="row flex flex-col xl:flex-row items-center xl:items-stretch gap-8 xl:gap-10">

                <!-- Col-XL-4: Left Feature Content (Heading & Floating White Quote Box) -->
                <div class="col-xl-4 w-full xl:w-[32%] flex-shrink-0">
                    <div id="features-left-col"
                        class="feature-content-left-2 flex flex-col justify-between h-full max-h-[465px] space-y-6 xl:space-y-0">

                        <!-- Section Heading -->
                        <div class="parallax-text-layers parallax-layers section-heading white-content relative">
                            <!-- Back Watermark Parallax Text -->
                            <span class="parallax-text-back back text-white">INTERIOR</span>

                            <!-- Sub Heading / Eyebrow -->
                            <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 relative z-10">
                                <span
                                    class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                                <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-300">
                                    Interior Execution
                                </span>
                            </div>

                            <!-- Section Title -->
                            <h2
                                class="parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] relative z-10">
                                Interior Work, <br>
                                <span
                                    class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">From
                                    Plan</span>
                                <br>
                                To Finish
                            </h2>
                        </div>

                        <!-- Feature Box (Floating White Quote Card) -->
                        <div id="features-quote-card"
                            class="feature-box bg-white rounded-xl p-5 shadow-2xl text-slate-900 border border-slate-100 max-w-2xs will-change-transform mt-auto">
                            <p
                                class="desc font-heading font-extrabold uppercase text-slate-950 text-xs sm:text-sm leading-snug tracking-tight mb-3.5">
                                “Coordinated drywall framing, MEP routing &amp; architectural finishes delivered to spec.”
                            </p>

                            <!-- Author Client Wrap -->
                            <div class="author-client-wrap space-y-2.5 pt-3 border-t border-slate-100">
                                <ul class="author-list flex items-center -space-x-2.5 list-none p-0 m-0">
                                    <li>
                                        <img src="{{ asset('images/about-engineer-tablet.jpg') }}"
                                            alt="Alexander Joseph Reed"
                                            class="w-10 h-10 rounded-full object-cover object-top border-2 border-white shadow-md bg-slate-900"
                                            loading="lazy" />
                                    </li>
                                    <li
                                        class="icon w-6.5 h-6.5 rounded-full bg-[#f95716] text-white flex items-center justify-center font-bold text-[11px] shadow-md border-2 border-white flex-shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M12 4v16m8-8H4" />
                                        </svg>
                                    </li>
                                </ul>
                                <div>
                                    <h3
                                        class="name font-heading font-bold uppercase text-slate-950 text-sm sm:text-[15px] leading-tight tracking-tight m-0">
                                        Alexander Joseph Reed
                                    </h3>
                                    <span class="text-xs font-semibold text-slate-500 tracking-wide block mt-0.5">Founder
                                        &amp; CEO</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Col-XL-8: Right Feature Content (Focal Photo + 3 Stacked Feature Items) -->
                <div class="col-xl-8 w-full xl:w-[68%] flex-grow">
                    <div
                        class="feature-content-right-2 flex flex-col lg:flex-row items-center lg:items-stretch gap-3 h-full max-h-[465px]">

                        <!-- Image 1: Large Focal Collaboration Photo (Controlled Compact Height) -->
                        <div id="features-center-col" class="image-1 w-full lg:w-[60%] xl:w-[62%] flex-shrink-0 h-full">
                            <div
                                class="relative w-full h-full min-h-[340px] max-h-[465px] rounded-xl overflow-hidden shadow-2xl ring-1 ring-white/10">
                                <img id="features-focal-img" src="{{ asset('images/features-team-collaboration.jpg') }}"
                                    alt="Architectural design team collaborating on interior projects"
                                    class="w-full h-full object-cover object-center block" loading="lazy" />

                                <!-- Subtle Edge Vignette -->
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/30 via-transparent to-black/10 pointer-events-none">
                                </div>
                            </div>
                        </div>

                        <!-- Feature Items Wrap: 3 Stacked Cards (Slightly Reduced Width) -->
                        <div id="features-right-col"
                            class="feature-items-wrap w-full lg:w-[40%] xl:w-[38%] flex flex-col justify-between gap-3 flex-grow h-full max-h-[465px]">

                            <!-- Feature Item 1: Structural Detailing -->
                            <div
                                class="feature-item-2 rounded-xl bg-[#202226] border border-white/[0.08] p-4.5 sm:p-5 shadow-xl flex flex-col justify-center group hover:border-[#f95716]/40 transition-colors">
                                <div class="icon text-[#f95716] mb-2.5">
                                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                                    </svg>
                                </div>
                                <h3
                                    class="title font-heading font-black uppercase text-base sm:text-xl text-white tracking-tight leading-snug mb-1 group-hover:text-[#f95716] transition-colors">
                                    Structural Accuracy & Detailing
                                </h3>
                                <p class="desc text-slate-400 text-xs sm:text-[13px] font-normal leading-relaxed m-0">
                                    Detailed shop drawings and rebar schedules for clean on-site fabrication.
                                </p>
                            </div>

                            <!-- Feature Item 2: MEP Coordination -->
                            <div
                                class="feature-item-2 rounded-xl bg-[#202226] border border-white/[0.08] p-4.5 sm:p-5 shadow-xl flex flex-col justify-center group hover:border-[#f95716]/40 transition-colors">
                                <div class="icon text-[#f95716] mb-2.5">
                                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M8 3h8v2H8V3z" />
                                    </svg>
                                </div>
                                <h3
                                    class="title font-heading font-black uppercase text-base sm:text-xl text-white tracking-tight leading-snug mb-1 group-hover:text-[#f95716] transition-colors">
                                    Spatial & MEP Coordination
                                </h3>
                                <p class="desc text-slate-400 text-xs sm:text-[13px] font-normal leading-relaxed m-0">
                                    Clash-free routing between structural reinforced concrete and mechanical runs.
                                </p>
                            </div>

                            <!-- Feature Item 3: Off-Site Prefabrication -->
                            <div
                                class="feature-item-2 rounded-xl bg-[#202226] border border-white/[0.08] p-4.5 sm:p-5 shadow-xl flex flex-col justify-center group hover:border-[#f95716]/40 transition-colors">
                                <div class="icon text-[#f95716] mb-2.5">
                                    <svg class="w-5.5 h-5.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <h3
                                    class="title font-heading font-black uppercase text-base sm:text-xl text-white tracking-tight leading-snug mb-1 group-hover:text-[#f95716] transition-colors">
                                    Modular Prefabrication
                                </h3>
                                <p class="desc text-slate-400 text-xs sm:text-[13px] font-normal leading-relaxed m-0">
                                    Pre-assembled steel sections reducing active crane time and floor cycles.
                                </p>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section id="why-choose-us"
        class="why-choose-section relative py-16 sm:py-20 lg:py-24 bg-white text-slate-900 overflow-hidden border-t border-slate-100">

        <!-- Atmospheric Subtle Blueprint Grid Motif -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-start">

                <!-- Top-Left Column (5 Cols): Eyebrow, Heading & Lead Description -->
                <div id="why-choose-left-col" class="lg:col-span-5 flex flex-col justify-between space-y-6">
                    <div class="parallax-text-layers parallax-layers relative">
                        <!-- Back Watermark Parallax Text -->
                        <span class="parallax-text-back back text-slate-950">EXPERTISE</span>

                        <!-- Sub Heading / Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                Our Approach
                            </span>
                        </div>

                        <!-- Section Title -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] relative z-10">
                            Practical Construction, <br>
                            <span
                                class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Carefully</span>
                            Delivered
                        </h2>
                    </div>

                    <!-- Lead Paragraph -->
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-lg mt-4 sm:mt-6 font-normal">
                        We manage builds through accurate material planning, direct trade superintendence, and clear
                        milestone reporting from groundbreaking to project closeout.
                    </p>

                    <!-- Bottom-Left: Stat Card (22 Completed Contracts) -->
                    <div id="why-choose-stat-card"
                        class="flex items-center gap-4 sm:gap-5 pt-4 sm:pt-6 border-t border-slate-100 mt-4 will-change-transform">
                        <!-- Crane Thumbnail -->
                        <div
                            class="w-24 sm:w-28 h-18 sm:h-20 rounded-xl overflow-hidden shadow-md flex-shrink-0 ring-1 ring-slate-900/10 bg-slate-900">
                            <img src="{{ asset('images/why-choose-crane.jpg') }}"
                                alt="Tower crane over concrete building structure"
                                class="w-full h-full object-cover object-center block" loading="lazy" />
                        </div>

                        <!-- Counter & Label -->
                        <div>
                            <div
                                class="flex items-baseline font-heading font-black text-4xl sm:text-5xl text-slate-950 tracking-tight leading-none">
                                <span id="why-choose-counter" data-target="22">0</span>
                                <span class="text-[#f95716]">+</span>
                            </div>
                            <p
                                class="text-xs sm:text-[13px] font-bold uppercase tracking-wider text-slate-500 mt-1 sm:mt-1.5 m-0">
                                Completed Builds
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Right Column (7 Cols): Landscape Photo & Two Feature Cards -->
                <div id="why-choose-right-col" class="lg:col-span-7 flex flex-col space-y-8 sm:space-y-10">

                    <!-- Landscape Photographic Container with Curtain Reveal -->
                    <div id="why-choose-img-box"
                        class="reveal-image-container relative w-full aspect-[16/9] sm:aspect-[16/8.8] rounded-xl lg:rounded-2xl overflow-hidden shadow-2xl ring-1 ring-slate-900/10 bg-[#f95716]">
                        <!-- Theme Color Curtain Overlay -->
                        <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                        <img id="why-choose-main-img" src="{{ asset('images/why-choose-engineers.jpg') }}"
                            alt="Civil engineers reviewing blueprints on active construction site"
                            class="reveal-image w-full h-full object-cover object-center block" loading="lazy" />

                        <!-- Subtle Edge Vignette -->
                        <div
                            class="absolute inset-0 z-20 bg-gradient-to-t from-black/25 via-transparent to-transparent pointer-events-none">
                        </div>
                    </div>

                    <!-- Two Feature Items Side by Side -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 sm:gap-8 pt-2">

                        <!-- Feature Item 1: Tested Materials & Sourcing -->
                        <div class="why-choose-feature-item group flex flex-col will-change-transform">
                            <!-- Icon Badge -->
                            <div
                                class="why-choose-icon-badge w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-[#f95716]/10 border border-[#f95716]/20 flex items-center justify-center text-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300 shadow-sm mb-3.5">
                                <!-- Custom Structural Tools / Material SVG -->
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path
                                        d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z" />
                                    <path d="m3 21 6.91-6.91" />
                                </svg>
                            </div>
                            <h3
                                class="font-heading font-black uppercase text-lg sm:text-xl text-slate-900 tracking-tight leading-snug mb-1 group-hover:text-[#f95716] transition-colors">
                                Tested Materials &amp; Sourcing
                            </h3>
                            <p class="text-slate-500 text-xs sm:text-[13px] font-normal leading-relaxed m-0">
                                Certified grade structural steel, batch-tested concrete, and verified supplier supply
                                chains.
                            </p>
                        </div>

                        <!-- Feature Item 2: On-Site Superintendent Control -->
                        <div class="why-choose-feature-item group flex flex-col will-change-transform">
                            <!-- Icon Badge -->
                            <div
                                class="why-choose-icon-badge w-12 h-12 sm:w-13 sm:h-13 rounded-full bg-[#f95716]/10 border border-[#f95716]/20 flex items-center justify-center text-[#f95716] group-hover:bg-[#f95716] group-hover:text-white transition-all duration-300 shadow-sm mb-3.5">
                                <!-- Custom Dedicated Engineering & Safety Badge SVG -->
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                                    <path d="m9 12 2 2 4-4" />
                                </svg>
                            </div>
                            <h3
                                class="font-heading font-black uppercase text-lg sm:text-xl text-slate-900 tracking-tight leading-snug mb-1 group-hover:text-[#f95716] transition-colors">
                                On-Site Superintendent Control
                            </h3>
                            <p class="text-slate-500 text-xs sm:text-[13px] font-normal leading-relaxed m-0">
                                Full-time field engineers reviewing structural tolerances, subcontractor safety, and
                                daily QA logs.
                            </p>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Experience & CTA Section -->
    <section id="experience"
        class="experience-section relative py-16 sm:py-20 lg:py-24 bg-[#101216] text-white overflow-hidden border-t border-white/10">

        <!-- Atmospheric Dark Backdrop Matrix -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-30">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Top Half: Team Photo & Section Heading / CTA -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 xl:gap-16 items-center">

                <!-- Left Col (6 Cols): Landscape Photo Container with Curtain Reveal -->
                <div class="lg:col-span-6 w-full">
                    <div id="experience-img-box"
                        class="reveal-image-container relative w-full aspect-[16/10] sm:aspect-[16/9.5] rounded-xl lg:rounded-2xl overflow-hidden shadow-2xl ring-1 ring-white/10 bg-[#f95716]">
                        <!-- Theme Color Curtain Overlay -->
                        <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                        <img id="experience-main-img" src="{{ asset('images/experience-team.jpg') }}"
                            alt="Civil engineers collaborating on architectural construction drawings"
                            class="reveal-image w-full h-full object-cover object-center block" loading="lazy" />

                        <!-- Subtle Edge Vignette -->
                        <div
                            class="absolute inset-0 z-20 bg-gradient-to-t from-black/40 via-transparent to-black/10 pointer-events-none">
                        </div>
                    </div>
                </div>

                <!-- Right Col (6 Cols): Eyebrow, Heading, Paragraph & Action CTAs -->
                <div id="experience-right-col" class="lg:col-span-6 flex flex-col justify-center space-y-6">
                    <div class="parallax-text-layers parallax-layers relative">
                        <!-- Back Watermark Parallax Text -->
                        <span class="parallax-text-back back text-white">DELIVERY</span>

                        <!-- Sub Heading / Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                Project Track Record
                            </span>
                        </div>

                        <!-- Section Title -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] relative z-10">
                            Planned Work. <br>
                            <span
                                class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Controlled</span>
                            Execution.
                        </h2>
                    </div>

                    <!-- Action CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4 pt-2 sm:pt-4">
                        <a href="#footer"
                            class="inline-flex items-center gap-2.5 px-7 py-3.5 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white font-heading font-black text-xs sm:text-sm uppercase tracking-wider shadow-lg shadow-[#f95716]/25 transition-all duration-300 group">
                            <span>DISCUSS A PROJECT</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                        <a href="#projects"
                            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-full border border-white/20 hover:border-[#f95716] hover:bg-[#f95716]/10 text-white font-heading font-bold text-xs sm:text-sm uppercase tracking-wider transition-all duration-300">
                            <span>VIEW RECENT SITES</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Bottom Half: 4 Metric Cards Grid -->
            <div id="experience-cards-grid"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6 pt-12 sm:pt-16">

                <!-- Metric Card 1: 240+ Commercial Builds (Light Off-White) -->
                <div
                    class="experience-stat-card group bg-[#f8fafc] text-slate-900 rounded-xl p-6 sm:p-7 shadow-2xl flex flex-col justify-between transition-all duration-300 will-change-transform">
                    <!-- Checkmark Badge -->
                    <div
                        class="w-8 h-8 rounded-full bg-[#f95716] text-white flex items-center justify-center shadow-md mb-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Big Numeric Counter -->
                    <div
                        class="font-heading font-black text-4xl sm:text-5xl text-slate-950 tracking-tight leading-none mb-3">
                        <span class="exp-counter" data-target="240">0</span><span class="text-[#f95716]">+</span>
                    </div>

                    <!-- Title & Context -->
                    <div>
                        <h3
                            class="font-heading font-black uppercase text-base sm:text-lg text-slate-950 tracking-tight leading-snug m-0">
                            Commercial Builds
                        </h3>
                        <p class="text-slate-500 text-xs font-normal leading-relaxed mt-1 m-0">
                            Delivered under direct site supervision.
                        </p>
                    </div>
                </div>

                <!-- Metric Card 2: 99% Milestone Compliance (Signature Brand Orange) -->
                <div
                    class="experience-stat-card group bg-[#f95716] text-white rounded-xl p-6 sm:p-7 shadow-2xl shadow-[#f95716]/20 flex flex-col justify-between transition-all duration-300 will-change-transform">
                    <!-- Checkmark Badge -->
                    <div
                        class="w-8 h-8 rounded-full bg-white text-[#f95716] flex items-center justify-center shadow-md mb-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Big Numeric Counter -->
                    <div class="font-heading font-black text-4xl sm:text-5xl text-white tracking-tight leading-none mb-3">
                        <span class="exp-counter" data-target="99">0</span><span class="text-white">%</span>
                    </div>

                    <!-- Title & Context -->
                    <div>
                        <h3
                            class="font-heading font-black uppercase text-base sm:text-lg text-white tracking-tight leading-snug m-0">
                            Milestone Compliance
                        </h3>
                        <p class="text-white/80 text-xs font-normal leading-relaxed mt-1 m-0">
                            On-schedule stage completions &amp; handovers.
                        </p>
                    </div>
                </div>

                <!-- Metric Card 3: 12+ Years In Field (Deep Midnight Charcoal) -->
                <div
                    class="experience-stat-card group bg-[#181a1f] border border-white/10 text-white rounded-xl p-6 sm:p-7 shadow-2xl flex flex-col justify-between transition-all duration-300 will-change-transform">
                    <!-- Checkmark Badge -->
                    <div
                        class="w-8 h-8 rounded-full bg-white/10 border border-white/20 text-white flex items-center justify-center shadow-md mb-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Big Numeric Counter -->
                    <div class="font-heading font-black text-4xl sm:text-5xl text-white tracking-tight leading-none mb-3">
                        <span class="exp-counter" data-target="12">0</span><span class="text-[#f95716]">+</span>
                    </div>

                    <!-- Title & Context -->
                    <div>
                        <h3
                            class="font-heading font-black uppercase text-base sm:text-lg text-white tracking-tight leading-snug m-0">
                            Years In Field
                        </h3>
                        <p class="text-slate-400 text-xs font-normal leading-relaxed mt-1 m-0">
                            Continuous active contractor operations.
                        </p>
                    </div>
                </div>

                <!-- Metric Card 4: 180+ Trade Specialists (Light Off-White) -->
                <div
                    class="experience-stat-card group bg-[#f8fafc] text-slate-900 rounded-xl p-6 sm:p-7 shadow-2xl flex flex-col justify-between transition-all duration-300 will-change-transform">
                    <!-- Checkmark Badge -->
                    <div
                        class="w-8 h-8 rounded-full bg-[#f95716] text-white flex items-center justify-center shadow-md mb-4 flex-shrink-0">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Big Numeric Counter -->
                    <div
                        class="font-heading font-black text-4xl sm:text-5xl text-slate-950 tracking-tight leading-none mb-3">
                        <span class="exp-counter" data-target="180">0</span><span class="text-[#f95716]">+</span>
                    </div>

                    <!-- Title & Context -->
                    <div>
                        <h3
                            class="font-heading font-black uppercase text-base sm:text-lg text-slate-950 tracking-tight leading-snug m-0">
                            Trade Specialists
                        </h3>
                        <p class="text-slate-500 text-xs font-normal leading-relaxed mt-1 m-0">
                            Certified steel erectors, formworkers &amp; operators.
                        </p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- Testimonials Section -->
    <section id="testimonials"
        class="testimonials-section relative py-16 sm:py-20 lg:py-24 bg-white text-slate-900 overflow-hidden border-t border-slate-100">

        <!-- Atmospheric Subtle Blueprint Grid Motif -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header -->
            <div id="testimonials-header"
                class="parallax-text-layers parallax-layers mb-10 sm:mb-14 will-change-transform relative">
                <!-- Back Watermark Parallax Text -->
                <span class="parallax-text-back back text-slate-950">FEEDBACK</span>

                <!-- Sub Heading / Eyebrow -->
                <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                    <span
                        class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                        Client Feedback
                    </span>
                </div>

                <!-- Section Title -->
                <h2
                    class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] relative z-10">
                    Direct Feedback From <br>
                    Project <span
                        class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Owners</span>
                    &amp; Developers
                </h2>
            </div>

            <!-- 3-Column Main Content Row with Swiper JS Carousel -->
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 xl:gap-12 items-stretch">

                <!-- 9 Cols: Swiper Carousel Container (Quote Card + Client Portrait) -->
                <div class="lg:col-span-9 w-full min-w-0">
                    <div id="testimonial-swiper-box" class="swiper testimonial-swiper w-full h-full will-change-transform">
                        <div class="swiper-wrapper">

                            <!-- Slide 1: Aylani Rowyn -->
                            <div class="swiper-slide h-full">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 items-stretch h-full">
                                    <!-- Quote Card (7 Cols) -->
                                    <div class="md:col-span-7 flex flex-col">
                                        <div
                                            class="bg-[#f4f3ef] rounded-xl p-7 sm:p-9 lg:p-10 border border-slate-100 flex flex-col justify-between h-full">
                                            <div>
                                                <!-- Double Quote Mark Icon -->
                                                <div class="text-[#f95716] mb-5 sm:mb-6">
                                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 opacity-90" viewBox="0 0 24 24"
                                                        fill="currentColor">
                                                        <path
                                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                                    </svg>
                                                </div>

                                                <p
                                                    class="text-slate-800 text-sm sm:text-base lg:text-lg font-normal leading-relaxed m-0">
                                                    From site preparation through structural topping-out, their
                                                    superintendent
                                                    team maintained rigid milestone control, direct subcontractor
                                                    management,
                                                    and clear weekly lookahead schedules on our multi-storey commercial
                                                    build.
                                                </p>
                                            </div>

                                            <div class="pt-6 sm:pt-8 border-t border-slate-200/60 mt-6 sm:mt-8">
                                                <h3
                                                    class="font-heading font-black uppercase text-slate-950 text-lg sm:text-xl tracking-tight leading-tight m-0">
                                                    Aylani Rowyn
                                                </h3>
                                                <span
                                                    class="text-xs sm:text-[13px] font-semibold text-slate-500 tracking-wide block mt-1">
                                                    Founder &amp; CEO, Horizon Developments
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Client Portrait Photo (5 Cols) -->
                                    <div class="md:col-span-5 flex flex-col h-full">
                                        <div
                                            class="relative w-full h-full min-h-[260px] md:min-h-0 rounded-xl overflow-hidden ring-1 ring-slate-900/10 bg-slate-100">
                                            <img src="{{ asset('images/testimonial-1.jpg') }}" alt="Aylani Rowyn"
                                                class="w-full h-full object-cover object-center block" loading="lazy" />
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent pointer-events-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2: Elena Rostova -->
                            <div class="swiper-slide h-full">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 items-stretch h-full">
                                    <!-- Quote Card (7 Cols) -->
                                    <div class="md:col-span-7 flex flex-col">
                                        <div
                                            class="bg-[#f4f3ef] rounded-xl p-7 sm:p-9 lg:p-10 border border-slate-100 flex flex-col justify-between h-full">
                                            <div>
                                                <!-- Double Quote Mark Icon -->
                                                <div class="text-[#f95716] mb-5 sm:mb-6">
                                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 opacity-90" viewBox="0 0 24 24"
                                                        fill="currentColor">
                                                        <path
                                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                                    </svg>
                                                </div>

                                                <p
                                                    class="text-slate-800 text-sm sm:text-base lg:text-lg font-normal leading-relaxed m-0">
                                                    From initial structural calculations through multi-tier steel framing
                                                    and final QA handover, their engineering team demonstrated unmatched
                                                    precision, proactive communication, and zero milestone delay.
                                                </p>
                                            </div>

                                            <div class="pt-6 sm:pt-8 border-t border-slate-200/60 mt-6 sm:mt-8">
                                                <h3
                                                    class="font-heading font-black uppercase text-slate-950 text-lg sm:text-xl tracking-tight leading-tight m-0">
                                                    Elena Rostova
                                                </h3>
                                                <span
                                                    class="text-xs sm:text-[13px] font-semibold text-slate-500 tracking-wide block mt-1">
                                                    Director of Infrastructure, Metro Transit Group
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Client Portrait Photo (5 Cols) -->
                                    <div class="md:col-span-5 flex flex-col h-full">
                                        <div
                                            class="relative w-full h-full min-h-[260px] md:min-h-0 rounded-xl overflow-hidden ring-1 ring-slate-900/10 bg-slate-100">
                                            <img src="{{ asset('images/testimonial-2.jpg') }}" alt="Elena Rostova"
                                                class="w-full h-full object-cover object-center block" loading="lazy" />
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent pointer-events-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3: David Sterling -->
                            <div class="swiper-slide h-full">
                                <div class="grid grid-cols-1 md:grid-cols-12 gap-6 sm:gap-8 lg:gap-10 items-stretch h-full">
                                    <!-- Quote Card (7 Cols) -->
                                    <div class="md:col-span-7 flex flex-col">
                                        <div
                                            class="bg-[#f4f3ef] rounded-xl p-7 sm:p-9 lg:p-10 border border-slate-100 flex flex-col justify-between h-full">
                                            <div>
                                                <!-- Double Quote Mark Icon -->
                                                <div class="text-[#f95716] mb-5 sm:mb-6">
                                                    <svg class="w-10 h-10 sm:w-12 sm:h-12 opacity-90" viewBox="0 0 24 24"
                                                        fill="currentColor">
                                                        <path
                                                            d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                                    </svg>
                                                </div>

                                                <p
                                                    class="text-slate-800 text-sm sm:text-base lg:text-lg font-normal leading-relaxed m-0">
                                                    Their team managed our 45,000 m² industrial logistics facility with
                                                    exceptional discipline. Clear weekly BIM reporting, proactive safety
                                                    management, and flawless execution from ground-breaking to handover.
                                                </p>
                                            </div>

                                            <div class="pt-6 sm:pt-8 border-t border-slate-200/60 mt-6 sm:mt-8">
                                                <h3
                                                    class="font-heading font-black uppercase text-slate-950 text-lg sm:text-xl tracking-tight leading-tight m-0">
                                                    David Sterling
                                                </h3>
                                                <span
                                                    class="text-xs sm:text-[13px] font-semibold text-slate-500 tracking-wide block mt-1">
                                                    Managing Partner, Apex Logistics Real Estate
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Client Portrait Photo (5 Cols) -->
                                    <div class="md:col-span-5 flex flex-col h-full">
                                        <div
                                            class="relative w-full h-full min-h-[260px] md:min-h-0 rounded-xl overflow-hidden ring-1 ring-slate-900/10 bg-slate-100">
                                            <img src="{{ asset('images/testimonial-3.jpg') }}" alt="David Sterling"
                                                class="w-full h-full object-cover object-center block" loading="lazy" />
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/25 via-transparent to-transparent pointer-events-none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Col 3 (Right 3 Cols): 12K Metric & Navigation Buttons -->
                <div id="testimonial-metrics-col"
                    class="lg:col-span-3 flex flex-col justify-between py-2 sm:py-4 space-y-8 will-change-transform">

                    <!-- 12+ Years Counter -->
                    <div>
                        <div
                            class="font-heading font-black text-5xl sm:text-7xl lg:text-8xl text-slate-950 tracking-tight leading-none mb-3">
                            <span id="testimonial-counter" data-target="12">0</span><span class="text-[#f95716]">+</span>
                        </div>
                        <p class="text-slate-600 text-xs sm:text-sm font-normal leading-relaxed m-0 max-w-xs">
                            Years of repeat commercial developer partnerships and general contracting delivery.
                        </p>
                    </div>

                    <!-- Swiper Navigation Arrows -->
                    <div class="flex items-center gap-3 pt-4">
                        <button type="button"
                            class="testimonial-swiper-prev w-12 h-12 rounded-full bg-slate-100 hover:bg-[#f95716] hover:text-white text-slate-700 flex items-center justify-center transition-all duration-300 cursor-pointer focus:outline-none"
                            aria-label="Previous Testimonial">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                        </button>
                        <button type="button"
                            class="testimonial-swiper-next w-12 h-12 rounded-full bg-slate-100 hover:bg-[#f95716] hover:text-white text-slate-700 flex items-center justify-center transition-all duration-300 cursor-pointer focus:outline-none"
                            aria-label="Next Testimonial">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </button>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- News & Insights Section -->
    <section id="news"
        class="news-section relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] text-slate-900 overflow-hidden border-t border-slate-200/70">

        <!-- Atmospheric Blueprint Matrix Grid Motif -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header Row -->
            <div id="news-header-row"
                class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-12 sm:mb-16 will-change-transform">
                <!-- Left: Eyebrow + Headline -->
                <div class="parallax-text-layers parallax-layers max-w-2xl relative">
                    <!-- Back Watermark Parallax Text -->
                    <span class="parallax-text-back back text-slate-950">UPDATES</span>

                    <!-- Sub Heading / Eyebrow -->
                    <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                        <span
                            class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            Field Logs &amp; Updates
                        </span>
                    </div>

                    <!-- Section Title -->
                    <h2
                        class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] m-0 relative z-10">
                        Jobsite Notes, Methods &amp; <br>
                        <span
                            class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Field</span>
                        Updates
                    </h2>
                </div>

                <!-- Right: All Field Notes Pill CTA -->
                <div class="flex-shrink-0">
                    <a href="#news"
                        class="group inline-flex items-center gap-2.5 px-6 sm:px-7 py-3 sm:py-3.5 rounded-full bg-slate-950 hover:bg-[#f95716] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-md hover:shadow-lg hover:shadow-[#f95716]/25">
                        <span>All Field Notes</span>
                        <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M7 17L17 7M17 7H7M17 7V17" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- 3-Column News / Insights Grid -->
            <div id="news-cards-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8 lg:gap-10">

                <!-- Card 1: Site Progress Update -->
                <article
                    class="news-card group bg-[#f4f3ef] rounded-2xl p-5 sm:p-6 border border-slate-200/80 flex flex-col justify-between transition-all duration-300 hover:border-slate-300/80 will-change-transform">
                    <div>
                        <!-- Card Image Wrapper -->
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden mb-6 bg-slate-200">
                            <img src="{{ asset('images/blog-1.jpg') }}"
                                alt="Site Progress Update — Metropolitan Commercial Tower"
                                class="news-card-img w-full h-full object-cover object-center block transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
                                loading="lazy" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none">
                            </div>
                        </div>

                        <!-- Meta: Date Badge & Category -->
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-white text-slate-800 text-xs font-bold uppercase tracking-wider ring-1 ring-slate-900/5 shadow-sm">
                                Feb 18, 2026
                            </span>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Site Progress • 3 min
                            </span>
                        </div>

                        <!-- Article Title -->
                        <h3
                            class="font-heading font-bold uppercase text-slate-950 text-xl sm:text-2xl tracking-tight leading-tight mb-3 transition-colors duration-200 group-hover:text-[#f95716]">
                            <a href="#news" class="focus:outline-none">
                                Site Progress Update — Metropolitan Commercial Tower
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-600 text-sm font-normal leading-relaxed m-0 mb-6 line-clamp-2">
                            Core shear wall concrete pours reach level 24 with perimeter curtain wall installation
                            actively progressing on lower tiers.
                        </p>
                    </div>

                    <!-- Read More Action Link -->
                    <div class="pt-4 border-t border-slate-200/70">
                        <a href="#news"
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-900 group-hover:text-[#f95716] transition-colors duration-200">
                            <span>Read Update</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Card 2: Choosing Structural Systems -->
                <article
                    class="news-card group bg-[#f4f3ef] rounded-2xl p-5 sm:p-6 border border-slate-200/80 flex flex-col justify-between transition-all duration-300 hover:border-slate-300/80 will-change-transform">
                    <div>
                        <!-- Card Image Wrapper -->
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden mb-6 bg-slate-200">
                            <img src="{{ asset('images/blog-2.jpg') }}"
                                alt="Choosing Structural Systems for Large Buildings"
                                class="news-card-img w-full h-full object-cover object-center block transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
                                loading="lazy" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none">
                            </div>
                        </div>

                        <!-- Meta: Date Badge & Category -->
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-white text-slate-800 text-xs font-bold uppercase tracking-wider ring-1 ring-slate-900/5 shadow-sm">
                                Jan 29, 2026
                            </span>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Engineering • 5 min
                            </span>
                        </div>

                        <!-- Article Title -->
                        <h3
                            class="font-heading font-bold uppercase text-slate-950 text-xl sm:text-2xl tracking-tight leading-tight mb-3 transition-colors duration-200 group-hover:text-[#f95716]">
                            <a href="#news" class="focus:outline-none">
                                Choosing Structural Systems for Large Buildings
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-600 text-sm font-normal leading-relaxed m-0 mb-6 line-clamp-2">
                            A comparative look at cast-in-place post-tensioned concrete versus structural steel framing for
                            floor vibration control and MEP integration.
                        </p>
                    </div>

                    <!-- Read More Action Link -->
                    <div class="pt-4 border-t border-slate-200/70">
                        <a href="#news"
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-900 group-hover:text-[#f95716] transition-colors duration-200">
                            <span>Read Article</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

                <!-- Card 3: Project Handover -->
                <article
                    class="news-card group bg-[#f4f3ef] rounded-2xl p-5 sm:p-6 border border-slate-200/80 flex flex-col justify-between transition-all duration-300 hover:border-slate-300/80 will-change-transform">
                    <div>
                        <!-- Card Image Wrapper -->
                        <div class="relative w-full aspect-[16/10] rounded-xl overflow-hidden mb-6 bg-slate-200">
                            <img src="{{ asset('images/blog-3.jpg') }}"
                                alt="Project Handover — Apex Industrial Logistics Hub"
                                class="news-card-img w-full h-full object-cover object-center block transition-transform duration-700 ease-out group-hover:scale-105 will-change-transform"
                                loading="lazy" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/20 via-transparent to-transparent pointer-events-none">
                            </div>
                        </div>

                        <!-- Meta: Date Badge & Category -->
                        <div class="flex items-center gap-3 mb-4">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-white text-slate-800 text-xs font-bold uppercase tracking-wider ring-1 ring-slate-900/5 shadow-sm">
                                Jan 12, 2026
                            </span>
                            <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">
                                Completion • 4 min
                            </span>
                        </div>

                        <!-- Article Title -->
                        <h3
                            class="font-heading font-bold uppercase text-slate-950 text-xl sm:text-2xl tracking-tight leading-tight mb-3 transition-colors duration-200 group-hover:text-[#f95716]">
                            <a href="#news" class="focus:outline-none">
                                Project Handover — Apex Industrial Logistics Hub
                            </a>
                        </h3>

                        <!-- Excerpt -->
                        <p class="text-slate-600 text-sm font-normal leading-relaxed m-0 mb-6 line-clamp-2">
                            Final occupancy certification, automated loading bay commissioning, and client facility handover
                            completed two weeks ahead of schedule.
                        </p>
                    </div>

                    <!-- Read More Action Link -->
                    <div class="pt-4 border-t border-slate-200/70">
                        <a href="#news"
                            class="inline-flex items-center gap-2 text-xs sm:text-sm font-bold uppercase tracking-wider text-slate-900 group-hover:text-[#f95716] transition-colors duration-200">
                            <span>Read Note</span>
                            <svg class="w-4 h-4 text-[#f95716] transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M7 17L17 7M17 7H7M17 7V17" />
                            </svg>
                        </a>
                    </div>
                </article>

            </div>

        </div>
    </section>
@endsection