<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found | {{ get_setting('company_name', 'Construction') }}</title>
    
    @if(!empty(get_setting('site_favicon')))
        <link rel="icon" type="image/x-icon" href="{{ asset(get_setting('site_favicon')) }}">
    @endif

    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
        }

        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #0b132b 0%, #1c2541 50%, #0b132b 100%);
            color: #ffffff;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }

        /* Ambient Glow & Grid */
        .ambient-glow {
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(249, 87, 22, 0.15) 0%, rgba(249, 87, 22, 0) 70%);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            pointer-events: none;
        }

        .grid-pattern {
            position: absolute;
            inset: 0;
            background-image: linear-gradient(rgba(255, 255, 255, 0.03) 1px, transparent 1px),
                              linear-gradient(90deg, rgba(255, 255, 255, 0.03) 1px, transparent 1px);
            background-size: 32px 32px;
            pointer-events: none;
            z-index: 0;
        }

        .error-card {
            position: relative;
            z-index: 10;
            max-width: 620px;
            width: 100%;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-radius: 24px;
            padding: 48px 36px;
            text-align: center;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }

        .error-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 9999px;
            background: rgba(249, 87, 22, 0.12);
            border: 1px solid rgba(249, 87, 22, 0.3);
            color: #f95716;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 24px;
        }

        .error-code {
            font-size: 88px;
            font-weight: 900;
            line-height: 1;
            letter-spacing: -0.04em;
            background: linear-gradient(135deg, #ffffff 0%, #cbd5e1 50%, #94a3b8 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 16px;
        }

        .error-title {
            font-size: 20px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 14px;
            line-height: 1.4;
        }

        .error-description {
            font-size: 15px;
            color: #94a3b8;
            line-height: 1.6;
            margin-bottom: 32px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .theme-alert-box {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 28px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-align: left;
            color: #fca5a5;
            font-size: 13.5px;
        }

        .theme-alert-box i {
            font-size: 22px;
            color: #f87171;
            flex-shrink: 0;
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-primary-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 26px;
            background: linear-gradient(135deg, #f95716 0%, #ea580c 100%);
            color: #ffffff;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 4px 14px rgba(249, 87, 22, 0.35);
            transition: all 0.2s ease;
        }

        .btn-primary-action:hover {
            background: linear-gradient(135deg, #ea580c 0%, #c2410c 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(249, 87, 22, 0.45);
        }

        .btn-secondary-action {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 22px;
            background: rgba(255, 255, 255, 0.08);
            color: #e2e8f0;
            text-decoration: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.2s ease;
        }

        .btn-secondary-action:hover {
            background: rgba(255, 255, 255, 0.14);
            color: #ffffff;
            transform: translateY(-2px);
        }

        @media (max-width: 640px) {
            .error-card {
                padding: 32px 20px;
            }
            .error-code {
                font-size: 64px;
            }
            .error-title {
                font-size: 18px;
            }
            .action-group {
                flex-direction: column;
                width: 100%;
            }
            .btn-primary-action, .btn-secondary-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="ambient-glow"></div>
    <div class="grid-pattern"></div>

    <div class="error-card">
        <div class="error-badge">
            <i class="ri-error-warning-line"></i>
            Theme Error / Page Not Found
        </div>

        <div class="error-code">404</div>

        @php
            $customMessage = isset($exception) && $exception->getMessage() ? $exception->getMessage() : '404 currently active theme is not available on you directory.';
        @endphp

        <h1 class="error-title">
            {{ $customMessage }}
        </h1>

        <div class="theme-alert-box">
            <i class="ri-folder-unknow-line"></i>
            <div>
                <strong>Active Theme:</strong> <code>{{ get_active_theme() }}</code><br>
                <span>The requested template file is not present in the active theme directory.</span>
            </div>
        </div>

        <p class="error-description">
            Please make sure the corresponding Blade template file exists in <code>resources/views/themes/{{ get_active_theme() }}/</code> or select an available theme from the admin panel.
        </p>

        <div class="action-group">
            <a href="{{ url('/') }}" class="btn-primary-action">
                <i class="ri-home-4-line"></i> Go to Homepage
            </a>
            @auth
                <a href="{{ route('themes.index') }}" class="btn-secondary-action">
                    <i class="ri-palette-line"></i> Theme Settings
                </a>
                <a href="{{ route('dashboard') }}" class="btn-secondary-action">
                    <i class="ri-dashboard-line"></i> Dashboard
                </a>
            @endauth
        </div>
    </div>
</body>
</html>
