@extends('themes.apex-dark.layouts.app')

@section('title', 'Technical Directorate & Engineering Leadership — Apex Engineering')

@section('content')
    <!-- Team Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[12vw]">
            PROFESSIONALS
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
                <div class="max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#DFFE40] animate-ping"></span>
                        {{ get_content('team', 'hero', 'badge', 'TECHNICAL DIRECTORATE & ADVISORY') }}
                    </div>
                    <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight leading-[0.95]">
                        {!! get_content('team', 'hero', 'title', 'Master Engineers & <span class="text-[#DFFE40]">Architectural Leads</span>.') !!}
                    </h1>
                </div>
                <p class="text-slate-300 text-sm sm:text-base max-w-md font-light leading-relaxed">
                    {{ get_content('team', 'hero', 'subtitle', 'Our multidisciplinary consortium of licensed structural engineers, geotechnical consultants, computational architects, and project directors.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Team Directory Grid -->
    <section class="py-24 bg-[#080d1a] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            @if(isset($teamMembers) && $teamMembers->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach($teamMembers as $member)
                        <div class="wilmer-card bg-[#0a101d] border border-white/10 group flex flex-col justify-between">
                            <div>
                                <div class="relative h-96 overflow-hidden bg-slate-900">
                                    <div class="wilmer-badge-sq">■</div>
                                    <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                                         alt="{{ $member->name }}" 
                                         class="w-full h-full object-cover object-top filter grayscale group-hover:grayscale-0 group-hover:scale-105 transition-all duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-[#0a101d] via-transparent to-transparent opacity-80 group-hover:opacity-40 transition-opacity"></div>
                                    
                                    @if($member->department)
                                        <div class="absolute bottom-3 left-4">
                                            <span class="px-2.5 py-0.5 bg-[#080d1a]/90 text-[#DFFE40] text-[10px] font-mono uppercase tracking-widest font-bold border border-white/10">
                                                {{ $member->department }}
                                            </span>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-6 space-y-2">
                                    <span class="text-[11px] font-mono text-[#DFFE40] uppercase tracking-wider font-bold block">{{ $member->designation }}</span>
                                    <h3 class="font-['Barlow_Condensed'] text-2xl font-black text-white uppercase tracking-wide group-hover:text-[#DFFE40] transition-colors">
                                        <a href="{{ route('team.show', $member->id) }}">
                                            {{ $member->name }}
                                        </a>
                                    </h3>
                                    <p class="text-xs text-slate-400 line-clamp-2 leading-relaxed font-light">{{ $member->bio }}</p>
                                </div>
                            </div>

                            <div class="p-6 pt-0 flex items-center justify-between border-t border-white/5">
                                <a href="{{ route('team.show', $member->id) }}" class="text-xs font-['Barlow_Condensed'] font-bold text-white uppercase tracking-widest group-hover:text-[#DFFE40] flex items-center gap-1 transition-colors">
                                    <span>View Dossier</span>
                                    <i class="ri-arrow-right-line text-[#DFFE40]"></i>
                                </a>
                                @if($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" class="w-8 h-8 bg-white/5 hover:bg-[#DFFE40] hover:text-slate-950 flex items-center justify-center text-slate-400 transition-colors">
                                        <i class="ri-linkedin-fill text-sm"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-[#0a101d] border border-white/10 p-12">
                    <i class="ri-team-line text-5xl text-[#DFFE40] mb-4 block"></i>
                    <h3 class="font-['Barlow_Condensed'] text-3xl font-black uppercase text-white tracking-wide mb-2">Technical Roster Initializing</h3>
                    <p class="text-slate-400 text-xs font-mono">Our engineering directorate profile database is currently being populated.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
