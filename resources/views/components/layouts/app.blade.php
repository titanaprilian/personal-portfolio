<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ $title ?? config('app.name') }}</title>

    <script>
        (function() {
            const stored = localStorage.getItem('darkMode');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const isDark = stored === 'true' || (stored === null && prefersDark);
            if (isDark) document.documentElement.classList.add('dark');
            if (window.Alpine) {
                Alpine.store('darkMode', {
                    on: isDark,
                    init() { document.documentElement.classList.toggle('dark', this.on); }
                });
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        :root {
            --color-bg: #ffffff;
            --color-surface: #f8fafc;
            --color-border: #e2e8f0;
            --color-neon: #6366f1;
            --color-neon-dim: rgba(99,102,241,0.1);
            --color-text: #0f172a;
            --color-muted: #64748b;
        }
        .dark {
            --color-bg: #0a0a0f;
            --color-surface: #111118;
            --color-border: #1e1e2e;
            --color-neon: #00ffe0;
            --color-neon-dim: rgba(0,255,224,0.08);
            --color-text: #e2e8f0;
            --color-muted: #64748b;
        }
        body {
            background-color: var(--color-bg);
            color: var(--color-text);
            font-family: 'DM Sans', sans-serif;
        }
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(99,102,241,0.03) 2px,
                rgba(99,102,241,0.03) 4px
            );
            pointer-events: none;
            z-index: 0;
        }
        .dark body::before {
            background-image: repeating-linear-gradient(
                0deg,
                transparent,
                transparent 2px,
                rgba(0,255,224,0.012) 2px,
                rgba(0,255,224,0.012) 4px
            );
        }
        h1, h2, h3, h4, h5, h6, .font-display {
            font-family: 'Space Mono', monospace;
        }
        @keyframes fadeSlideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body class="min-h-screen flex flex-col antialiased relative">
    <div class="relative z-0">
        <x-public.header />

        <main class="relative z-10 flex-1">
            {{ $slot }}
        </main>

        <x-public.footer />
    </div>
</body>
</html>
