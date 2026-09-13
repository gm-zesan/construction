<!-- Header for Apex Theme (Exact Wilmer Architecture Style) -->
<header id="site-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300 shadow-md">
    <!-- Main Header Bar -->
    <div class="h-20 sm:h-24 bg-white flex items-stretch justify-between border-b border-slate-200">
        <!-- 1. Left: Solid Accent Logo Box -->
        <a href="{{ route('home') }}" class="bg-[#DFFE40] hover:bg-[#cbe838] px-6 sm:px-12 flex items-center justify-center transition-colors shrink-0 group">
            <span class="font-['Barlow_Condensed'] font-black text-3xl sm:text-4xl lg:text-5xl text-slate-950 uppercase tracking-wider">
                {{ get_setting('company_name', 'Wilmër') }}
            </span>
        </a>

        <!-- 2. Middle: Modular Desktop Navigation with Vertical Dividers -->
        <nav class="hidden lg:flex items-stretch flex-1 font-['Barlow_Condensed'] font-bold text-base sm:text-lg tracking-wider uppercase">
            <a href="{{ route('home') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('home') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                Home
            </a>
            <a href="{{ route('about') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('about') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                About Us
            </a>
            <a href="{{ route('public.projects.index') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('public.projects.*') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                Portfolio
            </a>
            <a href="{{ route('public.articles.index') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('public.articles.*') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                Blog
            </a>
            <a href="{{ route('team') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('team*') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                Team
            </a>
            <a href="{{ route('contact') }}" 
               class="flex items-center px-6 sm:px-8 border-r border-slate-200 transition-colors {{ request()->routeIs('contact') ? 'text-[#7da700] font-black' : 'text-[#0b163f] hover:text-[#7da700]' }}">
                Contact
            </a>
        </nav>

        <!-- 3. Right: Utility Action Columns (Search, Cart/Quote, Hamburger) -->
        <div class="flex items-stretch shrink-0">
            <!-- Search Icon Cell -->
            <button type="button" id="apex-search-toggle" class="w-16 sm:w-20 border-l border-r border-slate-200 flex items-center justify-center text-[#0b163f] hover:text-[#7da700] transition-colors focus:outline-none" aria-label="Search">
                <i class="ri-search-line text-xl sm:text-2xl"></i>
            </button>

            <!-- Full-Height Accent Hamburger / Menu Button -->
            <button type="button" id="apex-mobile-toggle" class="w-20 sm:w-24 bg-[#DFFE40] hover:bg-[#cbe838] flex flex-col items-center justify-center gap-1.5 transition-colors focus:outline-none cursor-pointer" aria-label="Toggle Menu">
                <span class="w-7 h-[3px] bg-[#080e1a] block"></span>
                <span class="w-7 h-[3px] bg-[#080e1a] block"></span>
                <span class="w-7 h-[3px] bg-[#080e1a] block"></span>
            </button>
        </div>
    </div>

    <!-- Search Dropdown Overlay -->
    <div id="apex-search-modal" class="hidden fixed inset-0 z-50 bg-[#080e1a]/95 backdrop-blur-md flex items-center justify-center p-6">
        <button type="button" id="apex-search-close" class="absolute top-8 right-8 text-white hover:text-[#DFFE40] text-3xl focus:outline-none">
            <i class="ri-close-line"></i>
        </button>
        <div class="w-full max-w-3xl space-y-4">
            <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">DISCOVER ARCHIVES</span>
            <form action="{{ route('public.articles.index') }}" method="GET" class="relative">
                <input type="text" name="search" placeholder="Type to search architectural projects & articles..." 
                       class="w-full py-5 bg-transparent border-b-2 border-white/20 text-white font-['Barlow_Condensed'] text-2xl sm:text-4xl uppercase tracking-wider focus:outline-none focus:border-[#DFFE40] placeholder:text-slate-600">
                <button type="submit" class="absolute right-0 top-5 text-white hover:text-[#DFFE40]">
                    <i class="ri-arrow-right-line text-3xl"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Fullscreen / Mobile Drawer -->
    <div id="apex-mobile-drawer" class="fixed inset-0 z-50 bg-[#080e1a]/98 backdrop-blur-2xl transition-transform duration-300 transform translate-x-full flex flex-col justify-between p-8 sm:p-12">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-white/10">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 bg-[#DFFE40] text-slate-950 font-['Barlow_Condensed'] font-black text-2xl uppercase tracking-wider">
                        {{ get_setting('company_name', 'Wilmër') }}
                    </span>
                    <span class="text-xs font-mono text-slate-400 uppercase">Architecture & Build</span>
                </div>
                <button type="button" id="apex-mobile-close" class="w-10 h-10 bg-white/10 text-white hover:text-[#DFFE40] flex items-center justify-center text-2xl transition-colors">
                    <i class="ri-close-line"></i>
                </button>
            </div>
            <nav class="flex flex-col gap-4 mt-10 font-['Barlow_Condensed'] font-black text-3xl sm:text-4xl tracking-wider uppercase">
                <a href="{{ route('home') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>Home</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
                <a href="{{ route('about') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>About Us</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
                <a href="{{ route('public.projects.index') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>Portfolio</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
                <a href="{{ route('public.articles.index') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>Blog & Insights</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
                <a href="{{ route('team') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>Technical Team</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
                <a href="{{ route('contact') }}" class="py-2 text-white hover:text-[#DFFE40] transition-colors flex items-center justify-between border-b border-white/5">
                    <span>Contact</span>
                    <i class="ri-arrow-right-line text-xl text-[#DFFE40]"></i>
                </a>
            </nav>
        </div>
        <div class="pt-6 border-t border-white/10 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <span class="text-xs font-mono text-slate-400">
                {{ get_setting('company_phone', '+1 (800) 456-7890') }} // {{ get_setting('company_email', 'info@apexbuild.com') }}
            </span>
            <a href="{{ route('contact') }}" class="w-full sm:w-auto px-8 py-4 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-['Barlow_Condensed'] font-black text-sm uppercase tracking-widest text-center shadow-lg shadow-[#DFFE40]/30">
                Request Project Consultation →
            </a>
        </div>
    </div>
</header>

<!-- Floating Right Sticky Badges (Wilmer Signature) -->
<div class="fixed right-0 top-1/2 -translate-y-1/2 z-40 hidden md:flex flex-col gap-2 shadow-2xl">
    <a href="{{ route('public.projects.index') }}" class="px-4 py-2.5 bg-[#e11d48] hover:bg-[#be123c] text-white text-[11px] font-['Barlow_Condensed'] font-black uppercase tracking-widest flex items-center gap-2 transition-all shadow-md">
        <span class="w-4 h-4 rounded-full bg-white/20 flex items-center justify-center text-[10px]">●</span>
        <span>RELATED</span>
    </a>
    <a href="{{ route('contact') }}" class="px-4 py-2.5 bg-white hover:bg-slate-100 text-[#0b163f] hover:text-[#7da700] text-[11px] font-['Barlow_Condensed'] font-black uppercase tracking-widest flex items-center gap-2 transition-all shadow-md border-l-2 border-[#DFFE40]">
        <i class="ri-shopping-cart-2-fill text-[#7da700]"></i>
        <span>BUY NOW</span>
    </a>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('apex-mobile-toggle');
        const close = document.getElementById('apex-mobile-close');
        const drawer = document.getElementById('apex-mobile-drawer');
        const searchToggle = document.getElementById('apex-search-toggle');
        const searchClose = document.getElementById('apex-search-close');
        const searchModal = document.getElementById('apex-search-modal');

        if (toggle && drawer) {
            toggle.addEventListener('click', () => drawer.classList.remove('translate-x-full'));
        }
        if (close && drawer) {
            close.addEventListener('click', () => drawer.classList.add('translate-x-full'));
        }
        if (searchToggle && searchModal) {
            searchToggle.addEventListener('click', () => searchModal.classList.remove('hidden'));
        }
        if (searchClose && searchModal) {
            searchClose.addEventListener('click', () => searchModal.classList.add('hidden'));
        }
    });
</script>
