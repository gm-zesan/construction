@extends('themes.apex-dark.layouts.app')

@section('title', ($member->name ?? 'Engineer Dossier') . ' — Technical Leadership')

@section('content')
    @if(isset($member))
    <!-- Team Member Profile Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[12vw]">
            DOSSIER
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-6 flex items-center gap-3">
                <a href="{{ route('team') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-wider transition-colors">
                    <i class="ri-arrow-left-line"></i>
                    <span>Return to Directorate</span>
                </a>
                <span class="text-white/20">/</span>
                <span class="text-xs text-slate-400 font-mono">{{ $member->department ?? 'Engineering' }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-4">
                    <div class="bg-[#0a101d] border border-white/10 relative overflow-hidden group shadow-2xl">
                        <div class="wilmer-badge-sq">■</div>
                        <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-[450px] object-cover object-top filter contrast-105">
                        <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-[#0a101d] via-[#0a101d]/60 to-transparent p-6">
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest font-bold block">LICENSED PRACTITIONER</span>
                            <span class="text-xs font-mono text-slate-300">REGISTRATION ID: APX-{{ str_pad($member->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                        <span>● {{ $member->department ?? 'Structural Directorate' }}</span>
                    </div>

                    <div>
                        <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl font-black text-white uppercase tracking-tight leading-[0.95]">
                            {{ $member->name }}
                        </h1>
                        <span class="text-lg font-['Barlow_Condensed'] font-bold text-[#DFFE40] uppercase tracking-wide block mt-2">
                            {{ $member->designation }}
                        </span>
                    </div>

                    <!-- Professional Summary Quote -->
                    <div class="bg-[#0e172a] border-l-4 border-[#DFFE40] p-6">
                        <p class="text-slate-300 text-base leading-relaxed font-light">
                            {{ $member->bio }}
                        </p>
                    </div>

                    <!-- Technical Disciplines Spec Box -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-4">
                        <div class="p-4 bg-[#0a101d] border border-white/5 space-y-1">
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">CORE DOMAIN</span>
                            <span class="font-['Barlow_Condensed'] font-bold text-white text-base uppercase">Structural & Civil Systems</span>
                        </div>
                        <div class="p-4 bg-[#0a101d] border border-white/5 space-y-1">
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">STATUS</span>
                            <span class="font-['Barlow_Condensed'] font-bold text-emerald-400 text-base uppercase">Active Directorate Member</span>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-white/10 flex flex-wrap items-center gap-4">
                        @if($member->email)
                            <a href="mailto:{{ $member->email }}" class="px-6 py-3.5 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-['Barlow_Condensed'] font-black text-xs uppercase tracking-widest transition-all shadow-xl shadow-[#DFFE40]/20 flex items-center gap-2">
                                <i class="ri-mail-line"></i>
                                <span>Direct Technical Consultation</span>
                            </a>
                        @endif
                        @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3.5 bg-[#0a101d] hover:bg-white/10 text-white font-['Barlow_Condensed'] font-bold text-xs uppercase tracking-widest border border-white/10 transition-all flex items-center gap-2">
                                <i class="ri-linkedin-fill text-[#DFFE40]"></i>
                                <span>Professional Profile</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Other Team Members -->
    @if(isset($relatedMembers) && $relatedMembers->count() > 0)
        <section class="py-24 bg-[#050912] border-t border-white/5 relative overflow-hidden">
            <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[10vw]">
                DIRECTORS
            </div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-12 gap-4">
                    <div>
                        <span class="text-xs font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">EXECUTIVE TEAM</span>
                        <h2 class="font-['Barlow_Condensed'] text-3xl sm:text-4xl font-black uppercase text-white tracking-wide mt-1">
                            Other Technical Leads & Directors
                        </h2>
                    </div>
                    <a href="{{ route('team') }}" class="text-xs font-['Barlow_Condensed'] font-bold text-[#DFFE40] hover:text-[#e8ff66] uppercase tracking-widest flex items-center gap-1">
                        <span>View All Directorate</span>
                        <i class="ri-arrow-right-line"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                    @foreach($relatedMembers->take(3) as $other)
                        <div class="wilmer-card bg-[#0a101d] p-6 border border-white/10 flex items-center gap-5 group">
                            <div class="relative w-20 h-20 shrink-0 overflow-hidden bg-slate-900 border border-white/10">
                                <img src="{{ $other->photo_url ?: asset('images/team-1.jpg') }}" alt="{{ $other->name }}" class="w-full h-full object-cover filter grayscale group-hover:grayscale-0 transition-all">
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-[#DFFE40] uppercase font-bold block">{{ $other->designation }}</span>
                                <h4 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white group-hover:text-[#DFFE40] transition-colors">
                                    <a href="{{ route('team.show', $other->id) }}">{{ $other->name }}</a>
                                </h4>
                                <a href="{{ route('team.show', $other->id) }}" class="text-[11px] font-['Barlow_Condensed'] font-bold text-slate-400 group-hover:text-white uppercase tracking-wider mt-1 inline-block">
                                    View Dossier →
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @endif
@endsection
