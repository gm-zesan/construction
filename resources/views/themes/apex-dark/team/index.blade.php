@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Team Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6">
                        <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                        {{ get_content('team', 'hero', 'badge', 'Technical Directorate') }}
                    </div>
                    <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight">
                        {!! get_content('team', 'hero', 'title', 'Master Engineers & <span class="apex-gradient-text">Architectural Leads</span>.') !!}
                    </h1>
                </div>
                <p class="text-slate-300 text-base max-w-md font-light leading-relaxed">
                    {{ get_content('team', 'hero', 'subtitle', 'Our multidisciplinary team of licensed structural engineers, geotechnical consultants, computational architects, and project directors.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Team Directory Grid -->
    <section class="py-24 bg-[#090d16] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($teamMembers) && $teamMembers->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($teamMembers as $member)
                        <div class="apex-card rounded-2xl overflow-hidden group flex flex-col justify-between">
                            <div>
                                <div class="relative h-80 overflow-hidden bg-slate-900">
                                    <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-full h-full object-cover object-top filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a0f1d] via-transparent to-transparent"></div>
                                    
                                    @if($member->department)
                                        <div class="absolute top-4 left-4">
                                            <span class="px-3 py-1 rounded-full bg-slate-950/80 backdrop-blur-md text-amber-400 border border-amber-500/30 text-[11px] font-bold uppercase tracking-wider">
                                                {{ $member->department }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 space-y-2">
                                    <span class="text-xs text-amber-400 uppercase tracking-wider font-semibold block">{{ $member->designation }}</span>
                                    <h3 class="font-syne text-lg font-bold text-white group-hover:text-amber-400 transition-colors">
                                        <a href="{{ route('team.show', $member->id) }}">
                                            {{ $member->name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed font-light">{{ $member->bio }}</p>
                                </div>
                            </div>

                            <div class="p-6 pt-0 flex items-center justify-between border-t border-white/5">
                                <a href="{{ route('team.show', $member->id) }}" class="text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                                    View Dossier →
                                </a>
                                @if($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" class="w-8 h-8 rounded-lg bg-white/5 hover:bg-amber-400 hover:text-slate-950 flex items-center justify-center text-slate-400 transition-colors">
                                        <i class="ri-linkedin-fill text-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/[0.02] rounded-3xl border border-white/5">
                    <i class="ri-team-line text-4xl text-slate-600 mb-4 block"></i>
                    <h3 class="font-syne text-xl font-bold text-white mb-2">No Team Members Found</h3>
                    <p class="text-slate-400 text-sm">Our technical directory is currently being updated.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
