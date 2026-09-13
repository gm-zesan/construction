<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ get_content('seo', 'meta', 'meta_description', 'Apex Architectural & Structural Engineering — Pioneering modern infrastructure with precision.') }}">
    <meta name="theme-color" content="#080e1a">

    @if(!empty(get_setting('site_favicon')))
        <link rel="icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')) }}">
    @endif

    <title>{{ $title ?? (get_content('seo', 'meta', 'meta_title', get_setting('company_name', 'COMPANY NAME') . ' — Apex Architectural & Construction')) }}</title>

    <!-- Google Fonts: Barlow Condensed & Syne & Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:ital,wght@0,600;0,700;0,800;0,900;1,700;1,800&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Syne:wght@600;700;800;900&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            /* ==========================================================================
               THEME COLOR PALETTE (EDIT HERE TO CHANGE COLORS EASILY FOR APEX THEME)
               ========================================================================== */
            --theme-primary: #DFFE40;             /* Primary Accent Color (Electric Lime / Cyber Yellow) */
            --theme-primary-hover: #cbe838;       /* Primary Accent Hover */
            --theme-primary-light: #f6ffd1;       /* Light Accent Tint */
            --theme-primary-rgb: 223, 254, 64;    /* RGB Values for rgba() transparency */

            /* Dark Palette */
            --theme-navy-dark: #080e1a;           /* Deep Body Background */
            --theme-navy-surface: #0e172a;        /* Card & Section Surface */
            --theme-navy-card: #131f38;           /* Highlight Card Surface */
            --theme-heading-navy: #0b163f;        /* Dark Navy Headline Color */

            /* Backwards-compatible aliases */
            --wilmer-orange: var(--theme-primary);
            --wilmer-orange-hover: var(--theme-primary-hover);
            --wilmer-navy-dark: var(--theme-navy-dark);
            --wilmer-navy-surface: var(--theme-navy-surface);
            --wilmer-navy-card: var(--theme-navy-card);
        }

        .font-barlow { font-family: 'Barlow Condensed', sans-serif; }
        .font-syne { font-family: 'Syne', sans-serif; }
        .font-sans { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono { font-family: 'JetBrains Mono', monospace; }

        /* Giant Architectural Ghost Watermark */
        .wilmer-watermark {
            font-family: 'Barlow Condensed', sans-serif;
            font-size: clamp(4rem, 11vw, 9.5rem);
            font-weight: 900;
            line-height: 0.85;
            letter-spacing: 0.08em;
            color: transparent;
            -webkit-text-stroke: 1.5px rgba(255, 255, 255, 0.05);
            text-transform: uppercase;
            user-select: none;
            pointer-events: none;
            position: absolute;
            top: -1.5rem;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            z-index: 0;
        }

        .wilmer-watermark-left {
            left: 0;
            transform: none;
        }

        .apex-gradient-text {
            background: linear-gradient(135deg, #ffffff 10%, var(--theme-primary) 90%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .wilmer-card {
            background: var(--theme-navy-surface);
            border: 1px solid rgba(255, 255, 255, 0.07);
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
            position: relative;
        }

        .wilmer-card:hover {
            border-color: rgba(var(--theme-primary-rgb), 0.4);
            transform: translateY(-4px);
            box-shadow: 0 20px 40px -15px rgba(var(--theme-primary-rgb), 0.15);
        }

        .wilmer-badge-sq {
            position: absolute;
            top: 1rem;
            right: 1rem;
            width: 1.5rem;
            height: 1.5rem;
            background: var(--theme-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #080e1a;
            font-size: 0.75rem;
            font-weight: 800;
            z-index: 10;
        }

        /* Blueprint Grid Line Background */
        .blueprint-grid {
            background-image: 
                linear-gradient(rgba(var(--theme-primary-rgb), 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(var(--theme-primary-rgb), 0.04) 1px, transparent 1px);
            background-size: 48px 48px;
        }
    </style>
</head>
<body class="bg-[#080e1a] text-slate-200 font-sans antialiased selection:bg-[#DFFE40] selection:text-slate-950 min-h-screen flex flex-col relative overflow-x-hidden blueprint-grid">
    <!-- Navigation Header -->
    @include('themes.apex-dark.partials.header')

    <!-- Main Content -->
    <main id="main-content" class="flex-grow w-full relative z-10">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('themes.apex-dark.partials.footer')

    <!-- Scroll to Top Indicator -->
    <button id="scroll-progress-btn" type="button" class="fixed bottom-6 right-6 z-40 w-11 h-11 sm:w-12 sm:h-12 rounded-none bg-[#DFFE40] hover:bg-[#cbe838] text-slate-950 font-barlow font-black text-xs flex items-center justify-center shadow-2xl transition-all duration-300 opacity-0 pointer-events-none focus:outline-none cursor-pointer group" aria-label="Scroll to top of page">
        <span id="scroll-percentage-text" class="group-hover:hidden">0%</span>
        <svg class="w-4 h-4 hidden group-hover:block transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"/>
        </svg>
    </button>

    @stack('scripts')
</body>
</html>
