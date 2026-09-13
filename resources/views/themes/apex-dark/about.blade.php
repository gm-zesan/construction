@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Page Header / Architectural Hero -->
    <!-- 1. Hero Section -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#080e1a] border-b border-white/[0.06]">
        <div class="wilmer-watermark">ABOUT US</div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">
                        {{ get_content('about', 'hero', 'badge', 'CORPORATE DOSSIER & HERITAGE') }}
                    </span>
                </div>
                <h1 class="font-barlow font-black text-4xl sm:text-6xl lg:text-7xl text-white uppercase tracking-wider leading-none">
                    {!! get_content('about', 'hero', 'title', 'ENGINEERING THE <span class="text-[#DFFE40]">IMPOSSIBLE.</span>') !!}
                </h1>
                <p class="text-slate-300 text-base sm:text-lg font-light leading-relaxed">
                    {{ get_content('about', 'hero', 'subtitle', 'Apex is an international multidisciplinary construction and structural engineering enterprise specializing in monumental high-rises, civic infrastructures, and sustainable architectural frameworks.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- 2. Story & Manifesto Section -->
    <section class="py-24 bg-[#050912] relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left: Dual Image Collage -->
                <div class="lg:col-span-6 relative">
                    <div class="relative overflow-hidden border border-white/10 shadow-2xl">
                        <div class="wilmer-badge-sq">■</div>
                        <img src="{{ asset('images/about-main.jpg') }}" alt="Apex Engineering Site" class="w-full h-[450px] object-cover filter contrast-110">
                    </div>
                    <!-- Overlaid Experience Badge -->
                    <div class="absolute -bottom-6 -right-6 bg-[#DFFE40] text-slate-950 font-black p-6 sm:p-8 shadow-2xl hidden sm:block">
                        <span class="font-barlow font-black text-4xl sm:text-5xl block leading-none">
                            {{ get_content('about', 'story', 'exp_years', '18+') }}
                        </span>
                        <span class="text-xs font-barlow font-bold uppercase tracking-widest mt-1 block">
                            Years of Field Innovation
                        </span>
                    </div>
                </div>

                <!-- Right: Manifesto Content -->
                <div class="lg:col-span-6 space-y-6">
                    <div class="inline-flex items-center gap-2">
                        <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                        <span class="font-barlow font-bold text-xs uppercase tracking-widest text-[#DFFE40]">OUR MANIFESTO</span>
                    </div>

                    <h2 class="font-barlow font-black text-3xl sm:text-4xl text-white uppercase tracking-wide leading-tight">
                        {!! get_content('about', 'story', 'heading', 'PRECISION PHYSICS & <span class="text-[#DFFE40]">ARCHITECTURAL INNOVATION.</span>') !!}
                    </h2>

                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed font-light">
                        {{ get_content('about', 'story', 'description', 'Founded by a consortium of visionary structural engineers and master architects, Apex has grown into an international powerhouse. We combine computational generative design, advanced concrete metallurgy, and hyper-accurate site supervision to turn daring concepts into resilient reality.') }}
                    </p>

                    <div class="grid grid-cols-2 gap-6 pt-4 border-t border-white/10">
                        <div class="p-4 bg-[#0e172a] border-l-2 border-l-[#DFFE40]">
                            <span class="font-barlow font-black text-2xl text-white block">100%</span>
                            <span class="text-xs text-slate-400 font-light uppercase tracking-wider">Seismic Compliance</span>
                        </div>
                        <div class="p-4 bg-[#0e172a] border-l-2 border-l-[#DFFE40]">
                            <span class="font-barlow font-black text-2xl text-white block">350+</span>
                            <span class="text-xs text-slate-400 font-light uppercase tracking-wider">Towers Delivered</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. Accreditations Section -->
    <section class="py-24 bg-[#080e1a] border-t border-white/[0.06]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <div class="inline-flex items-center gap-2 mb-2">
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                    <span class="font-barlow font-bold text-xs uppercase tracking-[0.25em] text-[#DFFE40]">RECOGNITION</span>
                    <span class="w-6 h-[2px] bg-[#DFFE40]"></span>
                </div>
                <h2 class="font-barlow font-black text-4xl text-white uppercase tracking-wider">
                    {{ get_content('about', 'accreditations', 'title', 'Accreditations & Industry Honours') }}
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="p-8 bg-[#0e172a] border border-white/[0.08] relative">
                    <div class="wilmer-badge-sq">■</div>
                    <span class="font-mono text-xs text-[#DFFE40] block mb-2">YEAR 2024</span>
                    <h4 class="font-barlow font-black text-2xl text-white uppercase tracking-wider mb-2">Build of the Year</h4>
                    <p class="text-xs text-slate-400 font-light">Commercial High-Rise Development — International Council of Tall Buildings.</p>
                </div>
                <div class="p-8 bg-[#0e172a] border border-white/[0.08] relative">
                    <div class="wilmer-badge-sq">■</div>
                    <span class="font-mono text-xs text-[#DFFE40] block mb-2">YEAR 2023</span>
                    <h4 class="font-barlow font-black text-2xl text-white uppercase tracking-wider mb-2">Top Build Award</h4>
                    <p class="text-xs text-slate-400 font-light">Sustainable Civil & Structural Engineering — Green Building Alliance.</p>
                </div>
                <div class="p-8 bg-[#0e172a] border border-white/[0.08] relative">
                    <div class="wilmer-badge-sq">■</div>
                    <span class="font-mono text-xs text-[#DFFE40] block mb-2">YEAR 2022</span>
                    <h4 class="font-barlow font-black text-2xl text-white uppercase tracking-wider mb-2">Best Design of the Year</h4>
                    <p class="text-xs text-slate-400 font-light">Architectural Innovation & BIM Level 3 Execution Distinction.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 4. CTA Box -->
    <section class="py-20 bg-[#DFFE40] text-slate-950 font-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-6">
            <h2 class="font-barlow font-black text-3xl sm:text-5xl uppercase tracking-wider">
                {!! get_content('about', 'cta', 'title', 'Partner With Apex on Your Next Landmark Build.') !!}
            </h2>
            <div class="flex justify-center gap-4 pt-2">
                <a href="{{ route('contact') }}" class="px-8 py-4 bg-[#080e1a] hover:bg-[#050912] text-white font-barlow font-black text-sm uppercase tracking-widest shadow-2xl">
                    {{ get_content('about', 'cta', 'btn_text', 'Schedule Executive Consultation') }}
                </a>
                <a href="{{ route('public.projects.index') }}" class="px-8 py-4 bg-white/20 hover:bg-white/30 text-white font-barlow font-bold text-sm uppercase tracking-widest border border-white/30">
                    Explore Portfolio
                </a>
            </div>
        </div>
    </section>
@endsection
