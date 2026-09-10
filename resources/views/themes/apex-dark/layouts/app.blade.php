<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ get_content('seo', 'meta', 'meta_description', 'Apex Architectural & Structural Engineering — Pioneering modern infrastructure with precision.') }}">
    <meta name="theme-color" content="#070a12">

    @if(!empty(get_setting('site_favicon')))
        <link rel="icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')) }}">
    @endif

    <title>{{ $title ?? (get_content('seo', 'meta', 'meta_title', get_setting('company_name', 'COMPANY NAME') . ' — Apex Architectural & Construction')) }}</title>

    <!-- Google Fonts: Syne & Outfit & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Syne:wght@600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-outfit { font-family: 'Outfit', sans-serif; }
        .apex-gradient-text {
            background: linear-gradient(135deg, #ffffff 0%, #fbbf24 50%, #f59e0b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .apex-glass {
            background: rgba(15, 23, 42, 0.75);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(251, 191, 36, 0.12);
        }
        .apex-card {
            background: linear-gradient(180deg, rgba(20, 29, 47, 0.85) 0%, rgba(10, 15, 29, 0.95) 100%);
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .apex-card:hover {
            border-color: rgba(245, 158, 11, 0.35);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(245, 158, 11, 0.12);
        }
    </style>
</head>
<body class="bg-[#070a12] text-slate-200 font-outfit antialiased selection:bg-[#f59e0b] selection:text-slate-900 min-h-screen flex flex-col relative overflow-x-hidden">
    <!-- Subtle Blueprint Grid Background -->
    <div class="fixed inset-0 pointer-events-none opacity-[0.03] z-0" 
         style="background-image: linear-gradient(#fbbf24 1px, transparent 1px), linear-gradient(90deg, #fbbf24 1px, transparent 1px); background-size: 40px 40px;"></div>

    <!-- Navigation Header -->
    @include('themes.apex-dark.partials.header')

    <!-- Main Content -->
    <main id="main-content" class="flex-grow w-full relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('themes.apex-dark.partials.footer')

    <!-- Scroll to Top Indicator -->
    <button id="scroll-progress-btn" type="button" class="fixed bottom-6 right-6 z-40 w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-[#f59e0b] hover:bg-[#d97706] text-slate-950 font-black text-[11px] sm:text-xs flex items-center justify-center shadow-2xl transition-all duration-300 opacity-0 pointer-events-none focus:outline-none cursor-pointer group" aria-label="Scroll to top of page">
        <span id="scroll-percentage-text" class="group-hover:hidden">0%</span>
        <svg class="w-4 h-4 hidden group-hover:block transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>
