<!-- Header for Apex Architectural Dark Theme -->
<header id="site-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
    <!-- Announcement / Topbar -->
    <div class="bg-[#05070d]/90 border-b border-white/5 py-1.5 px-4 text-xs text-slate-400 hidden md:block">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center gap-1.5 text-amber-400 font-medium">
                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                    {{ get_setting('business_tagline', 'ISO 9001:2015 Certified Engineering') }}
                </span>
                <span class="text-slate-600">|</span>
                <span>{{ get_setting('contact_phone', '+1 (555) 234-5678') }}</span>
            </div>
            <div class="flex items-center gap-4">
                <span>{{ get_setting('contact_email', 'contact@construct.com') }}</span>
                <span class="text-slate-600">|</span>
                <span class="text-amber-400/80 font-mono text-[11px]">{{ get_setting('business_hours', 'Mon - Sat: 8:00 AM - 6:00 PM') }}</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Bar -->
    <div class="bg-[#090d16]/80 backdrop-blur-xl border-b border-white/[0.08] shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 to-amber-600 flex items-center justify-center text-slate-950 font-syne font-black text-xl shadow-lg shadow-amber-500/20 group-hover:scale-105 transition-transform duration-300">
                    A
                </div>
                <div>
                    <span class="font-syne font-black text-xl tracking-tight text-white group-hover:text-amber-400 transition-colors duration-200">
                        {{ get_setting('company_name', 'APEX') }}
                    </span>
                    <span class="block text-[10px] uppercase font-bold tracking-widest text-amber-400/90 -mt-1">
                        Architecture & Build
                    </span>
                </div>
            </a>

            <!-- Desktop Nav Items -->
            <nav class="hidden lg:flex items-center gap-1 bg-white/[0.03] p-1.5 rounded-full border border-white/[0.06]">
                <a href="{{ route('home') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('home') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Home
                </a>
                <a href="{{ route('about') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('about') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    About Us
                </a>
                <a href="{{ route('public.projects.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('public.projects.*') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Projects
                </a>
                <a href="{{ route('team') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('team') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Leadership
                </a>
                <a href="{{ route('public.articles.index') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('public.articles.*') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Insights
                </a>
                <a href="{{ route('contact') }}" 
                   class="px-5 py-2 rounded-full text-sm font-medium transition-all duration-200 {{ request()->routeIs('contact') ? 'bg-amber-400 text-slate-950 font-bold shadow-md shadow-amber-400/20' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                    Contact
                </a>
            </nav>

            <!-- Right CTA & Mobile Toggle -->
            <div class="flex items-center gap-3">
                <a href="{{ route('contact') }}" 
                   class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-bold text-sm hover:from-amber-300 hover:to-amber-400 transition-all duration-200 shadow-lg shadow-amber-500/20 hover:scale-[1.02]">
                    <span>Request Proposal</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                    </svg>
                </a>

                <!-- Mobile Menu Button -->
                <button type="button" id="apex-mobile-toggle" class="lg:hidden p-2.5 rounded-xl bg-white/5 text-slate-300 hover:text-white border border-white/10" aria-label="Toggle Navigation">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Drawer -->
    <div id="apex-mobile-drawer" class="fixed inset-0 z-50 bg-[#090d16]/95 backdrop-blur-2xl transition-transform duration-300 transform translate-x-full lg:hidden flex flex-col justify-between p-6">
        <div>
            <div class="flex items-center justify-between pb-6 border-b border-white/10">
                <span class="font-syne font-bold text-xl text-amber-400">{{ get_setting('company_name', 'APEX') }}</span>
                <button type="button" id="apex-mobile-close" class="p-2 text-slate-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <nav class="flex flex-col gap-3 mt-6">
                <a href="{{ route('home') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">Home</a>
                <a href="{{ route('about') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">About Us</a>
                <a href="{{ route('public.projects.index') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">Projects</a>
                <a href="{{ route('team') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">Leadership</a>
                <a href="{{ route('public.articles.index') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">Insights</a>
                <a href="{{ route('contact') }}" class="py-2.5 px-4 rounded-xl text-base font-medium text-slate-200 hover:bg-white/5">Contact</a>
            </nav>
        </div>
        <div class="pt-6 border-t border-white/10">
            <a href="{{ route('contact') }}" class="w-full py-3 rounded-xl bg-amber-400 text-slate-950 font-bold text-center block shadow-lg shadow-amber-400/20">
                Request Proposal
            </a>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('apex-mobile-toggle');
        const close = document.getElementById('apex-mobile-close');
        const drawer = document.getElementById('apex-mobile-drawer');

        if (toggle && drawer) {
            toggle.addEventListener('click', () => drawer.classList.remove('translate-x-full'));
        }
        if (close && drawer) {
            close.addEventListener('click', () => drawer.classList.add('translate-x-full'));
        }
    });
</script>
