@extends('themes.default.layouts.app')

@section('title', $title ?? 'Our Engineering & Construction Leadership')

@section('content')
<main id="team-index-page" class="bg-[#fbfbf9] text-slate-900 min-h-screen">

    <!-- 1. Hero Section (Fully Dynamic Website Content) -->
    <section id="team-hero"
        class="relative min-h-[80vh] lg:min-h-[88vh] flex items-center overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-24 bg-[#080c14] text-white border-b border-white/10">

        <!-- Background Cinematic Photography with Multilayer Architectural Gradient -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <img id="team-hero-bg-img"
                src="{{ get_content_image('team', 'hero', 'bg_image', asset('images/experience-team.jpg')) }}"
                alt="Engineering Leadership and Construction Team"
                class="absolute -top-[10%] left-0 w-full h-[125%] object-cover object-center opacity-40 will-change-transform scale-105"
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
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 w-full py-8 lg:py-12">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

                <!-- Left Column: Main Heading, Eyebrow & Jump Actions (8 Cols) -->
                <div class="lg:col-span-8 parallax-text-layers parallax-layers flex flex-col items-start text-left relative will-change-transform">
                    <!-- Back Watermark Parallax Text -->
                    <span class="parallax-text-back back text-white">{{ get_content('team', 'hero', 'watermark', 'LEADERSHIP') }}</span>

                    <!-- Sub Heading / Eyebrow -->
                    <div class="parallax-text-front front sub-heading inline-flex items-center gap-3 mb-6 relative z-10">
                        <span class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#f95716]">
                            {{ get_content('team', 'hero', 'badge', 'OUR LEADERSHIP & ENGINEERS') }}
                        </span>
                    </div>

                    <!-- Main Hero Headline -->
                    <h1 class="parallax-text-mid mid section-title font-heading font-extrabold uppercase text-white tracking-tight leading-[0.98] text-4xl sm:text-6xl md:text-7xl lg:text-[76px] xl:text-[84px] mb-6 sm:mb-8 relative z-10">
                        {!! get_content_html('team', 'hero', 'title', 'The Minds Behind <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Precision</span> Builds.') !!}
                    </h1>

                    <!-- Hero Description -->
                    <p class="text-slate-300 text-base sm:text-lg lg:text-xl font-normal leading-relaxed max-w-2xl m-0 mb-8 sm:mb-10 relative z-10">
                        {{ get_content('team', 'hero', 'description', 'A dedicated team of architects, chartered structural engineers, and project managers committed to delivering safe, resilient, and landmark infrastructure.') }}
                    </p>

                    <!-- Quick Jump Action Links -->
                    <div class="w-full sm:w-auto flex flex-col sm:flex-row items-stretch sm:items-center gap-4 relative z-10">
                        <a href="{{ get_content('team', 'hero', 'btn_1_url', '#directory') }}"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 text-xs sm:text-sm font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all duration-300 rounded-sm shadow-xl shadow-[#f95716]/25 hover:shadow-2xl hover:shadow-[#f95716]/40 hover:scale-[1.02] cursor-pointer">
                            <span>{{ get_content('team', 'hero', 'btn_1_text', 'Explore Team Roster') }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                            </svg>
                        </a>
                        <a href="{{ get_content('team', 'hero', 'btn_2_url', route('contact')) }}"
                            class="inline-flex items-center justify-center gap-2.5 px-8 py-4 text-xs sm:text-sm font-semibold uppercase tracking-wider text-white border border-white/25 hover:border-[#f95716] hover:bg-[#f95716]/10 transition-all duration-300 rounded-sm backdrop-blur-sm">
                            <span>{{ get_content('team', 'hero', 'btn_2_text', 'Consult With Us') }}</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- 2. Team Directory Section (Fully Dynamic Content) -->
    <section id="directory" class="relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] text-slate-900 overflow-hidden border-t border-slate-200/80">

        <!-- Blueprint Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header & Filter / Search Controls -->
            <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-12 sm:mb-16">

                <!-- Left: Title with Watermark -->
                <div class="parallax-text-layers parallax-layers relative will-change-transform">
                    <!-- Watermark -->
                    <span class="parallax-text-back back text-slate-950">{{ get_content('team', 'roster', 'watermark', 'DIRECTORY') }}</span>

                    <!-- Eyebrow -->
                    <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                        <span class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            {{ get_content('team', 'roster', 'badge', 'STAFF DIRECTORY') }}
                        </span>
                    </div>

                    <!-- Title -->
                    <h2 class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[48px] xl:text-[54px] m-0 relative z-10">
                        {!! get_content_html('team', 'roster', 'title', 'Engineering & <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Technical</span> Roster') !!}
                    </h2>
                </div>

                <!-- Right: Search & Department Filter Tabs -->
                <div class="flex flex-col sm:items-start lg:items-end space-y-4 max-w-xl">
                    <p class="text-slate-600 text-sm sm:text-base font-normal leading-relaxed lg:text-right m-0">
                        {{ get_content('team', 'roster', 'subtitle', 'Filter our engineers and project managers by operational discipline or search by name.') }}
                    </p>

                    <!-- Filter Pill Bar & Search Form -->
                    <form action="{{ route('team') }}#directory" method="GET" class="flex flex-wrap items-center gap-2 pt-2">
                        <a href="{{ route('team') }}#directory"
                           class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-300 {{ empty($department) ? 'bg-[#0b0f17] text-white shadow-md' : 'bg-slate-100 hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200/80' }}">
                            All ({{ $teamMembers->count() }})
                        </a>

                        @foreach($departments as $dept)
                            <a href="{{ route('team', ['department' => $dept]) }}#directory"
                               class="px-4 py-2 text-xs font-bold uppercase tracking-wider rounded-full transition-all duration-300 {{ $department === $dept ? 'bg-[#f95716] text-white shadow-md' : 'bg-slate-100 hover:bg-[#f95716] text-slate-700 hover:text-white border border-slate-200/80' }}">
                                {{ $dept }}
                            </a>
                        @endforeach

                        <!-- Search Box -->
                        <div class="relative ml-auto sm:ml-0 mt-2 sm:mt-0">
                            <input type="text" 
                                   name="search" 
                                   value="{{ $search ?? '' }}" 
                                   placeholder="Search by name..." 
                                   class="bg-white text-slate-900 border border-slate-200 rounded-full px-4 py-2 pl-9 text-xs font-medium focus:outline-none focus:border-[#f95716] focus:ring-1 focus:ring-[#f95716] placeholder:text-slate-400 w-48 sm:w-56 shadow-xs">
                            <svg class="w-3.5 h-3.5 text-slate-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>

                        @if($department || $search)
                        <a href="{{ route('team') }}#directory" class="px-3.5 py-2 rounded-full bg-slate-200 hover:bg-slate-300 text-slate-700 text-xs font-bold uppercase tracking-wider transition-colors">
                            Reset
                        </a>
                        @endif
                    </form>
                </div>

            </div>

            <!-- Team Members Grid -->
            @if($teamMembers->isNotEmpty())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 sm:gap-8">
                @foreach($teamMembers as $member)
                <div class="group relative bg-[#f8f7f4] hover:bg-white rounded-2xl overflow-hidden border border-slate-200/80 hover:border-[#f95716]/50 transition-all duration-500 flex flex-col justify-between shadow-xs hover:shadow-xl">
                    
                    <!-- Portrait Visual Plate -->
                    <div class="relative aspect-[4/4.8] overflow-hidden bg-slate-900 rounded-t-2xl">
                        <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105"
                             loading="lazy">
                        
                        <!-- Ambient Gradient Overlay -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                        <!-- Department Badge -->
                        @if($member->department)
                        <div class="absolute top-3.5 left-3.5">
                            <span class="inline-block px-3 py-1 rounded-full bg-white/95 backdrop-blur-md border border-slate-200/80 text-[11px] font-semibold text-slate-800 shadow-xs">
                                {{ $member->department }}
                            </span>
                        </div>
                        @endif

                        <!-- Social Hover Icons -->
                        @if($member->linkedin_url || $member->email)
                        <div class="absolute bottom-3.5 right-3.5 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="w-8 h-8 rounded-full bg-[#f95716] text-white flex items-center justify-center transition-transform hover:scale-110 shadow-md" title="LinkedIn">
                                <svg class="w-3.5 h-3.5 fill-currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.97 0 1.75-.79 1.75-1.76s-.78-1.75-1.75-1.75a1.75 1.75 0 0 0-1.76 1.75c0 .97.79 1.76 1.76 1.76m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
                            </a>
                            @endif
                            @if($member->email)
                            <a href="mailto:{{ $member->email }}" class="w-8 h-8 rounded-full bg-[#f95716] text-white flex items-center justify-center transition-transform hover:scale-110 shadow-md" title="Email">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </a>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Member Card Details -->
                    <div class="p-5 sm:p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-heading font-black uppercase text-slate-900 group-hover:text-[#f95716] transition-colors text-lg sm:text-xl tracking-tight m-0">
                                <a href="{{ route('team.show', $member->id) }}">
                                    {{ $member->name }}
                                </a>
                            </h3>
                            <p class="text-[#f95716] text-xs font-bold uppercase tracking-wider mt-1 mb-2.5">
                                {{ $member->designation }}
                            </p>
                            @if($member->bio)
                            <p class="text-slate-600 text-xs sm:text-sm leading-relaxed line-clamp-2 m-0">
                                {{ $member->bio }}
                            </p>
                            @endif
                        </div>

                        <!-- Action Row -->
                        <div class="pt-4 mt-4 border-t border-slate-200/80 flex items-center justify-between text-xs">
                            <a href="{{ route('team.show', $member->id) }}" class="inline-flex items-center gap-1.5 font-bold uppercase tracking-wider text-slate-800 group-hover:text-[#f95716] transition-colors">
                                <span>View Profile</span>
                                <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </a>

                            @if($member->phone)
                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', $member->phone) }}" class="text-slate-400 hover:text-slate-800 transition-colors" title="{{ $member->phone }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>

                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-16 bg-[#f8f7f4] border border-slate-200/80 rounded-2xl p-8">
                <div class="w-14 h-14 rounded-2xl bg-slate-200/60 text-slate-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900 uppercase tracking-wide mb-1">No team members found</h3>
                <p class="text-slate-500 text-sm mb-5">Try searching with different keywords or clear your active filters.</p>
                <a href="{{ route('team') }}#directory" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-[#f95716] text-white text-xs font-bold uppercase tracking-wider hover:bg-[#ea4907] transition-colors shadow-sm">
                    Reset Filter
                </a>
            </div>
            @endif

        </div>
    </section>

    <!-- 3. Consultation CTA Banner (Fully Dynamic Content) -->
    <section class="py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] border-t border-slate-200/80">
        <div class="container-fluid max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            <div class="bg-gradient-to-r from-[#0f1728] to-[#162035] border border-white/10 rounded-3xl p-8 sm:p-12 lg:p-16 flex flex-col lg:flex-row lg:items-center justify-between gap-8 text-white relative overflow-hidden shadow-2xl">
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-[#f95716]/10 blur-[100px] rounded-full pointer-events-none"></div>
                
                <div class="max-w-2xl relative z-10">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716] block mb-2">
                        {{ get_content('team', 'cta', 'badge', 'CONNECT WITH US') }}
                    </span>
                    <h2 class="font-heading font-black uppercase text-white text-2xl sm:text-3xl lg:text-4xl xl:text-5xl tracking-tight leading-tight m-0 mb-4">
                        {!! nl2br(e(get_content('team', 'cta', 'title', "Have a Project in Mind?\nLet’s Build Together."))) !!}
                    </h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed m-0">
                        {{ get_content('team', 'cta', 'description', 'Our structural engineers, architects, and project superintendents are ready to discuss your plans and guide your project with precision.') }}
                    </p>
                </div>

                <div class="flex flex-wrap items-center gap-4 relative z-10 flex-shrink-0">
                    <a href="{{ get_content('team', 'cta', 'btn_url', route('contact')) }}" class="inline-flex items-center gap-3 px-8 py-4 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-xl shadow-[#f95716]/25 hover:scale-105">
                        <span>{{ get_content('team', 'cta', 'btn_text', 'Get In Touch') }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 17L17 7M17 7H7M17 7V17"/></svg>
                    </a>
                </div>
            </div>
        </div>
    </section>

</main>
@endsection
