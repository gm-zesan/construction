<!-- Hero Section -->
<section id="hero"
    class="relative min-h-[90vh] lg:min-h-screen flex items-center overflow-hidden pt-28 pb-16 lg:pt-36 lg:pb-24">

    <!-- Background Photography with Subtle Slow Movement -->
    <div class="absolute inset-0 z-0 overflow-hidden pointer-events-none">
        <img id="hero-bg-img" src="{{ asset('images/hero-bg.jpg') }}" alt="Commercial construction skyline and structural engineering"
            class="w-full h-full object-cover object-center transform will-change-transform scale-105" loading="eager"
            fetchpriority="high">

        <!-- Refined Dark Overlay: Keeps text readable on left while letting background shine through clearly -->
        <div class="absolute inset-0 bg-[#080c14]/40"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-[#080c14]/90 via-[#080c14]/80 to-black/50"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#080c14] via-transparent to-black/40"></div>
    </div>

    <!-- Main Container -->
    <div class="relative z-10 w-full max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-8 lg:py-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-8 items-center">

            <!-- Left Side: Main Heading & CTAs -->
            <div id="hero-content-col" class="lg:col-span-7 flex flex-col items-start text-left">

                <!-- Eyebrow -->
                <div class="inline-flex items-center gap-3 mb-6 animate-fade-in">
                    <span class="w-6 h-[2px] bg-[#f95716]"></span>
                    <span class="text-xs sm:text-sm font-bold tracking-[0.25em] text-[#f95716] uppercase">
                        CONSTRUCTION & DEVELOPMENT
                    </span>
                </div>

                <!-- Main Heading (Solid White Typography) -->
                <h1 id="hero-content"
                    class="font-heading font-extrabold uppercase text-white tracking-tight leading-[0.96] text-4xl sm:text-6xl md:text-7xl lg:text-8xl mb-8 sm:mb-10 animate-fade-in">
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

                <!-- 1. Editorial Supporting Text (Top Right) -->
                <div class="max-w-md lg:text-right animate-fade-in">
                    <p class="text-slate-200 text-sm sm:text-base md:text-lg font-normal leading-relaxed">
                        Projects delivered with careful planning, clear coordination and attention to detail.
                    </p>
                </div>

                <!-- 2. Circular Action Badge (Middle Right) -->
                <div class="flex items-center -space-x-3 sm:-space-x-4 lg:self-end animate-fade-in">

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
                        <!-- Center Spiral/Architectural Motif -->
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

                <!-- 3. Project Snapshot & Stat Badge (Bottom Right) -->
                <div
                    class="flex items-center gap-4 p-3 sm:p-3.5 rounded-lg bg-black/40 border border-white/15 backdrop-blur-md shadow-2xl lg:self-end animate-fade-in">

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