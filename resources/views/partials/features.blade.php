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
                    <div class="section-heading white-content">
                        <!-- Sub Heading / Eyebrow -->
                        <div class="sub-heading flex items-center gap-2.5 mb-3">
                            <span class="line w-5 h-[2px] bg-[#f95716]"></span>
                            <span class="text-xs font-bold uppercase tracking-[0.2em] text-slate-300">
                                Interior Execution
                            </span>
                        </div>

                        <!-- Section Title -->
                        <h2
                            class="section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px]">
                            Interior Work, <br>
                            <span
                                class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">From Plan</span>
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
                                <span class="text-xs font-semibold text-slate-500 tracking-wide block mt-0.5">Founder &amp; CEO</span>
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