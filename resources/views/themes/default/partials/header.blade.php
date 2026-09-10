<!-- Navigation Header -->
<header id="site-header"
    class="fixed top-0 left-0 w-full z-50 transition-all duration-300 py-6 border-b border-white/10 bg-transparent">
    <div class="max-w-[1520px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">
        <div class="flex items-center justify-between">

            <!-- Company Logo / Placeholder -->
            <a href="/" class="flex items-center gap-3 focus:outline-none"
                aria-label="{{ get_setting('company_name', 'COMPANY NAME') }} Home">
                @if(get_setting('site_logo'))
                    <img src="{{ asset(get_setting('site_logo')) }}" alt="{{ get_setting('company_name', 'COMPANY NAME') }}"
                        class="h-8 w-auto object-contain">
                @else
                    <span class="w-2.5 h-6 bg-[#f95716]"></span>
                    @php
                        $companyName = get_setting('company_name', 'COMPANY NAME');
                        $nameParts = explode(' ', $companyName, 2);
                    @endphp
                    <span class="font-heading text-2xl sm:text-3xl font-bold tracking-wider text-white uppercase">
                        {{ $nameParts[0] }} @if(isset($nameParts[1]))<span
                        class="text-slate-400 font-normal">{{ $nameParts[1] }}</span>@endif
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
                <a href="{{ route('team') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('team*') ? 'text-[#f95716]' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    Team
                </a>
                <a href="{{ route('public.articles.index') }}"
                    class="text-sm font-semibold tracking-wider uppercase {{ request()->routeIs('public.articles.*') ? 'text-[#f95716]' : 'text-slate-300' }} hover:text-[#f95716] transition-colors">
                    News & Articles
                </a>
            </nav>

            <!-- Desktop CTA -->
            <div class="hidden md:flex">
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center justify-center px-4 py-2.5 text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all rounded-xs shadow-sm shadow-[#f95716]/20">
                    Contact
                </a>
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
        class="fixed inset-0 transition-opacity duration-300 opacity-0 pointer-events-none md:hidden"
        style="background: rgba(0, 0, 0, 0.82); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); z-index: 9998;"
        aria-hidden="true"></div>

    <!-- Mobile Drawer -->
    <div id="mobile-drawer"
        class="fixed top-0 right-0 bottom-0 w-80 max-w-[85vw] border-l border-white/10 transform translate-x-full transition-transform duration-300 ease-in-out md:hidden flex flex-col justify-between p-6 overflow-y-auto"
        style="background: linear-gradient(180deg, #0e141f 0%, #070a10 100%); background-color: #0b0f17; box-shadow: -12px 0 40px rgba(0, 0, 0, 0.85); z-index: 9999;">
        <div>
            <div class="flex items-center justify-between pb-5 border-b border-white/10">
                <a href="/" class="flex items-center gap-2 focus:outline-none"
                    aria-label="{{ get_setting('company_name', 'COMPANY NAME') }} Home">
                    @if(get_setting('site_logo'))
                        <img src="{{ asset(get_setting('site_logo')) }}"
                            alt="{{ get_setting('company_name', 'COMPANY NAME') }}" class="h-7 w-auto object-contain">
                    @else
                        <span class="w-2 h-5 bg-[#f95716]"></span>
                        <span class="font-heading text-lg font-bold tracking-wider text-white uppercase">
                            {{ $nameParts[0] }} @if(isset($nameParts[1]))<span
                            class="text-[#f95716]">{{ $nameParts[1] }}</span>@endif
                        </span>
                    @endif
                </a>
                <button id="mobile-menu-close" type="button"
                    class="p-2 rounded-lg bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-all cursor-pointer"
                    aria-label="Close navigation">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <nav class="mt-6 flex flex-col space-y-1.5" aria-label="Mobile Navigation Links">
                <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <span>Home</span>
                </a>
                <a href="{{ route('about') }}"
                    class="mobile-nav-link {{ request()->routeIs('about') ? 'active' : '' }}">
                    <span>About</span>
                </a>
                <a href="{{ route('home') }}#services" class="mobile-nav-link">
                    <span>Services</span>
                </a>
                <a href="{{ route('public.projects.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('public.projects.*') ? 'active' : '' }}">
                    <span>Projects</span>
                </a>
                <a href="{{ route('team') }}" class="mobile-nav-link {{ request()->routeIs('team*') ? 'active' : '' }}">
                    <span>Team</span>
                </a>
                <a href="{{ route('public.articles.index') }}"
                    class="mobile-nav-link {{ request()->routeIs('public.articles.*') ? 'active' : '' }}">
                    <span>News &amp; Articles</span>
                </a>
            </nav>
        </div>

        <div class="pt-6 border-t border-white/10 space-y-3">
            <a href="{{ route('contact') }}"
                class="inline-flex items-center justify-center w-full py-3.5 px-4 text-xs font-bold uppercase tracking-wider text-white bg-[#f95716] hover:bg-[#ea4907] transition-all rounded-md shadow-lg shadow-[#f95716]/25 hover:shadow-[#f95716]/40 cursor-pointer">
                <span>Contact</span>
                <svg class="w-4 h-4 ms-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
            @if(get_setting('primary_phone'))
                <div class="text-center text-xs text-slate-400">
                    Call Us: <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('primary_phone')) }}"
                        class="text-slate-200 hover:text-[#f95716] font-semibold transition-colors">{{ get_setting('primary_phone') }}</a>
                </div>
            @endif
        </div>
    </div>
</header>