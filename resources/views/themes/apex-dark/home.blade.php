@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-[90vh] flex items-center pt-32 pb-20 overflow-hidden">
        <!-- Background Imagery & Ambient Gradients -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="Apex Engineering Skyline" class="w-full h-full object-cover object-center opacity-25 filter grayscale contrast-125">
            <div class="absolute inset-0 bg-gradient-to-t from-[#070a12] via-[#070a12]/80 to-transparent"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-[#070a12] via-[#070a12]/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                <!-- Left Content -->
                <div class="lg:col-span-7 space-y-6">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        {{ get_content('home', 'hero', 'badge', 'Next-Gen Structural Precision') }}
                    </div>

                    <!-- Main Heading -->
                    <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-[1.1] tracking-tight">
                        {!! get_content('home', 'hero', 'headline', get_content('home', 'hero', 'title', 'Engineering <span class="apex-gradient-text">Masterpieces</span> That Redefine Skylines.')) !!}
                    </h1>

                    <!-- Subtitle -->
                    <p class="text-base sm:text-lg text-slate-300 max-w-xl leading-relaxed font-light">
                        {!! get_content('home', 'hero', 'subheadline', get_content('home', 'hero', 'subtitle', 'From heavy commercial structures to intricate civil engineering, Apex delivers uncompromising build quality and architectural vision.')) !!}
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="{{ route('public.projects.index') }}" class="px-8 py-4 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-syne font-bold text-base hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all duration-300 hover:scale-105 flex items-center gap-2">
                            <span>{{ get_content('home', 'hero', 'primary_btn_text', 'Explore Portfolio') }}</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                        <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl bg-white/5 hover:bg-white/10 text-white font-syne font-bold text-base border border-white/15 transition-all duration-300 flex items-center gap-2">
                            <span>{{ get_content('home', 'hero', 'secondary_btn_text', 'Consult Engineers') }}</span>
                        </a>
                    </div>

                    <!-- Highlights row -->
                    <div class="grid grid-cols-3 gap-6 pt-6 border-t border-white/10 max-w-lg">
                        <div>
                            <span class="block font-syne text-2xl sm:text-3xl font-black text-amber-400">
                                {{ get_content('home', 'about_story', 'exp_years', get_content('home', 'telemetry', 'stat_1_value', '18')) }}+
                            </span>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-medium">Years Active</span>
                        </div>
                        <div>
                            <span class="block font-syne text-2xl sm:text-3xl font-black text-amber-400">
                                {{ get_content('home', 'experience', 'stat_1_count', get_content('home', 'telemetry', 'stat_2_value', '350')) }}+
                            </span>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-medium">Projects Done</span>
                        </div>
                        <div>
                            <span class="block font-syne text-2xl sm:text-3xl font-black text-amber-400">
                                {{ get_content('home', 'hero', 'stat_number', get_content('home', 'telemetry', 'stat_3_value', '99.8%')) }}
                            </span>
                            <span class="text-xs text-slate-400 uppercase tracking-wider font-medium">Safety Score</span>
                        </div>
                    </div>
                </div>

                <!-- Right Visual: Floating Glass Feature Card -->
                <div class="lg:col-span-5 relative">
                    <div class="relative apex-card rounded-3xl p-6 sm:p-8 backdrop-blur-xl border border-white/10 shadow-2xl">
                        <div class="flex items-center justify-between pb-6 border-b border-white/10">
                            <div>
                                <span class="text-xs uppercase tracking-widest text-amber-400 font-bold">Featured Capability</span>
                                <h3 class="font-syne text-xl font-bold text-white mt-1">High-Altitude Structural Grid</h3>
                            </div>
                            <span class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-xs font-semibold">Active</span>
                        </div>

                        <div class="space-y-4 py-6">
                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-lg shrink-0">
                                    01
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">Parametric 3D Engineering</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">BIM level 3 coordinate modeling for zero tolerance deviance.</p>
                                </div>
                            </div>

                            <div class="p-4 rounded-2xl bg-white/[0.03] border border-white/5 flex items-start gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center font-bold text-lg shrink-0">
                                    02
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">Carbon-Neutral Concrete</h4>
                                    <p class="text-xs text-slate-400 mt-0.5">Eco-certified high-load structural formulas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2">
                            <a href="{{ route('about') }}" class="w-full py-3 rounded-xl bg-white/5 hover:bg-amber-400 hover:text-slate-950 font-syne font-bold text-sm text-center block transition-all duration-300">
                                Discover Our Methodology →
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid Section -->
    @if(isset($services) && $services->count() > 0)
        <section class="py-24 bg-[#090d16] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Capabilities</span>
                        <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                            {!! get_content('home', 'services', 'title', 'Specialized Engineering Services') !!}
                        </h2>
                    </div>
                    <p class="text-sm text-slate-400 max-w-md">
                        {!! get_content('home', 'services', 'subtitle', 'Comprehensive civil, architectural, and turnkey project lifecycle management.') !!}
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($services as $service)
                        <div class="apex-card rounded-2xl p-8 flex flex-col justify-between group">
                            <div>
                                <div class="w-12 h-12 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center mb-6 group-hover:bg-amber-400 group-hover:text-slate-950 transition-colors duration-300">
                                    <i class="{{ $service->icon ?? 'ri-building-line' }} text-2xl"></i>
                                </div>
                                <h3 class="font-syne text-xl font-bold text-white mb-3 group-hover:text-amber-400 transition-colors">
                                    {{ $service->title }}
                                </h3>
                                <p class="text-sm text-slate-400 leading-relaxed">
                                    {{ Str::limit($service->short_description ?? $service->description, 120) }}
                                </p>
                            </div>
                            <div class="pt-6 mt-6 border-t border-white/5 flex items-center justify-between text-xs text-amber-400 font-bold uppercase tracking-wider">
                                <span>Learn More</span>
                                <span class="group-hover:translate-x-1 transition-transform">→</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Portfolio Projects Section -->
    @if(isset($projects) && $projects->count() > 0)
        <section class="py-24 bg-[#070a12] relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-16 gap-6">
                    <div>
                        <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Showcase</span>
                        <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                            {!! get_content('home', 'projects', 'title', 'Landmark Portfolio Works') !!}
                        </h2>
                    </div>
                    <a href="{{ route('public.projects.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-amber-400 hover:text-amber-300 transition-colors">
                        <span>View All Projects</span>
                        <span>→</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($projects as $project)
                        <div class="apex-card rounded-2xl overflow-hidden group flex flex-col">
                            <div class="relative h-64 overflow-hidden bg-slate-900">
                                @if($project->media && $project->media->count() > 0)
                                    <img src="{{ asset($project->media->first()->file_path) }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <img src="{{ asset('images/project-placeholder.jpg') }}" alt="{{ $project->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-[#090d16] via-transparent to-transparent"></div>
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 rounded-full bg-slate-950/80 backdrop-blur-md text-amber-400 text-xs font-bold border border-white/10">
                                        {{ $project->category ?? 'Commercial' }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6 flex-grow flex flex-col justify-between">
                                <div>
                                    <h3 class="font-syne text-lg font-bold text-white group-hover:text-amber-400 transition-colors mb-2">
                                        {{ $project->title }}
                                    </h3>
                                    <p class="text-xs text-slate-400 line-clamp-2">
                                        {{ $project->summary ?? Str::limit(strip_tags($project->description), 90) }}
                                    </p>
                                </div>
                                <div class="pt-4 mt-4 border-t border-white/5 flex items-center justify-between text-xs text-slate-400">
                                    <span>{{ $project->location ?? 'Global Site' }}</span>
                                    <a href="{{ route('public.projects.show', $project->slug) }}" class="text-amber-400 font-bold hover:underline">
                                        Case Study →
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Testimonials / Client Trust -->
    @if(isset($testimonials) && $testimonials->count() > 0)
        <section class="py-24 bg-[#090d16] border-y border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center max-w-2xl mx-auto mb-16">
                    <span class="text-xs uppercase tracking-widest text-amber-400 font-bold block mb-2">Endorsements</span>
                    <h2 class="font-syne text-3xl sm:text-4xl font-black text-white">
                        Trusted by Industry Giants
                    </h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($testimonials as $testi)
                        <div class="apex-card rounded-2xl p-8 flex flex-col justify-between">
                            <p class="text-sm text-slate-300 italic leading-relaxed mb-6">
                                "{{ $testi->review_text }}"
                            </p>
                            <div class="flex items-center gap-4 pt-4 border-t border-white/5">
                                <div class="w-11 h-11 rounded-full bg-amber-400/20 text-amber-400 flex items-center justify-center font-bold text-sm">
                                    {{ strtoupper(substr($testi->client_name ?? 'C', 0, 1)) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-white text-sm">{{ $testi->client_name }}</h4>
                                    <p class="text-xs text-slate-400">{{ $testi->client_designation ?? $testi->company_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Call to Action Banner -->
    <section class="py-20 relative overflow-hidden bg-gradient-to-r from-amber-600 via-amber-500 to-amber-600 text-slate-950">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <h2 class="font-syne text-3xl sm:text-5xl font-black text-slate-950 max-w-3xl mx-auto mb-6">
                Ready to Engineer Your Next Landmark?
            </h2>
            <p class="text-base sm:text-lg text-slate-900/80 max-w-xl mx-auto mb-8 font-medium">
                Collaborate with our structural specialists and turnkey project delivery teams today.
            </p>
            <div class="flex flex-wrap items-center justify-center gap-4">
                <a href="{{ route('contact') }}" class="px-8 py-4 rounded-xl bg-slate-950 text-white font-syne font-bold text-base hover:bg-slate-900 shadow-2xl transition-transform hover:scale-105">
                    Start a Conversation
                </a>
                <a href="{{ route('public.projects.index') }}" class="px-8 py-4 rounded-xl bg-amber-400/40 text-slate-950 border border-slate-950/20 font-syne font-bold text-base hover:bg-amber-400/60 transition-colors">
                    Review Portfolio
                </a>
            </div>
        </div>
    </section>
@endsection
