@extends('themes.apex-dark.layouts.app')

@section('content')
    <!-- Contact Hero Header -->
    <section class="relative pt-36 pb-20 overflow-hidden bg-[#070a12] border-b border-white/5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-amber-500/10 border border-amber-500/30 text-amber-400 text-xs font-semibold uppercase tracking-widest mb-6">
                    <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                    {{ get_content('contact', 'hero', 'badge', 'Executive Briefing & Inquiries') }}
                </div>
                <h1 class="font-syne text-4xl sm:text-5xl lg:text-6xl font-black text-white leading-tight tracking-tight mb-6">
                    {!! get_content('contact', 'hero', 'title', 'Initiate a <span class="apex-gradient-text">Confidential Briefing</span>.') !!}
                </h1>
                <p class="text-base sm:text-lg text-slate-300 font-light leading-relaxed">
                    {{ get_content('contact', 'hero', 'subtitle', 'Engage our technical partners and senior structural consultants for feasibility assessments, parametric audits, or comprehensive turnkey construction tenders.') }}
                </p>
            </div>
        </div>
    </section>

    <!-- Main Form & Headquarters Grid -->
    <section class="py-24 bg-[#090d16] relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                <!-- Left: Consultation Form (7 cols) -->
                <div class="lg:col-span-7">
                    <div class="apex-card rounded-3xl p-8 sm:p-10 border border-white/10 shadow-2xl">
                        <h2 class="font-syne text-2xl font-bold text-white mb-2">
                            Project Enquiry & Briefing
                        </h2>
                        <p class="text-xs text-slate-400 mb-8">
                            Please provide preliminary project parameters. Our engineering directorate will respond within 24 hours.
                        </p>

                        @if(session('success'))
                            <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-xs font-semibold flex items-center gap-2">
                                <i class="ri-checkbox-circle-fill text-base"></i>
                                <span>{{ session('success') }}</span>
                            </div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Principal Name <span class="text-amber-400">*</span>
                                    </label>
                                    <input type="text" name="name" required value="{{ old('name') }}"
                                           placeholder="e.g. Eleanor Vance" 
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">
                                    @error('name') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Corporate Email <span class="text-amber-400">*</span>
                                    </label>
                                    <input type="email" name="email" required value="{{ old('email') }}"
                                           placeholder="e.g. e.vance@development.com" 
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">
                                    @error('email') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Direct Phone <span class="text-amber-400">*</span>
                                    </label>
                                    <input type="text" name="phone" required value="{{ old('phone') }}"
                                           placeholder="+1 (555) 000-0000" 
                                           class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">
                                    @error('phone') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                                </div>

                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                        Service Discipline
                                    </label>
                                    <select name="service_id" class="w-full px-4 py-3 rounded-xl bg-[#0e1424] border border-white/10 text-white text-xs focus:outline-none focus:border-amber-400/50">
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
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                    Project Scope & Subject <span class="text-amber-400">*</span>
                                </label>
                                <input type="text" name="subject" required value="{{ old('subject') }}"
                                       placeholder="e.g. Commercial High-Rise Structural Audit" 
                                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">
                                @error('subject') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-300 mb-2">
                                    Project Overview / Specifications <span class="text-amber-400">*</span>
                                </label>
                                <textarea name="message" required rows="5" 
                                          placeholder="Detail project location, site dimensions, target completion timeline, and structural requirements..." 
                                          class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white text-xs placeholder:text-slate-500 focus:outline-none focus:border-amber-400/50">{{ old('message') }}</textarea>
                                @error('message') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                            </div>

                            <button type="submit" class="w-full py-4 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 text-slate-950 font-syne font-bold text-sm uppercase tracking-wider hover:from-amber-300 hover:to-amber-400 shadow-xl shadow-amber-500/20 transition-all duration-300 flex items-center justify-center gap-2">
                                <span>Transmit Project Dossier</span>
                                <i class="ri-arrow-right-line"></i>
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Right: Headquarters & Global Contacts (5 cols) -->
                <div class="lg:col-span-5 space-y-8">
                    <!-- Headquarters Card -->
                    <div class="apex-card rounded-3xl p-8 border border-white/10 space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-amber-400/10 text-amber-400 flex items-center justify-center text-lg">
                                <i class="ri-building-line"></i>
                            </div>
                            <div>
                                <h3 class="font-syne text-lg font-bold text-white">Global Headquarters</h3>
                                <span class="text-xs text-slate-400">Engineering Design Center</span>
                            </div>
                        </div>

                        <div class="space-y-4 text-xs text-slate-300">
                            <div class="flex items-start gap-3">
                                <i class="ri-map-pin-line text-amber-400 text-base shrink-0 mt-0.5"></i>
                                <span>{{ get_setting('company_address', '742 Evergreen Terrace, Sector 4, Architectural District, CA 90210') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-phone-line text-amber-400 text-base shrink-0"></i>
                                <span>{{ get_setting('company_phone', '+1 (800) 456-7890') }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <i class="ri-mail-line text-amber-400 text-base shrink-0"></i>
                                <span>{{ get_setting('company_email', 'inquiries@apex-engineering.com') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Operating Hours -->
                    <div class="apex-card rounded-3xl p-8 border border-white/10 space-y-4">
                        <h4 class="font-syne text-sm font-bold uppercase tracking-widest text-amber-400">
                            Technical Desk Hours
                        </h4>
                        <div class="space-y-2 text-xs">
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-slate-400">Monday - Friday</span>
                                <span class="text-white font-medium">08:00 - 18:00 EST</span>
                            </div>
                            <div class="flex justify-between py-1 border-b border-white/5">
                                <span class="text-slate-400">Saturday</span>
                                <span class="text-white font-medium">09:00 - 14:00 EST</span>
                            </div>
                            <div class="flex justify-between py-1">
                                <span class="text-slate-400">Site Superintendent Emergency</span>
                                <span class="text-emerald-400 font-bold">24/7 On-Call</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
