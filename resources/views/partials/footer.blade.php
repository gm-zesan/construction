<!-- Footer Section -->
<footer id="footer" class="relative bg-[#0b0f17] text-slate-300 overflow-hidden border-t border-white/10">

    <!-- Cinematic Twilight Background Photo with Dark Overlay -->
    <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
        <img id="footer-bg-img" src="{{ asset('images/footer-bg.jpg') }}" alt="Construction silhouette background"
            class="absolute -top-[12%] left-0 w-full h-[125%] object-cover object-center opacity-30 will-change-transform scale-105" loading="lazy" />
        <div class="absolute inset-0 bg-gradient-to-t from-[#070a10] via-[#0b0f17]/95 to-[#0b0f17]/90"></div>
        <!-- Subtle Architectural Blueprint Grid Motif -->
        <div
            class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff05_1px,transparent_1px),linear-gradient(to_bottom,#ffffff05_1px,transparent_1px)] bg-[size:4rem_4rem]">
        </div>
    </div>

    <!-- Container Fluid -->
    <div class="container-fluid relative z-10 max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 pt-16 sm:pt-20 lg:pt-24">

        <!-- Top CTA Banner Row -->
        <div id="footer-cta-row"
            class="flex flex-col lg:flex-row lg:items-center justify-between gap-8 pb-12 sm:pb-16 border-b border-white/10 will-change-transform">
            <!-- Left: Headline with Mixed Typography -->
            <div class="max-w-2xl">
                <h2
                    class="font-heading font-black uppercase text-white tracking-tight leading-[1.04] text-3xl sm:text-4xl lg:text-5xl xl:text-6xl m-0">
                    Ready To Start Your Next <br>
                    <span
                        class="font-sketch font-bold text-[#f95716] normal-case text-[1.12em] tracking-normal inline-block transform -rotate-1">Commercial</span>
                    Build?
                </h2>
            </div>

            <!-- Right: Primary CTA Button -->
            <div class="flex-shrink-0">
                <a href="#hero-content"
                    class="group inline-flex items-center gap-3 px-8 sm:px-10 py-4 sm:py-4.5 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white text-sm sm:text-base font-bold uppercase tracking-wider transition-all duration-300 shadow-xl shadow-[#f95716]/25 hover:shadow-[#f95716]/40 hover:scale-[1.02] cursor-pointer">
                    <span>Discuss Project</span>
                    <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1 group-hover:-translate-y-1"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M7 17L17 7M17 7H7M17 7V17" />
                    </svg>
                </a>
            </div>
        </div>

        <!-- Main 4-Column Footer Navigation Row -->
        <div id="footer-links-grid"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-10 sm:gap-12 lg:gap-8 xl:gap-12 py-12 sm:py-16">

            <!-- Col 1 (4 Cols): Brand, Tagline & Socials -->
            <div class="lg:col-span-4 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Brand Logo -->
                    <a href="#" class="inline-flex items-center gap-3 text-white focus:outline-none mb-4 group">
                        <div
                            class="w-10 h-10 rounded-lg bg-[#f95716] flex items-center justify-center shadow-lg shadow-[#f95716]/20 transition-transform duration-300 group-hover:scale-105">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 3L2 12h3v8h14v-8h3L12 3zm0 2.84L18 11v7h-3v-5H9v5H6v-7l6-5.16zM11 15h2v3h-2v-3z" />
                            </svg>
                        </div>
                        <span class="font-heading font-black uppercase text-2xl tracking-tight text-white">
                            COMPANY NAME
                        </span>
                    </a>

                    <!-- Brand Statement -->
                    <p class="text-slate-400 text-sm sm:text-base font-normal leading-relaxed m-0 max-w-sm mb-4">
                        Licensed general contractors providing structural concrete, steel framing, and commercial
                        site supervision.
                    </p>

                    <!-- Established Architectural Typography -->
                    <div class="my-5 select-none">
                        <span
                            class="font-heading font-black text-3xl sm:text-4xl tracking-tight text-transparent [-webkit-text-stroke:1.5px_rgba(255,255,255,0.3)] hover:[-webkit-text-stroke:1.5px_#f95716] transition-all duration-300 block uppercase leading-none">
                            Since 2012
                        </span>
                    </div>
                </div>

                <!-- Social Follow Icons -->
                <div class="flex items-center gap-3 pt-2">
                    <!-- Facebook -->
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 hover:bg-[#f95716] text-slate-400 hover:text-white border border-white/10 flex items-center justify-center transition-all duration-300 focus:outline-none cursor-pointer"
                        aria-label="Facebook">
                        <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                            <path
                                d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" />
                        </svg>
                    </a>
                    <!-- LinkedIn / Pinterest -->
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 hover:bg-[#f95716] text-slate-400 hover:text-white border border-white/10 flex items-center justify-center transition-all duration-300 focus:outline-none cursor-pointer"
                        aria-label="LinkedIn">
                        <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                            <path
                                d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.28 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.75M6.46 8.76c.97 0 1.75-.79 1.75-1.76s-.78-1.75-1.75-1.75a1.75 1.75 0 0 0-1.76 1.75c0 .97.79 1.76 1.76 1.76m1.39 9.74v-8.37H5.07v8.37h2.78z" />
                        </svg>
                    </a>
                    <!-- Twitter / X -->
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 hover:bg-[#f95716] text-slate-400 hover:text-white border border-white/10 flex items-center justify-center transition-all duration-300 focus:outline-none cursor-pointer"
                        aria-label="Twitter">
                        <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <!-- Instagram -->
                    <a href="#"
                        class="w-10 h-10 rounded-full bg-white/5 hover:bg-[#f95716] text-slate-400 hover:text-white border border-white/10 flex items-center justify-center transition-all duration-300 focus:outline-none cursor-pointer"
                        aria-label="Instagram">
                        <svg class="w-4 h-4 fill-currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Col 2 (2 Cols): Main Pages -->
            <div class="lg:col-span-2 sm:col-span-1">
                <h3 class="font-heading font-black uppercase text-white text-base sm:text-lg tracking-wider mb-6">
                    Main Pages
                </h3>
                <ul class="space-y-3.5 list-none p-0 m-0">
                    <li>
                        <a href="#"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Home</span>
                        </a>
                    </li>
                    <li>
                        <a href="#about"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>About Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Services</span>
                        </a>
                    </li>
                    <li>
                        <a href="#projects"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Projects</span>
                        </a>
                    </li>
                    <li>
                        <a href="#why-choose-us"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Why Choose Us</span>
                        </a>
                    </li>
                    <li>
                        <a href="#news"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Blog &amp; News</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3 (3 Cols): Our Services -->
            <div class="lg:col-span-3 sm:col-span-1">
                <h3 class="font-heading font-black uppercase text-white text-base sm:text-lg tracking-wider mb-6">
                    Our Services
                </h3>
                <ul class="space-y-3.5 list-none p-0 m-0">
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Architecture &amp; Planning</span>
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Structural Construction</span>
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Interior Finishing</span>
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Project Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="#services"
                            class="text-slate-400 hover:text-[#f95716] text-sm transition-colors duration-200 inline-flex items-center gap-1.5 group">
                            <span class="w-1.5 h-1.5 rounded-full bg-slate-600 group-hover:bg-[#f95716] transition-colors"></span>
                            <span>Foundation &amp; Deep Piling</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 4 (3 Cols): Information / Contact Details -->
            <div class="lg:col-span-3">
                <h3 class="font-heading font-black uppercase text-white text-base sm:text-lg tracking-wider mb-6">
                    Information
                </h3>
                <div class="space-y-4 text-sm">
                    <!-- Physical Address -->
                    <div class="flex items-start gap-3">
                        <div class="text-[#f95716] flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <p class="text-slate-400 leading-relaxed m-0">
                            House 40/A, Road 20,<br>Mohakhali DOHS
                        </p>
                    </div>

                    <!-- Email -->
                    <div class="flex items-center gap-3">
                        <div class="text-[#f95716] flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <a href="mailto:support@agency.com"
                            class="text-slate-400 hover:text-[#f95716] transition-colors duration-200">
                            support@agency.com
                        </a>
                    </div>

                    <!-- Phone Number -->
                    <div class="flex items-center gap-3">
                        <div class="text-[#f95716] flex-shrink-0">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                        </div>
                        <a href="tel:01700000000"
                            class="text-slate-400 hover:text-[#f95716] transition-colors duration-200">
                            01700000000
                        </a>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Oversized Architectural Watermark Motif -->
    <div class="relative w-full overflow-hidden select-none pointer-events-none opacity-5">
        <div class="font-heading font-black text-center text-[10vw] uppercase tracking-tighter leading-none text-white whitespace-nowrap -mb-[2vw]">
            CONSTRUCTION &amp; STRUCTURES
        </div>
    </div>

    <!-- Sub-Footer Bottom Copyright Row -->
    <div class="relative z-10 border-t border-white/10 bg-[#070a10]">
        <div
            class="container-fluid max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12 py-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs sm:text-sm text-slate-500">
            <!-- Copyright -->
            <p class="m-0">
                &copy; {{ date('Y') }} COMPANY NAME. All Rights Reserved.
            </p>

            <!-- Legal Links -->
            <div class="flex items-center gap-6">
                <a href="#" class="hover:text-slate-300 transition-colors">Privacy Policy</a>
                <span class="text-slate-700">|</span>
                <a href="#" class="hover:text-slate-300 transition-colors">Terms and Conditions</a>
            </div>
        </div>
    </div>

</footer>
