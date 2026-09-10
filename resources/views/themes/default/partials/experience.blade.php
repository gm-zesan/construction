<!-- Experience & CTA Section (Measurable Results & Quad Metric Grid) -->
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
                <div>
                    <!-- Sub Heading / Eyebrow -->
                    <div class="sub-heading flex items-center gap-2.5 mb-3 sm:mb-4">
                        <span class="blueprint-line inline-block w-8 sm:w-10 h-[2.5px] bg-[#f95716] rounded-full origin-left flex-shrink-0"></span>
                        <span class="text-xs font-bold uppercase tracking-[0.2em] text-[#f95716]">
                            Project Track Record
                        </span>
                    </div>

                    <!-- Section Title -->
                    <h2
                        class="section-title font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-[44px] xl:text-[50px]">
                        Planned Work. <br>
                        <span
                            class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Controlled</span>
                        Execution.
                    </h2>

                    <!-- Lead Paragraph -->
                    <p class="text-slate-300 text-sm sm:text-base font-normal leading-relaxed max-w-lg mt-4 sm:mt-5">
                        We coordinate heavy equipment, civil trades, and structural crews to maintain strict schedule
                        milestones from initial ground prep to final building handover.
                    </p>
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
                <div
                    class="font-heading font-black text-4xl sm:text-5xl text-white tracking-tight leading-none mb-3">
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
                <div
                    class="font-heading font-black text-4xl sm:text-5xl text-white tracking-tight leading-none mb-3">
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
