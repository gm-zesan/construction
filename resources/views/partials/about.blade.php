<!-- About Section -->
<section id="about"
    class="relative py-20 sm:py-28 lg:py-32 bg-[#ffffff] text-slate-900 overflow-hidden border-t border-slate-200">
    <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 xl:gap-12 items-end">

            <!-- Left Column: Previous Content, Mixed Typography, CTA & 01 Project Approach Card -->
            <div class="lg:col-span-5 flex flex-col justify-between space-y-8 z-10">

                <div>
                    <!-- Eyebrow -->
                    <div class="about-fade-el flex items-center gap-3 mb-5 sm:mb-6">
                        <span class="w-7 h-[2px] bg-[#f95716]"></span>
                        <span class="text-xs sm:text-sm font-black uppercase tracking-[0.2em] text-slate-950">
                            ABOUT CONSTRUCTION
                        </span>
                    </div>

                    <!-- Editorial Heading with Mixed Typography -->
                    <h2
                        class="about-fade-el font-heading font-black uppercase text-slate-950 tracking-tight leading-[1.02] text-4xl sm:text-5xl lg:text-[50px] xl:text-[56px] mb-6 sm:mb-8">
                        Construction built around <span
                            class="font-sketch font-bold text-[#f95716] normal-case text-[1.15em] tracking-normal inline-block transform -rotate-1">precision,</span>
                        planning & detail.
                    </h2>

                    <!-- Description -->
                    <p class="about-fade-el text-slate-600 text-base sm:text-lg font-normal leading-relaxed mb-8 sm:mb-10 max-w-lg">
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
                <div
                    class="about-fade-el w-fit min-w-[240px] sm:min-w-[270px] p-6 sm:p-7 bg-[#0b0f17] text-white rounded-2xl border border-white/10 shadow-2xl flex items-center gap-5 sm:gap-6">
                    <div class="flex items-baseline">
                        <span id="experience-stat-number" class="font-heading text-6xl sm:text-7xl font-extrabold text-white leading-none tracking-tight">12</span>
                        <span class="text-[#f95716] text-3xl sm:text-4xl font-black leading-none ml-1.5">+</span>
                    </div>
                    <div class="border-l border-white/15 pl-4 sm:pl-5">
                        <span class="block text-sm sm:text-base font-bold text-white uppercase tracking-wider leading-tight">
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
                <div class="reveal-image-container relative w-full aspect-[3/4] rounded-2xl overflow-hidden shadow-xl ring-1 ring-slate-900/5 bg-[#f95716] group" data-reveal-delay="100">
                    <!-- Theme Color Curtain Overlay -->
                    <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                    <img src="{{ asset('images/about-consulting-duo.jpg') }}"
                        alt="Civil engineers discussing architectural blueprints on construction site"
                        class="reveal-image w-full h-full object-cover object-center"
                        loading="lazy">
                </div>
            </div>

            <!-- Right Column: Large Primary Project Image (Female Engineer on Site) -->
            <div class="lg:col-span-4 w-full">
                <div class="reveal-image-container relative w-full aspect-[9/13] rounded-3xl overflow-hidden shadow-2xl ring-1 ring-slate-900/5 bg-[#f95716] group" data-reveal-delay="260">
                    <!-- Theme Color Curtain Overlay -->
                    <div class="reveal-curtain absolute inset-0 z-10 bg-[#f95716] pointer-events-none"></div>

                    <img src="{{ asset('images/about-engineer-tablet.jpg') }}"
                        alt="Female civil engineer with digital tablet on building construction site"
                        class="reveal-image w-full h-full object-cover object-center"
                        loading="lazy" />
                </div>
            </div>
        </div>

    </div>
</section>