@extends('layouts.app')

@section('content')
    <!-- 1. About Hero Section -->
    <section id="about-hero"
        class="relative min-h-[85vh] lg:min-h-[98vh] flex items-center justify-center pt-28 pb-16 sm:pt-32 sm:pb-20 lg:pt-36 lg:pb-24 overflow-hidden bg-[#0b0f17] text-white">

        <!-- Background Cinematic Image with Architectural Gradient Wash -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <img id="about-hero-bg-img"
                src="{{ get_content_image('about', 'hero', 'bg_image', asset('images/hero-bg.jpg')) }}"
                alt="Construction Engineering Architecture"
                class="absolute -top-[10%] left-0 w-full h-[125%] object-cover object-center opacity-60 will-change-transform" />
            <div class="absolute inset-0 bg-gradient-to-r from-[#0b0f17]/95 via-[#0b0f17]/75 to-[#0b0f17]/45"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-[#0b0f17] via-transparent to-[#0b0f17]/60"></div>
            <!-- Atmospheric Architectural Blueprint Matrix Grid -->
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <!-- Container Fluid -->
        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 w-full">

            <!-- Header Content Box with Parallax Layering -->
            <div class="parallax-text-layers parallax-layers relative max-w-4xl will-change-transform">
                <!-- Back Watermark Parallax Text -->
                <span
                    class="parallax-text-back back text-white">{{ get_content('about', 'hero', 'watermark', 'HERITAGE') }}</span>

                <!-- Sub Heading / Eyebrow -->
                <div
                    class="about-hero-fade parallax-text-front front sub-heading flex items-center gap-2.5 mb-4 sm:mb-5 relative z-10">
                    <span
                        class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                        {{ get_content('about', 'hero', 'badge', 'ABOUT OUR ENTERPRISE') }}
                    </span>
                </div>

                <!-- Main Hero Headline -->
                <h1
                    class="about-hero-fade parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.03] text-4xl sm:text-5xl md:text-6xl lg:text-[68px] xl:text-[76px] m-0 mb-6 relative z-10">
                    {!! get_content('about', 'hero', 'title', 'Engineering Structures With <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">Uncompromising</span> Precision.') !!}
                </h1>

                <!-- Hero Description -->
                <p
                    class="about-hero-fade text-slate-300 text-base sm:text-lg lg:text-xl font-normal leading-relaxed max-w-2xl m-0 mb-8 sm:mb-10">
                    {{ get_content('about', 'hero', 'description', 'For over a decade, we have partnered with institutional developers and project owners to deliver high-performance commercial towers, industrial hubs, and resilient civic infrastructure.') }}
                </p>

                <!-- Action Jump Buttons -->
                <div class="about-hero-fade flex flex-wrap items-center gap-4 sm:gap-6 pt-2">
                    <a href="{{ get_content('about', 'hero', 'btn_1_url', '#chairmans-message') }}"
                        class="inline-flex items-center gap-2.5 px-6 sm:px-8 py-3.5 sm:py-4 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 shadow-xl shadow-[#f95716]/30 hover:scale-[1.02]">
                        <span>{{ get_content('about', 'hero', 'btn_1_text', "Chairman's Speech") }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                        </svg>
                    </a>
                    <a href="{{ get_content('about', 'hero', 'btn_2_url', '#core-values') }}"
                        class="inline-flex items-center gap-2.5 px-6 sm:px-8 py-3.5 sm:py-4 rounded-full bg-white/10 hover:bg-white/20 text-white text-xs sm:text-sm font-bold uppercase tracking-wider transition-all duration-300 border border-white/15 backdrop-blur-sm">
                        <span>{{ get_content('about', 'hero', 'btn_2_text', 'Our Standards') }}</span>
                    </a>
                </div>
            </div>

        </div>

    </section>

    <!-- 2. Corporate Story & Origins Section -->
    <section id="company-story"
        class="company-story-section relative py-16 sm:py-20 lg:py-24 bg-[#fbfbf9] text-slate-900 overflow-hidden border-t border-slate-200/80">

        <!-- Blueprint Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 xl:gap-16 items-center">

                <!-- Left Column: Story & Narrative (6 Cols) -->
                <div class="lg:col-span-6 space-y-6">

                    <!-- Section Header -->
                    <div class="story-fade-el parallax-text-layers parallax-layers relative will-change-transform">
                        <!-- Watermark -->
                        <span
                            class="parallax-text-back back text-slate-950">{{ get_content('about', 'story', 'watermark', 'ORIGINS') }}</span>

                        <!-- Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                {{ get_content('about', 'story', 'badge', 'Our Origins & Mission') }}
                            </span>
                        </div>

                        <!-- Section Title -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[46px] xl:text-[52px] m-0 relative z-10">
                            {!! get_content('about', 'story', 'title', 'Pioneering Heavy Civil & <br>Commercial <span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Execution</span>') !!}
                        </h2>
                    </div>

                    <!-- Narrative Body Paragraphs -->
                    <div
                        class="story-fade-el space-y-4 text-slate-700 text-sm sm:text-base lg:text-[17px] font-normal leading-relaxed pt-2">
                        <p class="m-0">
                            {{ get_content('about', 'story', 'description_1', 'Established in 2012, Antigravity Construction began with a disciplined focus on deep foundation engineering, geotechnical stabilization, and structural reinforced concrete frames.') }}
                        </p>
                        <p class="m-0">
                            {{ get_content('about', 'story', 'description_2', 'Today, our integrated multidisciplinary engineering and superintendent teams manage full-lifecycle EPC contracts across major metropolitan sectors. We eliminate construction risk through rigorous 5D BIM clash detection, daily QA/QC inspection regimes, and zero-compromise site safety governance.') }}
                        </p>
                    </div>

                    <!-- Highlights Checklist (Staggered separately) -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4 border-t border-slate-200/80">
                        <div class="story-checklist-item flex items-center gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#f95716]/10 text-[#f95716] flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-900">
                                {{ get_content('about', 'story', 'checklist_1', 'Direct Field Supervision') }}
                            </span>
                        </div>
                        <div class="story-checklist-item flex items-center gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#f95716]/10 text-[#f95716] flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-900">
                                {{ get_content('about', 'story', 'checklist_2', '100% In-House Heavy Plant') }}
                            </span>
                        </div>
                        <div class="story-checklist-item flex items-center gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#f95716]/10 text-[#f95716] flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-900">
                                {{ get_content('about', 'story', 'checklist_3', 'BIM 5D Digital Telemetry') }}
                            </span>
                        </div>
                        <div class="story-checklist-item flex items-center gap-3">
                            <div
                                class="w-6 h-6 rounded-full bg-[#f95716]/10 text-[#f95716] flex items-center justify-center flex-shrink-0">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <span class="text-xs sm:text-sm font-bold uppercase tracking-wide text-slate-900">
                                {{ get_content('about', 'story', 'checklist_4', 'Milestone Guarantee') }}
                            </span>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Dual-Image Reveal Plate (6 Cols) -->
                <div class="lg:col-span-6 relative">
                    <div class="grid grid-cols-12 gap-4 sm:gap-6 items-end">

                        <!-- Main Tall Construction Image (7 Cols) -->
                        <div class="col-span-7">
                            <div
                                class="reveal-image-container relative aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl bg-slate-200 ring-1 ring-slate-900/10">
                                <div class="reveal-curtain absolute inset-0 bg-[#f95716] z-10 pointer-events-none"></div>
                                <img src="{{ get_content_image('about', 'story', 'main_image', asset('images/about-main.jpg')) }}"
                                    alt="Heavy Civil Construction Operations"
                                    class="reveal-image w-full h-full object-cover object-center block" loading="lazy" />
                            </div>
                        </div>

                        <!-- Secondary Offset Image & Stat Card (5 Cols) -->
                        <div class="col-span-5 space-y-4 sm:space-y-6">
                            <!-- Detail Photo -->
                            <div class="reveal-image-container relative aspect-square rounded-2xl overflow-hidden shadow-xl bg-slate-200 ring-1 ring-slate-900/10"
                                data-reveal-delay="150">
                                <div class="reveal-curtain absolute inset-0 bg-[#0b0f17] z-10 pointer-events-none"></div>
                                <img src="{{ get_content_image('about', 'story', 'secondary_image', asset('images/about-secondary.jpg')) }}"
                                    alt="Structural Steel Detailing"
                                    class="reveal-image w-full h-full object-cover object-center block" loading="lazy" />
                            </div>

                            <!-- Experience Metric Card -->
                            <div
                                class="story-stat-card bg-[#0b0f17] text-white rounded-2xl p-5 sm:p-6 shadow-2xl border border-white/10 flex flex-col justify-between">
                                <div
                                    class="font-heading font-black text-4xl sm:text-5xl text-white tracking-tight leading-none mb-2">
                                    <span>{{ get_content('about', 'story', 'exp_years', '12') }}</span><span
                                        class="text-[#f95716]">{{ get_content('about', 'story', 'exp_suffix', '+') }}</span>
                                </div>
                                <div class="text-xs font-bold uppercase tracking-wider text-slate-300">
                                    {{ get_content('about', 'story', 'exp_title', 'Years of Continuous') }}
                                    <span
                                        class="text-white block mt-0.5">{{ get_content('about', 'story', 'exp_subtitle', 'Contractor Delivery.') }}</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- 3. Chairman's Message & Leadership Speech Section -->
    <section id="chairmans-message"
        class="chairmans-message-section relative py-16 sm:py-20 lg:py-28 bg-[#0d131f] text-white overflow-hidden border-t border-white/10">

        <!-- Ambient Atmospheric Grid and Light Cone -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-30">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
            <div class="absolute -top-40 -left-40 w-96 h-96 rounded-full bg-[#f95716]/10 blur-3xl pointer-events-none">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 xl:gap-16 items-center">

                <!-- Left Column: Chairman Executive Portrait (5 Cols) -->
                <div class="lg:col-span-5 flex flex-col justify-center">
                    <div class="relative w-full max-w-md mx-auto lg:max-w-none">

                        <!-- Main Portrait Photo with Curtain Reveal -->
                        <div
                            class="reveal-image-container relative aspect-[3/4] rounded-2xl overflow-hidden shadow-2xl bg-slate-800 ring-1 ring-white/15">
                            <div class="reveal-curtain absolute inset-0 bg-[#f95716] z-10 pointer-events-none"></div>
                            <img src="{{ get_content_image('about', 'chairman_speech', 'chairman_image', asset('images/about-engineer-tablet.jpg')) }}"
                                alt="{{ get_content('about', 'chairman_speech', 'chairman_name', 'Alexander Joseph Reed') }}"
                                class="reveal-image w-full h-full object-cover object-top block" loading="lazy" />
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent pointer-events-none">
                            </div>

                            <!-- Floating Badge at Base of Portrait -->
                            <div
                                class="absolute bottom-6 left-6 right-6 p-4 rounded-xl bg-[#0b0f17]/90 backdrop-blur-md border border-white/10">
                                <h3
                                    class="font-heading font-black uppercase text-white text-lg tracking-tight leading-tight m-0">
                                    {{ get_content('about', 'chairman_speech', 'chairman_name', 'Alexander Joseph Reed') }}
                                </h3>
                                <p class="text-[#f95716] text-xs font-semibold tracking-wider uppercase mt-1 m-0">
                                    {{ get_content('about', 'chairman_speech', 'chairman_role', 'Founder & Executive Chairman') }}
                                </p>
                                <span class="text-slate-400 text-[11px] font-mono tracking-wide block mt-1">
                                    {{ get_content('about', 'chairman_speech', 'chairman_credentials', 'FIEB, CEng, MSc Structural Engineering') }}
                                </span>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Speech & Vision Content (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">

                    <!-- Parallax Eyebrow & Title Layer -->
                    <div class="chairman-fade-el parallax-text-layers parallax-layers relative will-change-transform">
                        <!-- Watermark -->
                        <span
                            class="parallax-text-back back text-white">{{ get_content('about', 'chairman_speech', 'watermark', 'VISION') }}</span>

                        <!-- Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                {{ get_content('about', 'chairman_speech', 'badge', "Chairman's Address") }}
                            </span>
                        </div>

                        <!-- Main Speech Heading -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[46px] xl:text-[52px] m-0 relative z-10">
                            {!! get_content('about', 'chairman_speech', 'title', 'Building With Purpose, <br>Delivering With <span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Integrity</span>') !!}
                        </h2>
                    </div>

                    <!-- Highlighted Leadership Pull Quote -->
                    <div
                        class="chairman-quote-box relative bg-[#161d2b] rounded-xl p-6 sm:p-7 border-l-4 border-[#f95716] border border-white/5 my-6 shadow-xl">
                        <!-- Quote Icon -->
                        <div class="text-[#f95716] mb-3 opacity-90">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor">
                                <path
                                    d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                            </svg>
                        </div>
                        <p class="text-white text-base sm:text-lg lg:text-xl font-medium leading-relaxed italic m-0">
                            {{ get_content('about', 'chairman_speech', 'quote_highlight', '“We measure our success not by the height of our towers, but by the permanence of our craftsmanship and the safety of every craftsman on our jobsites.”') }}
                        </p>
                    </div>

                    <!-- Chairman Speech Multi-Paragraph Body -->
                    <div class="chairman-paragraph space-y-4 text-slate-300 text-sm sm:text-base leading-relaxed">
                        <p class="m-0">
                            {{ get_content('about', 'chairman_speech', 'speech_p1', 'When we established this enterprise over twelve years ago, our guiding conviction was simple: exceptional construction is not merely about pouring concrete or assembling structural steel—it is about honoring the trust placed in us by developers, communities, and future generations who will inhabit these spaces.') }}
                        </p>
                        <p class="m-0">
                            {{ get_content('about', 'chairman_speech', 'speech_p2', 'In an era where urban development demands unprecedented speed, precision, and sustainability, we have never allowed expediency to compromise structural integrity or worker safety. Every project site under our supervision operates as a sanctuary of discipline, modern engineering telemetry, and transparent communication.') }}
                        </p>
                        <p class="m-0">
                            {{ get_content('about', 'chairman_speech', 'speech_p3', 'As we look toward the next decade, our focus remains steadfast on adopting low-carbon materials, 5D BIM digital workflows, and modular engineering innovations that shape iconic skylines while safeguarding environmental benchmarks. We thank our partners, engineers, and workforce for building this enduring legacy with us.') }}
                        </p>
                    </div>

                    <!-- Official Sign-off and Stylized Signature -->
                    <div class="chairman-signature flex items-center justify-between pt-6 border-t border-white/10">
                        <div>
                            <span
                                class="font-sketch text-2xl sm:text-3xl font-bold text-[#f95716] tracking-wider block -rotate-2">
                                {{ get_content('about', 'chairman_speech', 'signature_name', 'Alexander J. Reed') }}
                            </span>
                            <span class="text-xs uppercase tracking-widest text-slate-400 font-semibold block mt-1">
                                {{ get_content('about', 'chairman_speech', 'signature_title', "Executive Chairman's Desk") }}
                            </span>
                        </div>
                        <div class="text-right">
                            <span
                                class="inline-block px-3 py-1 rounded-md bg-[#f95716]/10 text-[#f95716] text-xs font-bold uppercase tracking-wider border border-[#f95716]/20">
                                {{ get_content('about', 'chairman_speech', 'est_badge', 'Est. 2012') }}
                            </span>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- 4. Milestones Journey Timeline Section (Scroll-Pinned Title on Right) -->
    <section id="evolution-timeline"
        class="evolution-timeline-section relative py-20 sm:py-24 lg:py-28 bg-white text-slate-900 overflow-hidden border-t border-slate-100">

        <!-- Blueprint Subtle Grid -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-40">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 xl:gap-20 items-start">

                <!-- Left Column: Chronological Timeline Content (7 Cols) -->
                <div id="evolution-timeline-content" class="order-2 lg:order-1 lg:col-span-7 xl:col-span-7">
                    <div class="relative border-l-2 border-slate-200 ml-4 sm:ml-8 md:ml-10 pl-6 sm:pl-10 space-y-12">

                        <!-- Timeline Item 1: 2012 -->
                        <div class="relative group">
                            <!-- Node Bullet Marker -->
                            <div
                                class="absolute -left-[35px] sm:-left-[51px] top-2 w-6 h-6 rounded-full bg-white border-4 border-[#f95716] shadow-md group-hover:scale-125 transition-transform duration-300">
                            </div>
                            <div
                                class="bg-[#f4f3ef] hover:bg-slate-50 transition-colors duration-300 rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                                <div
                                    class="inline-block px-3 py-1 rounded-md bg-[#f95716] text-white text-xs font-bold uppercase tracking-wider mb-3">
                                    {{ get_content('about', 'timeline', 'item_1_year', '2012') }}
                                </div>
                                <h3
                                    class="font-heading font-black uppercase text-slate-950 text-xl sm:text-2xl tracking-tight mb-2">
                                    {{ get_content('about', 'timeline', 'item_1_title', 'Enterprise Founding & Geotechnical Inception') }}
                                </h3>
                                <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                                    {{ get_content('about', 'timeline', 'item_1_desc', 'Commenced operations specializing in high-capacity cast-in-situ bored piling and complex basement shoring solutions.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 2: 2016 -->
                        <div class="relative group">
                            <div
                                class="absolute -left-[35px] sm:-left-[51px] top-2 w-6 h-6 rounded-full bg-white border-4 border-[#f95716] shadow-md group-hover:scale-125 transition-transform duration-300">
                            </div>
                            <div
                                class="bg-[#f4f3ef] hover:bg-slate-50 transition-colors duration-300 rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                                <div
                                    class="inline-block px-3 py-1 rounded-md bg-slate-950 text-white text-xs font-bold uppercase tracking-wider mb-3">
                                    {{ get_content('about', 'timeline', 'item_2_year', '2016') }}
                                </div>
                                <h3
                                    class="font-heading font-black uppercase text-slate-950 text-xl sm:text-2xl tracking-tight mb-2">
                                    {{ get_content('about', 'timeline', 'item_2_title', 'Expansion to Full General Contracting') }}
                                </h3>
                                <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                                    {{ get_content('about', 'timeline', 'item_2_desc', 'Mobilized dedicated structural, mechanical, and architectural superintendent divisions for full-scale commercial builds.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 3: 2020 -->
                        <div class="relative group">
                            <div
                                class="absolute -left-[35px] sm:-left-[51px] top-2 w-6 h-6 rounded-full bg-white border-4 border-[#f95716] shadow-md group-hover:scale-125 transition-transform duration-300">
                            </div>
                            <div
                                class="bg-[#f4f3ef] hover:bg-slate-50 transition-colors duration-300 rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                                <div
                                    class="inline-block px-3 py-1 rounded-md bg-[#f95716] text-white text-xs font-bold uppercase tracking-wider mb-3">
                                    {{ get_content('about', 'timeline', 'item_3_year', '2020') }}
                                </div>
                                <h3
                                    class="font-heading font-black uppercase text-slate-950 text-xl sm:text-2xl tracking-tight mb-2">
                                    {{ get_content('about', 'timeline', 'item_3_title', 'Commercial Mega-Towers & Industrial Hubs') }}
                                </h3>
                                <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                                    {{ get_content('about', 'timeline', 'item_3_desc', 'Completed 28-story corporate headquarters and 350,000 sq.ft automated logistics centers ahead of scheduled milestones.') }}
                                </p>
                            </div>
                        </div>

                        <!-- Timeline Item 4: 2024 - Present -->
                        <div class="relative group">
                            <div
                                class="absolute -left-[35px] sm:-left-[51px] top-2 w-6 h-6 rounded-full bg-white border-4 border-[#f95716] shadow-md group-hover:scale-125 transition-transform duration-300">
                            </div>
                            <div
                                class="bg-[#f4f3ef] hover:bg-slate-50 transition-colors duration-300 rounded-2xl p-6 sm:p-8 border border-slate-200/80 shadow-sm">
                                <div
                                    class="inline-block px-3 py-1 rounded-md bg-slate-950 text-white text-xs font-bold uppercase tracking-wider mb-3">
                                    {{ get_content('about', 'timeline', 'item_4_year', '2024–Present') }}
                                </div>
                                <h3
                                    class="font-heading font-black uppercase text-slate-950 text-xl sm:text-2xl tracking-tight mb-2">
                                    {{ get_content('about', 'timeline', 'item_4_title', 'Smart Construction & Low-Carbon Engineering') }}
                                </h3>
                                <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                                    {{ get_content('about', 'timeline', 'item_4_desc', 'Benchmarking geopolymer low-carbon mixes, autonomous drone surveys, and LEED Platinum smart civil infrastructure.') }}
                                </p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Right Column: Scroll-Pinned Sticky Title & Overview (5 Cols) -->
                <div class="order-1 lg:order-2 lg:col-span-5 xl:col-span-5">
                    <div id="evolution-pinned-title"
                        class="parallax-text-layers parallax-layers relative will-change-transform">
                        <!-- Watermark -->
                        <span
                            class="parallax-text-back back text-slate-950">{{ get_content('about', 'timeline', 'watermark', 'JOURNEY') }}</span>

                        <!-- Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                {{ get_content('about', 'timeline', 'badge', 'Evolution of Excellence') }}
                            </span>
                        </div>

                        <!-- Main Section Title -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[48px] m-0 mb-6 relative z-10">
                            {!! get_content('about', 'timeline', 'title', 'Milestones of Proven <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Growth</span> & Capability') !!}
                        </h2>

                        <!-- Descriptive Intro -->
                        <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0 relative z-10">
                            {{ get_content('about', 'timeline', 'intro', 'From specialized deep geotechnical foundation works to managing full-scale commercial EPC developments, our journey represents a continuous commitment to precision engineering, modern telemetry, and structural integrity.') }}
                        </p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- 5. Pillars of Practice & Core Values Section (Scroll-Pinned Title on Left) -->
    <section id="core-values"
        class="core-values-section relative py-20 sm:py-24 lg:py-32 bg-[#0c101a] text-white overflow-hidden border-t border-white/10">

        <!-- Blueprint Subtle Grid -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-20">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 xl:gap-20 items-start">

                <!-- Left Column: Scroll-Pinned Sticky Editorial Header (5 Cols) -->
                <div class="values-left-col lg:col-span-5 xl:col-span-5">
                    <div id="values-pinned-title"
                        class="parallax-text-layers parallax-layers relative will-change-transform">
                        <!-- Watermark -->
                        <span
                            class="parallax-text-back back text-white">{{ get_content('about', 'values', 'watermark', 'VALUES') }}</span>

                        <!-- Eyebrow -->
                        <div
                            class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                            <span
                                class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                                {{ get_content('about', 'values', 'badge', 'Our Pillars of Practice') }}
                            </span>
                        </div>

                        <!-- Main Section Title -->
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px] m-0 mb-6 relative z-10">
                            {!! get_content('about', 'values', 'title', 'Engineering Benchmarks That <span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Define</span> Every Build') !!}
                        </h2>

                        <!-- Narrative Subtitle -->
                        <p
                            class="text-slate-300 text-sm sm:text-base lg:text-lg font-normal leading-relaxed max-w-lg m-0 relative z-10">
                            {{ get_content('about', 'values', 'subtitle', 'Four non-negotiable operational principles engineered into every deep foundation, reinforced frame, and commercial handover.') }}
                        </p>
                    </div>
                </div>

                <!-- Right Column: 4 Editorial Architectural Rows (7 Cols) -->
                <div id="values-content-col"
                    class="lg:col-span-7 xl:col-span-7 divide-y divide-white/10 border-y border-white/10">

                    <!-- Pillar 01 -->
                    <div class="pillar-row group py-8 sm:py-10 lg:py-12 transition-colors duration-300">
                        <div class="flex items-start gap-6 sm:gap-8">
                            <!-- Index Numeral -->
                            <div
                                class="font-heading font-black text-2xl sm:text-3xl text-slate-500 group-hover:text-[#f95716] transition-colors duration-300 w-12 sm:w-16 flex-shrink-0 pt-0.5">
                                01
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <h3
                                    class="font-heading font-black uppercase text-white group-hover:text-[#f95716] text-xl sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-300 m-0 mb-3">
                                    {{ get_content('about', 'values', 'val_1_title', 'Zero-Incident HSE Governance') }}
                                </h3>
                                <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed m-0 mb-4">
                                    {{ get_content('about', 'values', 'val_1_desc', 'Proactive safety audits, computerized strut telemetry, and mandatory daily tool-box briefings across every live tier.') }}
                                </p>
                                <div
                                    class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_1_tag_1', 'Daily Toolbox Audits') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_1_tag_2', 'Automated Strut Telemetry') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_1_tag_3', 'ISO 45001') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pillar 02 -->
                    <div class="pillar-row group py-8 sm:py-10 lg:py-12 transition-colors duration-300">
                        <div class="flex items-start gap-6 sm:gap-8">
                            <!-- Index Numeral -->
                            <div
                                class="font-heading font-black text-2xl sm:text-3xl text-slate-500 group-hover:text-[#f95716] transition-colors duration-300 w-12 sm:w-16 flex-shrink-0 pt-0.5">
                                02
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <h3
                                    class="font-heading font-black uppercase text-white group-hover:text-[#f95716] text-xl sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-300 m-0 mb-3">
                                    {{ get_content('about', 'values', 'val_2_title', 'BIM 5D & Clash Detection') }}
                                </h3>
                                <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed m-0 mb-4">
                                    {{ get_content('about', 'values', 'val_2_desc', '3D point cloud LIDAR drone scans mapped to Revit IFC models preventing costly field MEP clashes.') }}
                                </p>
                                <div
                                    class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_2_tag_1', '3D Point Cloud Drone Scans') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_2_tag_2', 'LOD 400 Digital Twins') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_2_tag_3', 'Zero MEP Collisions') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pillar 03 -->
                    <div class="pillar-row group py-8 sm:py-10 lg:py-12 transition-colors duration-300">
                        <div class="flex items-start gap-6 sm:gap-8">
                            <!-- Index Numeral -->
                            <div
                                class="font-heading font-black text-2xl sm:text-3xl text-slate-500 group-hover:text-[#f95716] transition-colors duration-300 w-12 sm:w-16 flex-shrink-0 pt-0.5">
                                03
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <h3
                                    class="font-heading font-black uppercase text-white group-hover:text-[#f95716] text-xl sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-300 m-0 mb-3">
                                    {{ get_content('about', 'values', 'val_3_title', 'Tested Materials Sourcing') }}
                                </h3>
                                <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed m-0 mb-4">
                                    {{ get_content('about', 'values', 'val_3_desc', 'Certified post-tensioned high-tensile steel and third-party laboratory verified 65+ MPa concrete cube testing.') }}
                                </p>
                                <div
                                    class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_3_tag_1', '65+ MPa Concrete Crush Tests') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_3_tag_2', 'High-Tensile Rebar') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_3_tag_3', 'ASTM C39 QA') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pillar 04 -->
                    <div class="pillar-row group py-8 sm:py-10 lg:py-12 transition-colors duration-300">
                        <div class="flex items-start gap-6 sm:gap-8">
                            <!-- Index Numeral -->
                            <div
                                class="font-heading font-black text-2xl sm:text-3xl text-slate-500 group-hover:text-[#f95716] transition-colors duration-300 w-12 sm:w-16 flex-shrink-0 pt-0.5">
                                04
                            </div>

                            <!-- Content -->
                            <div class="flex-1">
                                <h3
                                    class="font-heading font-black uppercase text-white group-hover:text-[#f95716] text-xl sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-300 m-0 mb-3">
                                    {{ get_content('about', 'values', 'val_4_title', 'Critical-Path Milestone Control') }}
                                </h3>
                                <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed m-0 mb-4">
                                    {{ get_content('about', 'values', 'val_4_desc', 'Full-time site superintendents providing real-time stage lookahead schedules and transparent owner reporting.') }}
                                </p>
                                <div
                                    class="flex flex-wrap items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_4_tag_1', 'Full-Time Site Superintendents') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_4_tag_2', '4-Week Lookahead Matrix') }}
                                    </span>
                                    <span class="px-2.5 py-1 rounded-md bg-white/5 border border-white/10">
                                        {{ get_content('about', 'values', 'val_4_tag_3', 'Milestone Guarantee') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- 6. Executive Leadership Team Section (Architectural Blueprint Theme Aligned) -->
    <section id="leadership-team"
        class="leadership-section relative py-20 sm:py-24 lg:py-28 bg-white text-slate-900 overflow-hidden border-t border-slate-100">

        <!-- Atmospheric Subtle Grid Pattern -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden opacity-30">
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#0b0f1708_1px,transparent_1px),linear-gradient(to_bottom,#0b0f1708_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="flex flex-col lg:flex-row gap-10 lg:gap-14 xl:gap-20 items-stretch">

                <!-- Left Column: Eyebrow & Custom 30+ Graphic (approx 22% width) -->
                <div class="w-full lg:w-[22%] xl:w-[20%] flex flex-col justify-between flex-shrink-0">

                    <!-- Center: Precision 30 Graphic with Slash & Plus in Zero + Vertical Label (Vertically Centered with Slider) -->
                    <div class="my-auto py-8 lg:py-0 flex items-center">
                        <div class="flex items-center gap-3.5 select-none">
                            <!-- Custom 30 SVG Display Numeral with Blueprint Orange Accents -->
                            <svg viewBox="0 0 170 115"
                                class="w-auto h-24 sm:h-28 lg:h-32 text-slate-950 fill-current flex-shrink-0"
                                xmlns="http://www.w3.org/2000/svg">
                                <!-- Number 3 (Didot / Modern High-Contrast Serif Style) -->
                                <path
                                    d="M 12 30 C 12 18, 22 10, 39 10 C 57 10, 68 20, 68 34 C 68 44, 59 52, 48 55 C 63 58, 75 67, 75 82 C 75 98, 59 108, 38 108 C 17 108, 7 98, 7 86 C 7 80, 12 75, 18 75 C 24 75, 29 80, 29 86 C 29 94, 37 98, 45 98 C 55 98, 62 90, 62 80 C 62 67, 50 58, 35 58 L 26 58 L 26 49 L 34 49 C 46 49, 55 43, 55 33 C 55 24, 48 19, 39 19 C 30 19, 23 24, 23 31 C 23 35, 20 38, 16 38 C 13 38, 12 35, 12 30 Z" />
                                <!-- Number 0 with Diagonal Slash & Central Plus -->
                                <g transform="translate(82, 8)">
                                    <!-- Outer & Inner Oval (High-Contrast Serif 0) -->
                                    <path
                                        d="M 40 2 C 18 2, 2 24, 2 51 C 2 78, 18 100, 40 100 C 62 100, 78 78, 78 51 C 78 24, 62 2, 40 2 Z M 40 11 C 54 11, 64 28, 64 51 C 64 74, 54 91, 40 91 C 26 91, 16 74, 16 51 C 16 28, 26 11, 40 11 Z"
                                        fill-rule="evenodd" />
                                    <!-- Diagonal Drafting Slash Line through 0 -->
                                    <line x1="10" y1="88" x2="70" y2="14" stroke="currentColor" stroke-width="2.2"
                                        stroke-linecap="round" />
                                    <!-- Precision Crosshair / Plus in Center with Orange Tint -->
                                    <line x1="40" y1="44" x2="40" y2="58" stroke="#f95716" stroke-width="2.5"
                                        stroke-linecap="round" />
                                    <line x1="33" y1="51" x2="47" y2="51" stroke="#f95716" stroke-width="2.5"
                                        stroke-linecap="round" />
                                </g>
                            </svg>

                            <!-- Vertical Label "TEAM MEMBER" -->
                            <div class="flex items-center">
                                <span
                                    class="text-[10px] sm:text-[11px] font-bold uppercase tracking-[0.26em] text-slate-500 [writing-mode:vertical-lr] rotate-180 select-none">
                                    {{ get_content('about', 'leadership', 'team_label', 'TEAM MEMBER') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Header & Carousel (approx 78% width) -->
                <div class="w-full lg:w-[78%] xl:w-[80%] min-w-0">

                    <!-- Header Row: Headline & Carousel Navigation with Watermark -->
                    <div
                        class="parallax-text-layers parallax-layers relative flex flex-col sm:flex-row sm:items-end justify-between gap-6 mb-8 sm:mb-10 will-change-transform">
                        <!-- Watermark -->
                        <span
                            class="parallax-text-back back text-slate-950">{{ get_content('about', 'leadership', 'watermark', 'LEADERS') }}</span>

                        <div class="relative z-10">
                            <!-- Top: Blueprint Eyebrow Badge -->
                            <div class="sub-heading flex items-center gap-2.5">
                                <span
                                    class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                                <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716] select-none">
                                    {{ get_content('about', 'leadership', 'badge', 'OUR EXPERIENCE TEAM') }}
                                </span>
                            </div>
                            <h2
                                class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 text-3xl sm:text-4xl lg:text-[46px] xl:text-[52px] tracking-tight leading-[1.05] m-0">
                                {!! get_content('about', 'leadership', 'title', 'Leaders Driving Future <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Building Excellence</span>') !!}
                            </h2>
                        </div>

                        <!-- Circular Navigation Arrows with Brand Orange Hover -->
                        <div class="flex items-center gap-3 flex-shrink-0 relative z-10">
                            <button type="button"
                                class="team-swiper-prev w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#f1f1ee] hover:bg-[#f95716] text-slate-800 hover:text-white border border-slate-200/80 hover:border-[#f95716] flex items-center justify-center transition-all duration-300 shadow-sm hover:shadow-md cursor-pointer focus:outline-none"
                                aria-label="Previous Team Members">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                </svg>
                            </button>
                            <button type="button"
                                class="team-swiper-next w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#f1f1ee] hover:bg-[#f95716] text-slate-800 hover:text-white border border-slate-200/80 hover:border-[#f95716] flex items-center justify-center transition-all duration-300 shadow-sm hover:shadow-md cursor-pointer focus:outline-none"
                                aria-label="Next Team Members">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Swiper Carousel Container -->
                    <div class="team-swiper swiper overflow-hidden">
                        <div class="swiper-wrapper">
                            @foreach($leadership as $leader)
                                <div class="swiper-slide">
                                    <div class="group flex flex-col justify-between">
                                        <!-- Portrait Photo Box with Rounded Corners & Subtle Ring -->
                                        <a href="{{ route('team.show', $leader['id']) }}"
                                            class="relative w-full aspect-[4/4.5] rounded-2xl overflow-hidden bg-slate-100 shadow-sm ring-1 ring-slate-900/5 transition-all duration-300 block">
                                            <img src="{{ $leader['image'] }}" alt="{{ $leader['name'] }}"
                                                class="w-full h-full object-cover object-top transition-transform duration-700 ease-out group-hover:scale-105"
                                                loading="lazy" />
                                        </a>

                                        <!-- Name, Role & LinkedIn Pill Button -->
                                        <div class="pt-4 sm:pt-5">
                                            <h3
                                                class="font-heading font-black text-xl sm:text-2xl text-slate-950 group-hover:text-[#f95716] tracking-tight leading-snug m-0 transition-colors duration-200">
                                                <a href="{{ route('team.show', $leader['id']) }}">
                                                    {{ $leader['name'] }}
                                                </a>
                                            </h3>
                                            <p class="text-slate-600 text-xs sm:text-sm font-normal mt-1 m-0">
                                                {{ $leader['role'] }}
                                            </p>

                                            <!-- Profile & LinkedIn Pill Buttons -->
                                            <div class="mt-3.5 flex items-center gap-2">
                                                <a href="{{ route('team.show', $leader['id']) }}"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-slate-100 hover:bg-[#f95716] text-slate-800 hover:text-white text-[11px] font-bold uppercase tracking-wider transition-all duration-200">
                                                    <span>Profile</span>
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </a>
                                                <a href="{{ $leader['linkedin'] }}" target="_blank" rel="noopener noreferrer"
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full border border-slate-300 hover:border-slate-900 text-slate-800 hover:text-slate-950 text-[11px] font-bold uppercase tracking-wider transition-all duration-200 group/link">
                                                    <span
                                                        class="w-3.5 h-3.5 rounded-full bg-slate-900 group-hover/link:bg-[#f95716] text-white flex items-center justify-center text-[7.5px] font-black transition-colors">
                                                        in
                                                    </span>
                                                    <span>LinkedIn</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- 7. Accreditations & Honors Section -->
    <section id="accreditations"
        class="accreditations-section relative py-20 sm:py-24 lg:py-28 bg-[#f8f7f4] text-slate-900 overflow-visible border-t border-slate-200">

        <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header -->
            <div
                class="accreditations-header parallax-text-layers parallax-layers relative mb-12 sm:mb-16 will-change-transform">
                <!-- Watermark -->
                <span
                    class="parallax-text-back back text-slate-950">{{ get_content('about', 'accreditations', 'watermark', 'HONORS') }}</span>

                <!-- Eyebrow -->
                <div class="parallax-text-front front sub-heading flex items-center gap-2.5 mb-3 sm:mb-4 relative z-10">
                    <span
                        class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                        {{ get_content('about', 'accreditations', 'badge', 'Accreditations & Honors') }}
                    </span>
                </div>

                <!-- Main Section Title & Subtitle -->
                <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 relative z-10">
                    <div>
                        <h2
                            class="parallax-text-mid mid section-title font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[48px] m-0">
                            {!! get_content('about', 'accreditations', 'title', 'Recognized Standards of <br><span class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Certified</span> Excellence') !!}
                        </h2>
                    </div>
                    <p class="text-slate-600 text-sm sm:text-base leading-relaxed max-w-xl m-0">
                        {{ get_content('about', 'accreditations', 'subtitle', 'A continuous record of engineering benchmarking, building excellence awards, and stringent quality protocols across enterprise commercial builds.') }}
                    </p>
                </div>
            </div>

            <!-- Awards / Accreditations Interactive List Rows -->
            <div class="space-y-4 sm:space-y-5 relative">
                @foreach($accreditations as $acc)
                    <div
                        class="award-row group relative z-10 hover:z-40 flex items-center justify-between px-6 sm:px-10 lg:px-12 py-6 sm:py-7 lg:py-8 rounded-2xl bg-[#ecebe6] hover:bg-[#f95716] border border-slate-300/70 hover:border-[#f95716] transition-all duration-300 ease-out cursor-pointer select-none">

                        <!-- Left: Year -->
                        <div
                            class="font-heading font-black text-slate-500 group-hover:text-white text-base sm:text-lg lg:text-xl transition-colors duration-200 w-16 sm:w-24 flex-shrink-0 relative z-10">
                            {{ $acc['year'] }}
                        </div>

                        <!-- Center: Title & Category -->
                        <div class="flex-1 px-4 sm:px-8 relative z-10">
                            <h3
                                class="font-heading font-black uppercase text-slate-950 group-hover:text-white text-lg sm:text-2xl lg:text-3xl tracking-tight transition-colors duration-200 m-0 leading-tight">
                                {{ $acc['title'] }}
                            </h3>
                            @if(!empty($acc['category']))
                                <span
                                    class="text-xs sm:text-sm text-slate-500 group-hover:text-white/80 transition-colors duration-200 block mt-1 font-medium">
                                    {{ $acc['category'] }}
                                </span>
                            @endif
                        </div>

                        <!-- Floating Hover-Reveal Image Preview (Centered exactly in the middle of the row, always on top) -->
                        <div
                            class="award-preview-anchor absolute left-1/2 top-1/2 -translate-x-1/2 -translate-y-1/2 pointer-events-none z-50 hidden sm:block">
                            <div
                                class="award-preview-box opacity-0 scale-75 rotate-[-2deg] transition-all duration-300 ease-out group-hover:opacity-100 group-hover:scale-100 group-hover:rotate-0 w-44 sm:w-52 md:w-60 aspect-[4/4.8] rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                                <img src="{{ $acc['image'] }}" alt="{{ $acc['title'] }}" class="w-full h-full object-cover"
                                    loading="lazy" />
                            </div>
                        </div>

                        <!-- Right: Status -->
                        <div class="text-right flex-shrink-0 relative z-10">
                            <span
                                class="inline-block text-sm sm:text-base lg:text-lg font-bold text-slate-600 group-hover:text-white transition-colors duration-200">
                                {{ $acc['status'] }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>

    </section>
@endsection