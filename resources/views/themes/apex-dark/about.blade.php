@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Page Header / Architectural Hero -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-project-main.jpg') }}" alt="Apex Engineering History" class="w-full h-full object-cover opacity-15 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-[#070a12] via-[#070a12]/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    {{ get_content('about', 'hero', 'badge', 'Corporate Dossier & Heritage') }}
                </div>
                <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight mb-6">
                    {!! get_content('about', 'hero', 'title', 'Engineering the <span class="apex-gradient-text">Impossible</span> Since 2008.') !!}
                </h1>
                <p class="text-base sm:text-lg text-slate-300 leading-relaxed font-light">
                    {{ get_content('about', 'hero', 'subtitle', 'Apex is an international multidisciplinary construction and structural engineering enterprise specializing in monumental high-rises, civic infrastructures, and sustainable architectural frameworks.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Manifesto & Story Section -->
    <section class="py-24 bg-[#090d16] relative border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Visual Stats Column -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="relative rounded-3xl overflow-hidden border border-white/10 group shadow-2xl">
                        <img src="{{ asset('images/project-commercial-tower.jpg') }}" alt="Apex Superstructure" class="w-full h-[480px] object-cover filter contrast-110 group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#070a12] via-transparent to-transparent"></div>
                        
                        <div class="absolute bottom-6 left-6 right-6 p-6 rounded-2xl apex-glass border border-white/10">
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Years of Mastery</span>
                                    <span class="font-syne text-3xl font-black text-white">
                                        {{ get_content('about', 'story', 'exp_years', '18+') }}
                                    </span>
                                </div>
                                <div class="text-right">
                                    <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Global ISO Certified</span>
                                    <span class="font-syne text-sm font-bold text-emerald-400">9001 / 14001 / 45001</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Narrative Column -->
                <div class="lg:col-span-7 space-y-8">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Our Foundation</span>
                        <h2 class="font-syne text-3xl sm:text-4xl font-black text-white leading-tight">
                            {!! get_content('about', 'story', 'heading', 'Precision Physics & <span class="apex-gradient-text">Architectural Innovation</span>.') !!}
                        </h2>
                    </div>

                    <p class="text-slate-300 text-base sm:text-lg leading-relaxed font-light">
                        {{ get_content('about', 'story', 'description', 'Founded by a consortium of visionary structural engineers and master architects, Apex has grown into an international powerhouse. We combine computational generative design, advanced concrete metallurgy, and hyper-accurate site supervision to turn daring concepts into resilient reality.') }}
                    </p>

                    <!-- 3 Core Pillars -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 pt-4">
                        <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/5 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-base">01</div>
                            <h3 class="font-syne text-base font-bold text-white">Parametric BIM</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">Level 3 coordinate modeling with micron-grade collision mitigation.</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/5 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-base">02</div>
                            <h3 class="font-syne text-base font-bold text-white">Low-Carbon Grid</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">Eco-certified pozzolanic concrete yielding 42% lower embodied carbon.</p>
                        </div>
                        <div class="p-6 rounded-2xl bg-white/[0.03] border border-white/5 space-y-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-base">03</div>
                            <h3 class="font-syne text-base font-bold text-white">Zero Tolerance</h3>
                            <p class="text-xs text-slate-400 leading-relaxed">On-site geotechnical laser scanning across every pour cycle.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Leadership Section -->
    @if(isset($leadership) && count($leadership) > 0)
        <section class="py-24 bg-[#070a12] relative border-b border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Executive Governance</span>
                        <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                            {{ get_content('about', 'leadership', 'title', 'Engineering Leadership & Directors') }}
                        </h2>
                    </div>
                    <a href="{{ route('team') }}" class="inline-flex items-center gap-2 text-sm font-syne font-bold text-amber-400 hover:text-amber-300">
                        <span>View Full Technical Directory</span>
                        <span>→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach(array_slice($leadership, 0, 4) as $leader)
                        <div class="apex-card rounded-2xl overflow-hidden group">
                            <div class="relative h-72 overflow-hidden bg-slate-900">
                                <img src="{{ $leader['image'] }}" alt="{{ $leader['name'] }}" class="w-full h-full object-cover object-top filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                                <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>
                            </div>
                            <div class="p-6 space-y-2">
                                <span class="text-xs text-amber-400 uppercase tracking-wider font-semibold block">{{ $leader['role'] }}</span>
                                <h3 class="font-syne text-lg font-bold text-white group-hover:text-amber-400 transition-colors">{{ $leader['name'] }}</h3>
                                <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed">{{ $leader['bio'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Accreditations & Honours -->
    @if(isset($accreditations) && count($accreditations) > 0)
        <section class="py-24 bg-[#090d16] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16 space-y-3">
                    <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block">Recognitions</span>
                    <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                        {{ get_content('about', 'accreditations', 'title', 'Accreditations & Industry Honours') }}
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($accreditations as $item)
                        <div class="apex-card rounded-2xl p-6 flex flex-col justify-between border border-white/5 space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="px-3 py-1 rounded-full bg-amber-400/10 text-amber-400 text-xs font-bold">{{ $item['year'] }}</span>
                                <span class="text-xs text-emerald-400 uppercase tracking-widest font-bold">{{ $item['status'] }}</span>
                            </div>
                            <div>
                                <h3 class="font-syne text-lg font-bold text-white mb-1">{{ $item['title'] }}</h3>
                                <p class="text-xs text-slate-400">{{ $item['category'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Call to Action Banner -->
    <section class="py-20 bg-[#070a12] relative border-t border-white/5">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center space-y-8">
            <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                {!! get_content('about', 'cta', 'title', 'Partner With Apex on Your Next Landmark Build.') !!}
            </h2>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-syne font-bold text-base hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all duration-300">
                    {{ get_content('about', 'cta', 'btn_text', 'Schedule Executive Consultation') }}
                </a>
                <a href="{{ route('public.projects.index') }}" class="px-8 py-4 rounded-xl bg-white/5 hover:bg-white/10 text-white font-syne font-bold text-base border border-white/15 transition-all duration-300">
                    Explore Signature Portfolio
                </a>
            </div>
        </div>
    </section>
@endsection
