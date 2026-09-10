@extends('themes.apex-dark.layouts.app')

@section('title', $title ?? ($member->name . ' — ' . $member->designation))

@section('content')
    @if(isset($member))
    <!-- Team Member Profile Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="mb-6">
                <a href="{{ route('team') }}" class="inline-flex items-center gap-2 text-xs font-syne font-bold text-amber-400 hover:text-amber-300 uppercase tracking-wider">
                    <span>← Return to Directorate</span>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <div class="lg:col-span-4">
                    <div class="apex-card rounded-3xl overflow-hidden border border-white/10 shadow-2xl">
                        <img src="{{ $member->photo_url ?: asset('images/team-1.jpg') }}" 
                             alt="{{ $member->name }}" 
                             class="w-full h-96 object-cover object-top filter contrast-110">
                    </div>
                </div>

                <div class="lg:col-span-8 space-y-6">
                    <span class="px-3.5 py-1.5 rounded-full bg-amber-400/10 text-amber-400 border border-amber-500/20 text-xs font-bold uppercase tracking-widest inline-block">
                        {{ $member->department ?? 'Engineering Division' }}
                    </span>

                    <h1 class="font-syne text-3xl sm:text-5xl font-black text-white leading-tight tracking-tight">
                        {{ $member->name }}
                    </h1>

                    <span class="text-base sm:text-lg text-amber-400 font-semibold block">
                        {{ $member->designation }}
                    </span>

                    <div class="prose prose-invert max-w-none text-slate-300 text-base leading-relaxed font-light space-y-4 pt-4 border-t border-white/10">
                        <p>{{ $member->bio }}</p>
                    </div>

                    <div class="pt-6 border-t border-white/10 flex flex-wrap items-center gap-4">
                        @if($member->email)
                            <a href="mailto:{{ $member->email }}" class="px-6 py-3 rounded-xl bg-amber-400 text-slate-950 font-syne font-bold text-xs uppercase tracking-wider hover:bg-amber-300 transition-all flex items-center gap-2">
                                <i class="ri-mail-line"></i>
                                <span>Direct Consultation</span>
                            </a>
                        @endif
                        @if($member->linkedin_url)
                            <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener noreferrer" class="px-6 py-3 rounded-xl bg-white/5 hover:bg-white/10 text-white font-syne font-bold text-xs uppercase tracking-wider border border-white/10 transition-all flex items-center gap-2">
                                <i class="ri-linkedin-fill text-amber-400"></i>
                                <span>LinkedIn Profile</span>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Other Team Members -->
    @if(isset($relatedMembers) && $relatedMembers->count() > 0)
        <section class="py-20 bg-[#090d16]">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <h2 class="font-syne text-2xl font-bold text-white mb-8">
                    Other Technical Leads & Directors
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                    @foreach($relatedMembers->take(3) as $other)
                        <div class="apex-card rounded-2xl p-6 flex items-center gap-4 group">
                            <img src="{{ $other->photo_url ?: asset('images/team-1.jpg') }}" alt="{{ $other->name }}" class="w-16 h-16 rounded-xl object-cover grayscale group-hover:grayscale-0 transition-all">
                            <div>
                                <h4 class="font-syne text-sm font-bold text-white group-hover:text-amber-400 transition-colors">
                                    <a href="{{ route('team.show', $other->id) }}">{{ $other->name }}</a>
                                </h4>
                                <span class="text-xs text-slate-400 block">{{ $other->designation }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
    @endif
@endsection


