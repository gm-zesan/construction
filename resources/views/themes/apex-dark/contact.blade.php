@extends('themes.apex-dark.layouts.app')

@section('title', 'Initiate Project Briefing & Consultation — Apex Engineering')

@section('content')
    <!-- Contact Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070c18] border-b border-white/5">
        <!-- Giant Ghost Architectural Watermark -->
        <div class="wilmer-watermark select-none pointer-events-none top-6 left-1/2 -translate-x-1/2 text-white/[0.02] text-[13vw]">
            CONTACT
        </div>
        <div class="blueprint-grid absolute inset-0 opacity-15"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl space-y-4">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-[#DFFE40]/10 border-l-2 border-[#DFFE40] text-[#DFFE40] text-[11px] font-bold uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-[#DFFE40] animate-ping"></span>
                    {{ get_content('contact', 'hero', 'badge', 'EXECUTIVE BRIEFING & TENDER INQUIRIES') }}
                </div>
                <h1 class="font-['Barlow_Condensed'] text-4xl sm:text-6xl lg:text-7xl font-black text-white uppercase tracking-tight leading-[0.95]">
                    {!! get_content('contact', 'hero', 'title', 'Initiate a <span class="text-[#DFFE40]">Confidential Briefing</span>.') !!}
                </h1>
                <p class="text-slate-300 text-sm sm:text-base font-light leading-relaxed">
                    {{ get_content('contact', 'hero', 'subtitle', 'Engage our technical partners and senior structural consultants for feasibility assessments, parametric audits, or comprehensive turnkey construction tenders.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Form & Headquarters Grid -->
    <section class="py-24 bg-[#080d1a] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Left: Consultation Form (7 cols) -->
                <div class="lg:col-span-7">
                    <div class="bg-[#0a101d] p-8 sm:p-10 border border-white/10 relative shadow-2xl">
                        <div class="wilmer-badge-sq">■</div>
                        
                        <div class="mb-8">
                            <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">TRANSMISSION PORTAL</span>
                            <h2 class="font-['Barlow_Condensed'] text-3xl font-black uppercase text-white tracking-wide mt-1">
                                Project Enquiry & Briefing
                            </h2>
                            <p class="text-xs text-slate-400 mt-1 font-light">
                                Please provide preliminary project parameters. Our engineering directorate responds within 24 business hours.
                            </p>
                        </div>

                        @if(session('success'))
                            <div class="mb-6 p-4 bg-emerald-500/10 border-l-4 border-emerald-500 text-emerald-400 text-xs font-semibold flex items-center gap-2">
                                <i class="ri-checkbox-circle-fill text-lg"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Principal Name <span class="text-[#DFFE40]">*</span>
                                    </label>
                                    <input type="text" name="name" required value="{{ old('name') }}"
                                           placeholder="e.g. Eleanor Vance" 
                                           class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">
                                    @error('name') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Corporate Email <span class="text-[#DFFE40]">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                           placeholder="e.g. e.vance@development.com" 
                                           class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">
                                    @error('email') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Direct Phone <span class="text-[#DFFE40]">*</span>
                                    </label>
                                    <input type="text" name="phone" required value="{{ old('phone') }}"
                                           placeholder="+1 (555) 000-0000" 
                                           class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">
                                    @error('phone') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Service Discipline
                                    </label>
                                    <select name="service_id" class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs focus:outline-none focus:border-[#DFFE40]">
                                        <option value="">Select Engineering Scope...</option>
                                        @if(isset($services))
                                            @foreach($services as $srv)
                                                <option value="{{ $srv->id }}" {{ (string)$srv->id === (string)old('service_id', $selectedServiceId ?? '') ? 'selected' : '' }}>
                                                    {{ $srv->title }}
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                    Project Scope & Subject <span class="text-[#DFFE40]">*</span>
                                </label>
                                <input type="text" name="subject" required value="{{ old('subject') }}"
                                       placeholder="e.g. Commercial High-Rise Structural Audit" 
                                       class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">
                                @error('subject') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-[11px] font-mono font-bold uppercase tracking-wider text-slate-300 mb-2">
                                    Project Overview / Specifications <span class="text-[#DFFE40]">*</span>
                                </label>
                                <textarea name="message" required rows="5" 
                                          placeholder="Detail project location, site dimensions, target completion timeline, and structural requirements..." 
                                          class="w-full px-4 py-3.5 bg-[#070c18] border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-[#DFFE40]">{{ old('message') }}</textarea>
                                @error('message') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-4 bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-black font-['Barlow_Condensed'] font-black text-base uppercase tracking-widest transition-all duration-300 shadow-xl shadow-[#DFFE40]/20 flex items-center justify-center gap-2">
                                <span>Transmit Project Dossier</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Headquarters & Global Contacts (5 cols) -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Headquarters Card -->
                    <div class="bg-[#0a101d] p-8 border border-white/10 relative space-y-6">
                        <div class="wilmer-badge-sq">■</div>
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-[#DFFE40]/10 border border-[#DFFE40]/30 text-[#DFFE40] flex items-center justify-center text-2xl">
                                <i class="ri-building-line"></i>
                            </div>
                            <div>
                                <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">CENTRAL OFFICE</span>
                                <h3 class="font-['Barlow_Condensed'] text-2xl font-black uppercase text-white tracking-wide">Global Headquarters</h3>
                            </div>
                        </div>

                        <div class="space-y-4 text-xs text-slate-300 pt-2">
                            <div class="flex items-start gap-3">
                                <i class="ri-map-pin-line text-[#DFFE40] text-base shrink-0 mt-0.5"></i>
                                <span>{{ get_setting('company_address', '742 Evergreen Terrace, Sector 4, Architectural District, CA 90210') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-phone-line text-[#DFFE40] text-base shrink-0"></i>
                                <span class="font-mono font-bold text-white">{{ get_setting('company_phone', '+1 (800) 456-7890') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-mail-line text-[#DFFE40] text-base shrink-0"></i>
                                <span>{{ get_setting('company_email', 'inquiries@apex-engineering.com') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Operating Hours -->
                    <div class="bg-[#0a101d] p-8 border border-white/10 relative space-y-4">
                        <div class="wilmer-badge-sq">■</div>
                        <span class="text-[10px] font-mono text-[#DFFE40] uppercase tracking-widest block font-bold">TIMING & ACCESS</span>
                        <h4 class="font-['Barlow_Condensed'] text-xl font-bold uppercase text-white tracking-wide">
                            Technical Desk Hours
                        </h4>
                        <div class="space-y-2.5 text-xs pt-1">
                            <div class="flex justify-between py-1.5 border-b border-white/5 font-mono">
                                <span class="text-slate-400 uppercase">Monday - Friday</span>
                                <span class="text-white font-bold">08:00 - 18:00 EST</span>
                            </div>
                            <div class="flex justify-between py-1.5 border-b border-white/5 font-mono">
                                <span class="text-slate-400 uppercase">Saturday</span>
                                <span class="text-white font-bold">09:00 - 14:00 EST</span>
                            </div>
                            <div class="flex justify-between py-1.5 font-mono">
                                <span class="text-slate-400 uppercase">Site Superintendent</span>
                                <span class="text-emerald-400 font-bold">24/7 On-Call Support</span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Hotline Callout -->
                    <div class="bg-gradient-to-br from-[#DFFE40] to-[#d4430c] p-8 text-white relative shadow-xl shadow-[#DFFE40]/20">
                        <span class="text-[10px] font-mono uppercase tracking-widest font-bold opacity-80 block">URGENT TENDER DISCUSSIONS</span>
                        <h4 class="font-['Barlow_Condensed'] text-2xl font-black uppercase tracking-wide mt-1">
                            Speak with Lead Engineer
                        </h4>
                        <p class="text-xs text-white/90 mt-2 font-light">
                            Direct line to our senior structural engineering and technical tender consortium.
                        </p>
                        <a href="tel:{{ get_setting('company_phone', '+18004567890') }}" class="mt-4 inline-flex items-center gap-2 px-5 py-2.5 bg-black text-white font-['Barlow_Condensed'] font-black text-xs uppercase tracking-widest hover:bg-[#0a101d] transition-colors">
                            <i class="ri-phone-fill text-[#DFFE40]"></i>
                            <span>Call {{ get_setting('company_phone', '+1 (800) 456-7890') }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
