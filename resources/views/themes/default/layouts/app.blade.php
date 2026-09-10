<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ get_content('seo', 'meta', 'meta_description', 'Construction, from planning to completion. Projects delivered with careful planning, clear coordination and attention to detail.') }}">
    <meta name="theme-color" content="#0b0f17">

    @if(get_setting('site_favicon'))
        <link rel="icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')) }}">
    @endif

    <title>{{ $title ?? (get_content('seo', 'meta', 'meta_title', get_setting('company_name', 'COMPANY NAME') . ' — Construction & Development')) }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700;800&family=Caveat:wght@600;700&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0b0f17] text-slate-100 font-sans antialiased selection:bg-[#f95716] selection:text-white min-h-screen flex flex-col">
    <!-- Accessibility Skip Link -->
    <a href="#hero-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 focus:z-50 focus:bg-[#f95716] focus:text-white focus:px-4 focus:py-2 focus:font-semibold">
        Skip to main content
    </a>

    <!-- Navigation Header -->
    @include('themes.default.partials.header')

    <!-- Main Content -->
    <main id="main-content" class="flex-grow w-full overflow-x-clip">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('themes.default.partials.footer')

    <!-- Floating Page Scroll Percentage Indicator & Back to Top -->
    <button id="scroll-progress-btn" type="button" class="fixed bottom-6 right-6 z-40 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#f95716] hover:bg-[#ea4907] text-white font-black text-[11px] sm:text-xs flex items-center justify-center shadow-2xl transition-colors duration-300 opacity-0 pointer-events-none focus:outline-none cursor-pointer group" aria-label="Scroll to top of page">
        <span id="scroll-percentage-text" class="group-hover:hidden">0%</span>
        <svg class="w-4 h-4 hidden group-hover:block transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>
