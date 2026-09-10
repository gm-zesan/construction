@extends('themes.default.layouts.app')

@section('content')
    <!-- 1. Hero Section -->
    <section id="contact-hero"
        class="relative pt-32 pb-16 lg:pt-40 lg:pb-24 bg-[#080c14] text-white overflow-hidden border-b border-white/10">

        <!-- Background Image Grid / Gradient Overlay -->
        <div class="absolute inset-0 z-0 pointer-events-none overflow-hidden">
            <img src="{{ get_content_image('contact', 'hero', 'bg_image', asset('images/hero-bg.jpg')) }}" alt="Construction Site"
                class="absolute inset-0 w-full h-full object-cover object-center opacity-30 scale-105" />
            <div class="absolute inset-0 bg-gradient-to-r from-[#080c14] via-[#080c14]/90 to-[#080c14]/70"></div>
            <div
                class="absolute inset-0 bg-[linear-gradient(to_right,#ffffff08_1px,transparent_1px),linear-gradient(to_bottom,#ffffff08_1px,transparent_1px)] bg-[size:4rem_4rem]">
            </div>
        </div>

        <div class="container-fluid relative z-10 max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="max-w-3xl">
                <!-- Eyebrow Badge -->
                <div class="contact-hero-fade inline-flex items-center gap-2 px-3 py-1 rounded-xs bg-[#f95716]/15 border border-[#f95716]/30 text-[#f95716] text-xs font-bold uppercase tracking-wider mb-4">
                    {{ get_content('contact', 'hero', 'badge', 'CONTACT & CONSULTATION') }}
                </div>

                <!-- Main Headline -->
                <h1 class="contact-hero-fade font-heading font-black text-3xl sm:text-4xl md:text-5xl lg:text-6xl uppercase tracking-tight text-white leading-[1.08] mb-5">
                    {{ get_content('contact', 'hero', 'headline', "Let's Build Something Great Together") }}
                </h1>

                <!-- Subtitle -->
                <p class="contact-hero-fade text-slate-300 text-base sm:text-lg font-normal leading-relaxed m-0">
                    {{ get_content('contact', 'hero', 'subheadline', 'Whether you have an upcoming commercial build, need structural engineering consultation, or want an accurate project estimate, our team is ready to discuss your plans.') }}
                </p>
            </div>

        </div>
    </section>

    <!-- 2. Main Contact Section (Light Theme: Clean Cards & Consultation Form) -->
    <section id="contact-main" class="py-16 sm:py-20 lg:py-24 bg-[#f8fafc] text-slate-900 relative">
        <div class="container-fluid max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">

                <!-- Left Column (5 cols): Contact Information Cards -->
                <div class="lg:col-span-5 space-y-5">

                    <!-- Office Location Card -->
                    <div class="contact-info-card p-6 sm:p-7 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-[#f95716]/10 text-[#f95716] flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-heading font-bold text-lg text-slate-900 uppercase tracking-tight mb-1">
                                    {{ get_content('contact', 'info', 'office_card_title', 'Our Main Office') }}
                                </h3>
                                <p class="text-slate-600 text-sm leading-relaxed mb-3">
                                    {!! nl2br(e(get_setting('office_address', "Industrial Park Suite 400\nSeattle, WA 98101"))) !!}
                                </p>
                                @if(get_setting('google_maps_url'))
                                    <a href="{{ get_setting('google_maps_url') }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-[#f95716] hover:text-[#ea4907] transition-colors">
                                        <span>{{ get_content('contact', 'info', 'office_directions_text', 'View on Google Maps') }}</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Direct Contact Details (Phone & Email) Card -->
                    <div class="contact-info-card p-6 sm:p-7 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md transition-shadow">
                        <h3 class="font-heading font-bold text-base text-slate-900 uppercase tracking-tight mb-5 pb-3 border-b border-slate-100">
                            {{ get_content('contact', 'info', 'direct_contacts_title', 'Direct Contacts') }}
                        </h3>
                        <div class="space-y-4">
                            <!-- Phone -->
                            @if(get_setting('primary_phone'))
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-xs text-slate-500 font-medium block">
                                                {{ get_content('contact', 'info', 'phone_label', 'Phone Number') }}
                                            </span>
                                            <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('primary_phone')) }}"
                                                class="text-sm font-bold text-slate-900 hover:text-[#f95716] transition-colors">
                                                {{ get_setting('primary_phone') }}
                                            </a>
                                        </div>
                                    </div>
                                    <a href="tel:{{ preg_replace('/[^0-9+]/', '', get_setting('primary_phone')) }}"
                                        class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-[#f95716] hover:text-white text-xs font-bold text-slate-700 transition-colors">
                                        {{ get_content('contact', 'info', 'phone_btn_text', 'Call') }}
                                    </a>
                                </div>
                            @endif

                            <!-- Email -->
                            @if(get_setting('primary_email'))
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-xs text-slate-500 font-medium block">
                                                {{ get_content('contact', 'info', 'email_label', 'Email Address') }}
                                            </span>
                                            <a href="mailto:{{ get_setting('primary_email') }}"
                                                class="text-sm font-bold text-slate-900 hover:text-[#f95716] transition-colors break-all">
                                                {{ get_setting('primary_email') }}
                                            </a>
                                        </div>
                                    </div>
                                    <a href="mailto:{{ get_setting('primary_email') }}"
                                        class="px-3 py-1 rounded-lg bg-slate-100 hover:bg-[#f95716] hover:text-white text-xs font-bold text-slate-700 transition-colors">
                                        {{ get_content('contact', 'info', 'email_btn_text', 'Email') }}
                                    </a>
                                </div>
                            @endif

                            <!-- WhatsApp -->
                            @if(get_setting('whatsapp_number'))
                                @php
                                    $cleanWaNumber = preg_replace('/[^0-9]/', '', get_setting('whatsapp_number'));
                                @endphp
                                <div class="flex items-center justify-between pt-1">
                                    <div class="flex items-center gap-3.5">
                                        <div class="w-10 h-10 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <span class="text-xs text-slate-500 font-medium block">
                                                {{ get_content('contact', 'info', 'whatsapp_label', 'WhatsApp') }}
                                            </span>
                                            <span class="text-sm font-bold text-slate-900">
                                                {{ get_setting('whatsapp_number') }}
                                            </span>
                                        </div>
                                    </div>
                                    <a href="https://wa.me/{{ $cleanWaNumber }}" target="_blank" rel="noopener noreferrer"
                                        class="px-3 py-1 rounded-lg bg-emerald-50 hover:bg-emerald-600 hover:text-white text-xs font-bold text-emerald-700 transition-colors">
                                        {{ get_content('contact', 'info', 'whatsapp_btn_text', 'Chat') }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Working Hours Card -->
                    <div class="contact-info-card p-6 sm:p-7 rounded-2xl bg-white border border-slate-200/90 shadow-xs hover:shadow-md transition-shadow">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-heading font-bold text-base text-slate-900 uppercase tracking-tight mb-1">
                                    {{ get_content('contact', 'info', 'hours_card_title', 'Working Hours') }}
                                </h3>
                                <p class="text-slate-700 font-semibold text-sm mb-1">
                                    {{ get_setting('office_hours', 'Mon - Fri: 08:00 AM - 06:00 PM') }}
                                </p>
                                <span class="text-xs text-slate-500">
                                    {{ get_content('contact', 'info', 'weekend_hours', 'Saturday & Sunday: Closed') }}
                                </span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column (7 cols): Contact / Consultation Form -->
                <div class="lg:col-span-7">
                    <div id="contact-form-card" class="p-8 sm:p-10 lg:p-12 rounded-3xl bg-white border border-slate-200/90 shadow-sm relative">

                        <!-- Form Header -->
                        <div class="mb-8">
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-xs bg-[#f95716]/10 text-[#f95716] text-xs font-bold uppercase tracking-wider mb-3">
                                {{ get_content('contact', 'form', 'badge', 'GET IN TOUCH') }}
                            </div>
                            <h2 class="font-heading font-black text-2xl sm:text-3xl text-slate-950 uppercase tracking-tight mb-2">
                                {{ get_content('contact', 'form', 'title', 'Send Us a Message') }}
                            </h2>
                            <p class="text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                                {{ get_content('contact', 'form', 'description', 'Please fill out the form below with your project requirements. We will review your inquiry and get back to you promptly.') }}
                            </p>
                        </div>

                        <!-- Success Alert -->
                        @if(session('success'))
                            <div class="mb-8 p-5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm flex items-start gap-3.5">
                                <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <div>
                                    <strong class="font-bold block text-emerald-900 mb-0.5">Message Sent Successfully</strong>
                                    <span>{{ session('success') }}</span>
                                </div>
                            </div>
                        @endif

                        <!-- Validation Errors Alert -->
                        @if($errors->any())
                            <div class="mb-8 p-5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-sm flex items-start gap-3.5">
                                <svg class="w-5 h-5 text-rose-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <div>
                                    <strong class="font-bold block text-rose-900 mb-1">Please correct the errors below:</strong>
                                    <ul class="list-disc list-inside space-y-1 text-xs text-rose-700">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        @endif

                        <!-- Form Submission -->
                        <form id="public-enquiry-form" method="POST" action="{{ route('contact.store') }}" class="space-y-6">
                            @csrf

                            <!-- Row 1: Full Name & Business Email -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Name -->
                                <div>
                                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'name_label', 'Your Name') }} <span class="text-[#f95716]">*</span>
                                    </label>
                                    <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                        placeholder="{{ get_content('contact', 'form', 'name_placeholder', 'e.g. John Smith') }}"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('name') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all" />
                                    @error('name')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div>
                                    <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'email_label', 'Email Address') }} <span class="text-[#f95716]">*</span>
                                    </label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                        placeholder="{{ get_content('contact', 'form', 'email_placeholder', 'e.g. john@example.com') }}"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('email') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all" />
                                    @error('email')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 2: Phone & Company Name -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Phone -->
                                <div>
                                    <label for="phone" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'phone_label', 'Phone Number') }} <span class="text-slate-400 font-normal">(Optional)</span>
                                    </label>
                                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                        placeholder="{{ get_content('contact', 'form', 'phone_placeholder', 'e.g. +1 (555) 019-2831') }}"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('phone') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all" />
                                    @error('phone')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Company -->
                                <div>
                                    <label for="company" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'company_label', 'Company Name') }} <span class="text-slate-400 font-normal">(Optional)</span>
                                    </label>
                                    <input type="text" id="company" name="company" value="{{ old('company') }}"
                                        placeholder="{{ get_content('contact', 'form', 'company_placeholder', 'e.g. Apex Developments') }}"
                                        class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('company') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all" />
                                    @error('company')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 3: Service & Project Reference Selection -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <!-- Service Select -->
                                <div>
                                    <label for="service_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'service_label', 'Interested Service') }} <span class="text-slate-400 font-normal">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <select id="service_id" name="service_id"
                                            class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('service_id') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all appearance-none cursor-pointer">
                                            <option value="" class="text-slate-400">{{ get_content('contact', 'form', 'service_placeholder', 'Select Construction Service') }}</option>
                                            @foreach($services as $service)
                                                <option value="{{ $service->id }}"
                                                    {{ (old('service_id', $selectedServiceId) == $service->id) ? 'selected' : '' }}>
                                                    {{ $service->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('service_id')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>

                                <!-- Project Reference Select -->
                                <div>
                                    <label for="project_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                        {{ get_content('contact', 'form', 'project_label', 'Project Reference') }} <span class="text-slate-400 font-normal">(Optional)</span>
                                    </label>
                                    <div class="relative">
                                        <select id="project_id" name="project_id"
                                            class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('project_id') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all appearance-none cursor-pointer">
                                            <option value="" class="text-slate-400">{{ get_content('contact', 'form', 'project_placeholder', 'Select Project Reference') }}</option>
                                            @foreach($projects as $proj)
                                                <option value="{{ $proj->id }}"
                                                    {{ (old('project_id', $selectedProjectId) == $proj->id) ? 'selected' : '' }}>
                                                    {{ $proj->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                            </svg>
                                        </div>
                                    </div>
                                    @error('project_id')
                                        <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Row 4: Subject -->
                            <div>
                                <label for="subject" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    {{ get_content('contact', 'form', 'subject_label', 'Subject') }} <span class="text-slate-400 font-normal">(Optional)</span>
                                </label>
                                <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                                    placeholder="{{ get_content('contact', 'form', 'subject_placeholder', 'e.g. Quotation request for warehouse construction') }}"
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('subject') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all" />
                                @error('subject')
                                    <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Row 5: Message -->
                            <div>
                                <label for="message" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    {{ get_content('contact', 'form', 'message_label', 'Your Message / Project Details') }} <span class="text-[#f95716]">*</span>
                                </label>
                                <textarea id="message" name="message" rows="5" required
                                    placeholder="{{ get_content('contact', 'form', 'message_placeholder', 'Tell us about your project location, approximate size, timeline, or any specific questions...') }}"
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border {{ $errors->has('message') ? 'border-rose-500' : 'border-slate-300' }} text-slate-900 placeholder:text-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-[#f95716]/20 focus:border-[#f95716] focus:bg-white transition-all resize-y">{{ old('message') }}</textarea>
                                @error('message')
                                    <span class="text-rose-600 text-xs mt-1 block">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="pt-2">
                                <button id="submit-enquiry-btn" type="submit"
                                    class="w-full sm:w-auto px-8 sm:px-10 py-4 rounded-xl bg-[#f95716] hover:bg-[#ea4907] text-white text-sm font-bold uppercase tracking-wider transition-all duration-200 shadow-md shadow-[#f95716]/25 hover:shadow-lg flex items-center justify-center gap-3 cursor-pointer group disabled:opacity-50 disabled:cursor-not-allowed">
                                    <span id="btn-text">{{ get_content('contact', 'form', 'btn_text', 'Send Message') }}</span>
                                    <svg id="btn-icon" class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                    <svg id="btn-spinner" class="w-5 h-5 animate-spin hidden text-white" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                    </svg>
                                </button>
                            </div>

                        </form>

                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- 3. Location & Google Map Section (Light Theme) -->
    <section id="contact-map-section" class="py-16 sm:py-20 lg:py-24 bg-white text-slate-900 border-t border-slate-200 relative">
        <div class="container-fluid max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 xl:px-12">

            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14">
                <div class="contact-map-fade inline-flex items-center gap-2 px-3 py-1 rounded-xs bg-[#f95716]/10 text-[#f95716] text-xs font-bold uppercase tracking-wider mb-3">
                    {{ get_content('contact', 'map', 'badge', 'OUR LOCATION') }}
                </div>
                <h2 class="contact-map-fade font-heading font-black text-3xl sm:text-4xl text-slate-950 uppercase tracking-tight mb-3">
                    {{ get_content('contact', 'map', 'headline', 'Find Us On The Map') }}
                </h2>
                <p class="contact-map-fade text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                    {{ get_content('contact', 'map', 'description', 'Visit our head office for scheduled project reviews, blueprints consultation, and material samples.') }}
                </p>
            </div>

            <!-- Map Container -->
            @php
                $mapIframeInput = get_setting('google_map_iframe') 
                    ?: get_setting('google_maps_iframe') 
                    ?: get_content('contact', 'map', 'iframe_src')
                    ?: get_content('contact', 'map', 'iframe_code');

                $iframeSrc = null;
                if (!empty($mapIframeInput)) {
                    $trimmedInput = trim($mapIframeInput);
                    if (preg_match('/<iframe.*?src=["\'](.*?)["\']/i', $trimmedInput, $matches)) {
                        $iframeSrc = $matches[1];
                    } elseif (filter_var($trimmedInput, FILTER_VALIDATE_URL) || str_starts_with($trimmedInput, 'https://') || str_starts_with($trimmedInput, '//')) {
                        $iframeSrc = $trimmedInput;
                    }
                }

                if (!$iframeSrc && get_setting('office_address')) {
                    $iframeSrc = 'https://maps.google.com/maps?q=' . urlencode(get_setting('office_address', 'Seattle, WA')) . '&t=&z=14&ie=UTF8&iwloc=&output=embed';
                }
            @endphp

            <div class="contact-map-box rounded-3xl overflow-hidden border border-slate-200 shadow-sm relative">
                @if($iframeSrc)
                    <div class="relative w-full h-[400px] sm:h-[480px] bg-slate-100">
                        <iframe
                            src="{{ $iframeSrc }}"
                            width="100%"
                            height="100%"
                            class="w-full h-full border-0"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="{{ get_setting('company_name', 'COMPANY NAME') }} Location">
                        </iframe>

                        <!-- Floating Address Card -->
                        <div class="absolute bottom-6 left-6 right-6 sm:right-auto sm:max-w-md p-5 rounded-2xl bg-white/95 border border-slate-200/90 backdrop-blur-md shadow-lg flex items-start gap-4 z-10">
                            <div class="w-10 h-10 rounded-xl bg-[#f95716] flex items-center justify-center text-white flex-shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                </svg>
                            </div>
                            <div>
                                <strong class="font-heading font-bold text-slate-900 uppercase text-sm block mb-1">
                                    {{ get_setting('company_name', 'COMPANY NAME') }}
                                </strong>
                                <p class="text-slate-600 text-xs leading-relaxed m-0 mb-2">
                                    {{ get_setting('office_address', 'Industrial Park Suite 400, Seattle, WA 98101') }}
                                </p>
                                @if(get_setting('google_maps_url'))
                                    <a href="{{ get_setting('google_maps_url') }}" target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold uppercase text-[#f95716] hover:text-[#ea4907]">
                                        <span>{{ get_content('contact', 'map', 'directions_text', 'Get Directions') }}</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-8 sm:p-12 text-center bg-slate-50">
                        <div class="w-14 h-14 rounded-2xl bg-[#f95716]/10 text-[#f95716] flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            </svg>
                        </div>
                        <h3 class="font-heading font-bold text-xl uppercase text-slate-900 mb-2">
                            {{ get_content('contact', 'info', 'office_card_title', 'Our Main Office') }}
                        </h3>
                        <p class="text-slate-600 text-sm max-w-md mx-auto leading-relaxed">
                            {{ get_setting('office_address', 'Industrial Park Suite 400, Seattle, WA 98101') }}
                        </p>
                    </div>
                @endif
            </div>

        </div>
    </section>

    <!-- 4. Frequently Asked Questions Section (Light Theme) -->
    <section id="contact-faq-section" class="py-16 sm:py-20 lg:py-24 bg-[#f8fafc] text-slate-900 border-t border-slate-200">
        <div class="container-fluid max-w-[1100px] mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Section Header -->
            <div class="text-center max-w-2xl mx-auto mb-12 sm:mb-14">
                <div class="contact-faq-fade inline-flex items-center gap-2 px-3 py-1 rounded-xs bg-[#f95716]/10 text-[#f95716] text-xs font-bold uppercase tracking-wider mb-3">
                    {{ get_content('contact', 'faq', 'badge', 'FREQUENTLY ASKED QUESTIONS') }}
                </div>
                <h2 class="contact-faq-fade font-heading font-black text-3xl sm:text-4xl text-slate-950 uppercase tracking-tight mb-3">
                    {{ get_content('contact', 'faq', 'headline', 'Common Questions About Working With Us') }}
                </h2>
                <p class="contact-faq-fade text-slate-600 text-sm sm:text-base leading-relaxed m-0">
                    {{ get_content('contact', 'faq', 'subheadline', 'Find quick answers to common questions regarding estimates, site visits, and project execution.') }}
                </p>
            </div>

            <!-- FAQ Accordion List -->
            <div class="space-y-4">
                <!-- FAQ 1 -->
                @if(get_content('contact', 'faq', 'faq_1_q'))
                    <div class="contact-faq-item rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden transition-all duration-200">
                        <button type="button" class="faq-toggle-btn w-full p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer" aria-expanded="false">
                            <span class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase">
                                {{ get_content('contact', 'faq', 'faq_1_q', 'How can I get a quotation for my construction project?') }}
                            </span>
                            <div class="faq-icon-box w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 flex-shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-panel px-6 pb-6 text-slate-600 text-sm sm:text-base leading-relaxed hidden">
                            <div class="pt-2 border-t border-slate-100">
                                {{ get_content('contact', 'faq', 'faq_1_a', 'You can send us your architectural plans, drawings, or project requirements through the contact form. Our estimating team will review your scope and provide a detailed quotation.') }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FAQ 2 -->
                @if(get_content('contact', 'faq', 'faq_2_q'))
                    <div class="contact-faq-item rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden transition-all duration-200">
                        <button type="button" class="faq-toggle-btn w-full p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer" aria-expanded="false">
                            <span class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase">
                                {{ get_content('contact', 'faq', 'faq_2_q', 'Do you provide on-site inspections and surveys?') }}
                            </span>
                            <div class="faq-icon-box w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 flex-shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-panel px-6 pb-6 text-slate-600 text-sm sm:text-base leading-relaxed hidden">
                            <div class="pt-2 border-t border-slate-100">
                                {{ get_content('contact', 'faq', 'faq_2_a', 'Yes. Our engineers and project managers conduct thorough site visits to evaluate terrain, access, and specific project conditions before finalizing contracts.') }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FAQ 3 -->
                @if(get_content('contact', 'faq', 'faq_3_q'))
                    <div class="contact-faq-item rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden transition-all duration-200">
                        <button type="button" class="faq-toggle-btn w-full p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer" aria-expanded="false">
                            <span class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase">
                                {{ get_content('contact', 'faq', 'faq_3_q', 'What types of construction projects do you handle?') }}
                            </span>
                            <div class="faq-icon-box w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 flex-shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-panel px-6 pb-6 text-slate-600 text-sm sm:text-base leading-relaxed hidden">
                            <div class="pt-2 border-t border-slate-100">
                                {{ get_content('contact', 'faq', 'faq_3_a', 'We specialize in commercial buildings, industrial facilities, civil infrastructure, residential structures, and complete renovation projects.') }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- FAQ 4 -->
                @if(get_content('contact', 'faq', 'faq_4_q'))
                    <div class="contact-faq-item rounded-2xl bg-white border border-slate-200/90 shadow-xs overflow-hidden transition-all duration-200">
                        <button type="button" class="faq-toggle-btn w-full p-6 text-left flex items-center justify-between gap-4 focus:outline-none cursor-pointer" aria-expanded="false">
                            <span class="font-heading font-bold text-base sm:text-lg text-slate-900 uppercase">
                                {{ get_content('contact', 'faq', 'faq_4_q', 'How long does it take to start a project after contract signing?') }}
                            </span>
                            <div class="faq-icon-box w-8 h-8 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 flex-shrink-0 transition-transform duration-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </button>
                        <div class="faq-answer-panel px-6 pb-6 text-slate-600 text-sm sm:text-base leading-relaxed hidden">
                            <div class="pt-2 border-t border-slate-100">
                                {{ get_content('contact', 'faq', 'faq_4_a', 'Typically, site mobilization begins within 1 to 2 weeks following final permit approvals and contract execution.') }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </section>
@endsection
