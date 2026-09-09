<!-- Navigation Header -->
<header id="site-header"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 py-6 border-b border-white/10 bg-transparent">
    <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="flex items-center justify-between">

            <!-- Company Logo / Placeholder -->
            <a href="/" class="flex items-center gap-3 focus:outline-none" aria-label="{{ get_setting('company_name', 'COMPANY NAME') }} Home">
                @if(get_setting('site_logo'))
                    <img src="{{ asset(get_setting('site_logo')) }}" alt="{{ get_setting('company_name', 'COMPANY NAME') }}" class="h-8 w-auto object-contain">
                @else
                    <span class="w-2.5 h-6 bg-[#f95716]"></span>
                    @php
                        $companyName = get_setting('company_name', 'COMPANY NAME');
                        $nameParts = explode(' ', $companyName, 2);
                    @endphp
                    <span class="font-heading text-2xl sm:text-3xl font-bold tracking-wider text-white uppercase">
                        {{ $nameParts[0] }} @if(isset($nameParts[1]))<span class="text-slate-400 font-normal">{{ $nameParts[1] }}</span>@endif
                    </span>
                @endif
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-7 lg:space-x-8" aria-label="Main Navigation">
                <a href="{{ route('home') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('home') ? 'text-white' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    Home
                </a>
                <a href="{{ route('about') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('about') ? 'text-[#f95716]' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    About
                </a>
                <a href="{{ route('home') }}#services"
                    class="text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] transition-colors">
                    Services
                </a>
                <a href="{{ route('public.projects.index') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('public.projects.*') ? 'text-[#f95716]' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    Projects
                </a>
                <a href="{{ route('home') }}#why-choose-us"
                    class="text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] transition-colors">
                    Why Us
                </a>
                <a href="{{ route('public.articles.index') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('public.articles.*') ? 'text-[#f95716]' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    News & Articles
                </a>
                <a href="#footer"
                    class="text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] transition-colors">
                    Contact
                </a>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden md:flex items-center gap-3">
                @auth
                    <a href="{{ route('dashboard') }}"
                        class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all rounded-xs shadow-sm shadow-[#f95716]/20">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center justify-center px-3 py-2 text-xs font-semibold uppercase tracking-wider text-slate-300 hover:text-white transition-colors">
                        Sign In
                    </a>
                    <a href="#footer"
                        class="inline-flex items-center justify-center px-5 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all rounded-xs shadow-sm shadow-[#f95716]/20">
                        Get a Quote
                    </a>
                @endauth
            </div>

            <!-- Mobile Hamburger Button -->
            <button id="mobile-menu-toggle" type="button"
                class="md:hidden p-2 text-slate-200 hover:text-white focus:outline-none" aria-controls="mobile-menu"
                aria-expanded="false" aria-label="Toggle navigation">
                <div class="w-6 h-5 flex flex-col justify-between">
                    <span id="burger-bar-1"
                        class="w-full h-0.5 bg-white transition-transform duration-200 origin-top-left"></span>
                    <span id="burger-bar-2" class="w-full h-0.5 bg-white transition-opacity duration-200"></span>
                    <span id="burger-bar-3"
                        class="w-full h-0.5 bg-white transition-transform duration-200 origin-bottom-left"></span>
                </div>
            </button>

        </div>
    </div>

    <!-- Mobile Menu Backdrop -->
    <div id="mobile-backdrop"
        class="fixed inset-0 bg-black/80 backdrop-blur-sm z-40 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"
        aria-hidden="true"></div>

    <!-- Mobile Drawer -->
    <div id="mobile-drawer"
        class="fixed top-0 right-0 bottom-0 w-72 bg-[#0b0f17] border-l border-white/10 z-50 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col justify-between p-6">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-white/10">
                @if(get_setting('site_logo'))
                    <img src="{{ asset(get_setting('site_logo')) }}" alt="{{ get_setting('company_name', 'COMPANY NAME') }}" class="h-7 w-auto object-contain">
                @else
                    <span class="font-heading text-xl font-bold tracking-wider text-white uppercase">
                        {{ $nameParts[0] }} @if(isset($nameParts[1]))<span class="text-[#f95716]">{{ $nameParts[1] }}</span>@endif
                    </span>
                @endif
                <button id="mobile-menu-close" type="button" class="p-1.5 text-slate-400 hover:text-white"
                    aria-label="Close navigation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-8 flex flex-col space-y-4" aria-label="Mobile Navigation Links">
                <a href="{{ route('home') }}"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('home') ? 'text-[#f95716]' : 'text-slate-300 hover:text-[#f95716]' }} py-1">
                    Home
                </a>
                <a href="{{ route('about') }}"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('about') ? 'text-[#f95716]' : 'text-slate-300 hover:text-[#f95716]' }} py-1">
                    About
                </a>
                <a href="{{ route('home') }}#services"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] py-1">
                    Services
                </a>
                <a href="{{ route('public.projects.index') }}"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('public.projects.*') ? 'text-[#f95716]' : 'text-slate-300 hover:text-[#f95716]' }} py-1">
                    Projects
                </a>
                <a href="{{ route('home') }}#why-choose-us"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] py-1">
                    Why Us
                </a>
                <a href="{{ route('public.articles.index') }}"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('public.articles.*') ? 'text-[#f95716]' : 'text-slate-300 hover:text-[#f95716]' }} py-1">
                    News & Articles
                </a>
                <a href="#footer"
                    class="mobile-nav-link text-sm font-semibold tracking-wider uppercase text-slate-300 hover:text-[#f95716] py-1">
                    Contact
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-white/10">
            <a href="#footer"
                class="mobile-nav-link block w-full py-3 text-center text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all rounded-xs shadow-sm shadow-[#f95716]/20">
                Get a Quote
            </a>
        </div>
    </div>
</header>