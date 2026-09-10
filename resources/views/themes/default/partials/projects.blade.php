<!-- Projects Section -->
<section id="projects"
    class="relative py-24 sm:py-28 lg:py-36 bg-[#ffffff] text-slate-900 overflow-hidden border-t border-slate-200">
    <div class="relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

        <!-- Section Header (Editorial & Filter Tabs) -->
        <div id="projects-header"
            class="flex flex-col lg:flex-row lg:items-end justify-between gap-8 mb-14 sm:mb-16 lg:mb-20">
            <div>
                <!-- Eyebrow -->
                <div class="flex items-center gap-3 mb-4 sm:mb-5">
                    <span class="w-7 h-[2px] bg-[#f95716]"></span>
                    <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-slate-950">
                        RECENT PROJECTS
                    </span>
                </div>

                <!-- Editorial Headline -->
                <h2
                    class="font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.02] text-3xl sm:text-5xl lg:text-[54px] xl:text-[60px]">
                    Featured <span
                        class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">Engineering</span>
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
                class="project-card group bg-slate-50 rounded-3xl overflow-hidden border border-slate-200/80 shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between"
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
                class="project-card group bg-slate-50 rounded-3xl overflow-hidden border border-slate-200/80 shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between"
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
                class="project-card group bg-slate-50 rounded-3xl overflow-hidden border border-slate-200/80 shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between"
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
                class="project-card group bg-slate-50 rounded-3xl overflow-hidden border border-slate-200/80 shadow-lg hover:shadow-2xl transition-shadow duration-300 flex flex-col justify-between"
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