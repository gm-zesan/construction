@extends('layouts.app')

@section('title', $title ?? ($member->name . ' — ' . $member->designation))

@section('content')
<main id="team-show-page" class="bg-[#fbfbf9] text-slate-900 min-h-screen">

    <!-- 1. Hero Section (Consistent Cinematic Dark Theme with other pages) -->
    <section id="team-member-hero"
        class="relative min-h-[60vh] lg:min-h-[68vh] flex items-center overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-20 bg-[#080c14] text-white border-b border-white/10">

        <!-- Background Cinematic Photography with Multilayer Architectural Gradient -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <img src="{{ asset('images/hero-project-detail.jpg') }}"
                alt="{{ $member->name }}"
                class="absolute -top-[10%] left-0 w-full h-[125%] object-cover object-center opacity-30 will-change-transform scale-105"
                loading="eager" fetchpriority="high" />
            <div class="absolute inset-0 bg-[#080c14]/50"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#080c14]/95 via-[#080c14]/85 to-black/60"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-black/50"></div>
            <!-- Atmospheric Architectural Blueprint Matrix Grid -->
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 w-full py-6 sm:py-8">
            
            <!-- Breadcrumbs & Back Row -->
            <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
                <nav class="flex items-center gap-2 text-xs uppercase tracking-widest text-slate-400 font-semibold" aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="hover:text-[#f95716] transition-colors">Home</a>
                    <span class="text-slate-600">/</span>
                    <a href="{{ route('team') }}" class="hover:text-[#f95716] transition-colors">Team</a>
                    <span class="text-slate-600">/</span>
                    <span class="text-[#f95716]">{{ $member->name }}</span>
                </nav>

                <a href="{{ route('team') }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 hover:bg-white/20 border border-white/15 text-xs font-bold uppercase tracking-wider text-slate-200 hover:text-white transition-colors backdrop-blur-sm">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    <span>Back to Directory</span>
                </a>
            </div>

            <!-- Profile Header Intro -->
            <div class="parallax-text-layers parallax-layers flex flex-col items-start text-left relative will-change-transform max-w-4xl">
                <!-- Watermark -->
                <span class="parallax-text-back back text-white">PROFILE</span>

                <!-- Sub Heading / Eyebrow -->
                <div class="parallax-text-front front sub-heading inline-flex items-center gap-3 mb-4 relative z-10">
                    <span class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                    <span class="text-xs sm:text-sm font-bold uppercase tracking-[0.25em] text-[#f95716]">
                        {{ $member->department ?: 'ENGINEERING LEADERSHIP' }}
                    </span>
                </div>

                <!-- Name & Title -->
                <h1 class="parallax-text-mid mid section-title font-heading font-extrabold uppercase text-white tracking-tight leading-[1.02] text-3xl sm:text-5xl md:text-6xl lg:text-7xl m-0 mb-3 relative z-10">
                    {{ $member->name }}
                </h1>
                <p class="text-lg sm:text-2xl font-bold text-[#f95716] m-0 relative z-10">
                    {{ $member->designation }}
                </p>
            </div>

        </div>
    </section>

    <!-- 2. Profile Details Section (Matching the site's Light Theme design) -->
    <section class="relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] text-slate-900 overflow-hidden border-t border-slate-200/80">

        <!-- Blueprint Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                
                <!-- Left Column: Portrait & Direct Contact Card (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="bg-[#f8f7f4] rounded-2xl overflow-hidden border border-slate-200/80 p-6 sm:p-8 shadow-xs">
                        
                        <!-- Portrait Image Plate -->
                        <div class="relative aspect-[4/4.8] rounded-xl overflow-hidden bg-slate-900 shadow-sm mb-6">
                            <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                                 alt="{{ $member->name }}" 
                                 class="w-full h-full object-cover object-top"
                                 loading="eager">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent pointer-events-none"></div>

                            @if($member->is_featured)
                            <div class="absolute top-4 left-4">
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-[#f95716] text-white text-[11px] font-bold uppercase tracking-wider shadow-md">
                                    Leadership Team
                                </span>
                            </div>
                            @endif
                        </div>

                        <!-- Contact List -->
                        <div class="space-y-4 pt-2 border-t border-slate-200/80">
                            @if($member->department)
                            <div class="flex items-center justify-between text-xs sm:text-sm">
                                <span class="text-slate-500 uppercase tracking-wider font-semibold text-[11px]">Department</span>
                                <span class="font-bold text-slate-900">{{ $member->department }}</span>
                            </div>
                            @endif

                            @if($member->email)
                            <div class="flex items-center justify-between text-xs sm:text-sm">
                                <span class="text-slate-500 uppercase tracking-wider font-semibold text-[11px]">Email</span>
                                <a href="mailto:{{ $member->email }}" class="text-slate-800 hover:text-[#f95716] transition-colors font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#f95716]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <span>{{ $member->email }}</span>
                                </a>
                            </div>
                            @endif

                            @if($member->phone)
                            <div class="flex items-center justify-between text-xs sm:text-sm">
                                <span class="text-slate-500 uppercase tracking-wider font-semibold text-[11px]">Phone</span>
                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $member->phone) }}" class="text-slate-800 hover:text-[#f95716] transition-colors font-medium flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#f95716]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                                    <span>{{ $member->phone }}</span>
                                </a>
                            </div>
                            @endif
                        </div>

                        <!-- Social Media Profiles -->
                        @if($member->linkedin_url || $member->twitter_url || $member->facebook_url)
                        <div class="pt-5 mt-5 border-t border-slate-200/80 flex items-center justify-center gap-2.5">
                            @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-full bg-white hover:bg-[#f95716] hover:text-white text-slate-700 text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-colors border border-slate-200/80 shadow-xs" title="LinkedIn">
                                <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.97 0 1.75-.79 1.75-1.76s-.78-1.75-1.75-1.75a1.75 1.75 0 0 0-1.76 1.75c0 .97.79 1.76 1.76 1.76m1.39 9.74v-8.37H5.07v8.37h2.78z"/></svg>
                                <span>LinkedIn</span>
                            </a>
                            @endif
                            @if($member->twitter_url)
                            <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-full bg-white hover:bg-[#f95716] hover:text-white text-slate-700 text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-colors border border-slate-200/80 shadow-xs" title="Twitter / X">
                                <svg class="w-3.5 h-3.5 fill-currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                <span>Twitter</span>
                            </a>
                            @endif
                            @if($member->facebook_url)
                            <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener noreferrer" class="px-4 py-2 rounded-full bg-white hover:bg-[#f95716] hover:text-white text-slate-700 text-xs font-bold uppercase tracking-wider flex items-center gap-2 transition-colors border border-slate-200/80 shadow-xs" title="Facebook">
                                <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24"><path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/></svg>
                                <span>Facebook</span>
                            </a>
                            @endif
                        </div>
                        @endif

                    </div>
                </div>

                <!-- Right Column: Biography & Consultation Box (7 Cols) -->
                <div class="lg:col-span-7 space-y-8">
                    
                    <!-- Biography Card -->
                    <div class="bg-[#f8f7f4] rounded-2xl border border-slate-200/80 p-6 sm:p-8 lg:p-10 shadow-xs">
                        <div class="flex items-center gap-2.5 mb-4">
                            <span class="blueprint-line inline-block w-8 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                PROFESSIONAL BIOGRAPHY
                            </span>
                        </div>
                        <h2 class="font-heading font-black uppercase text-slate-950 text-2xl sm:text-3xl tracking-tight mb-6">
                            About {{ $member->name }}
                        </h2>
                        <div class="text-slate-700 text-base sm:text-lg leading-relaxed space-y-4">
                            @if($member->bio)
                                <p class="m-0">{{ $member->bio }}</p>
                            @else
                                <p class="m-0">Dedicated construction and engineering specialist managing complex multidisciplinary builds, technical compliance, and high-performance structural delivery.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Direct Project Consultation Box -->
                    <div class="bg-gradient-to-r from-[#0f1728] to-[#162035] border border-white/10 rounded-2xl p-6 sm:p-8 lg:p-10 text-white flex flex-col sm:flex-row items-start sm:items-center justify-between gap-6 shadow-xl relative overflow-hidden">
                        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-[#f95716]/10 blur-[80px] rounded-full pointer-events-none"></div>

                        <div class="relative z-10">
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716] block mb-1">Direct Consultation</span>
                            <h3 class="font-heading font-black uppercase text-white text-xl sm:text-2xl tracking-tight m-0">
                                Have a project for {{ explode(' ', $member->name)[0] }}?
                            </h3>
                            <p class="text-slate-300 text-xs sm:text-sm mt-1.5 m-0 max-w-md">
                                Reach out directly or contact our team to discuss blueprints, engineering specs, or site plans.
                            </p>
                        </div>
                        <a href="{{ route('contact') }}" class="px-7 py-3.5 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white text-xs font-bold uppercase tracking-wider transition-all duration-300 flex-shrink-0 shadow-lg shadow-[#f95716]/20 hover:scale-105 relative z-10">
                            Contact Us
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </section>

    <!-- 3. Related Team Members Section (Matching the site's Light Theme design) -->
    @if($relatedMembers->isNotEmpty())
    <section class="relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] border-t border-slate-200/80">

        <!-- Blueprint Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
            
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-12 pb-6 border-b border-slate-200/80">
                <div class="parallax-text-layers parallax-layers relative will-change-transform">
                    <span class="parallax-text-back back text-slate-950">PEERS</span>
                    <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-2 relative z-10">
                        <span class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            DEPARTMENT PEERS
                        </span>
                    </div>
                    <h2 class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-2xl sm:text-3xl lg:text-4xl m-0 relative z-10">
                        Fellow Engineers &amp; Directors
                    </h2>
                </div>

                <a href="{{ route('team') }}" class="text-xs font-bold uppercase tracking-wider text-slate-600 hover:text-[#f95716] transition-colors flex items-center gap-1.5 flex-shrink-0">
                    <span>Full Directory</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedMembers as $peer)
                <div class="group relative bg-[#f8f7f4] hover:bg-white rounded-2xl overflow-hidden border border-slate-200/80 hover:border-[#f95716]/50 transition-all duration-500 flex flex-col justify-between shadow-xs hover:shadow-xl">
                    <div class="relative aspect-[4/4.8] overflow-hidden bg-slate-900 rounded-t-2xl">
                        <img src="{{ $peer->photo_url ?: asset('images/team-1.jpg') }}" alt="{{ $peer->name }}" class="w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105" loading="lazy">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>
                        @if($peer->department)
                        <div class="absolute top-3.5 left-3.5">
                            <span class="inline-block px-3 py-1 rounded-full bg-white/95 backdrop-blur-md text-[11px] font-semibold text-slate-800 shadow-xs border border-slate-200/80">
                                {{ $peer->department }}
                            </span>
                        </div>
                        @endif
                    </div>
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <h3 class="font-heading font-black uppercase text-slate-900 group-hover:text-[#f95716] transition-colors text-lg sm:text-xl tracking-tight m-0">
                                <a href="{{ route('team.show', $peer->id) }}">{{ $peer->name }}</a>
                            </h3>
                            <p class="text-[#f95716] text-xs font-bold uppercase tracking-wider mt-1 mb-3">{{ $peer->designation }}</p>
                        </div>
                        <a href="{{ route('team.show', $peer->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-slate-800 group-hover:text-[#f95716] transition-colors pt-4 border-t border-slate-200/80">
                            <span>View Profile</span>
                            <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
                @endforeach
            </div>

        </div>
    </section>
    @endif

</main>
@endsection
