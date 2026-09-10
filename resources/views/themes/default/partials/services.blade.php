<!-- Services Section -->
<section id="services" class="relative py-24 sm:py-28 lg:py-36 bg-[#080c14] text-white overflow-hidden">

    <!-- Cinematic Background with Engineers and Site Architecture -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <img id="services-bg-img" src="{{ asset('images/services-bg.jpg') }}"
            alt="Civil engineers reviewing structural plans on commercial construction site"
            class="w-full h-full object-cover object-center transform will-change-transform scale-105" loading="lazy" />

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
            <div>
                <!-- Eyebrow -->
                <div class="flex items-center gap-3 mb-4 sm:mb-5">
                    <span class="w-7 h-[2px] bg-[#f95716]"></span>
                    <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-[#f95716]">
                        CORE CAPABILITIES
                    </span>
                </div>

                <!-- Editorial Headline -->
                <h2
                    class="font-heading font-black uppercase text-white tracking-tight leading-[1.02] text-3xl sm:text-5xl lg:text-[54px] xl:text-[60px]">
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
                        <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                            Project planning, architectural drafting, structural calculations, and technical site preparation.
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
                        <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                            Direct site execution, reinforced concrete framing, steel erection, and superintendent management.
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
                        <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
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
                        <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed group-hover:text-slate-300 transition-colors">
                            Interior and structural renovation work, commercial fit-outs, and architectural adaptive reuse.
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