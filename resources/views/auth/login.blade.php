<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Login</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css/figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --color-neon: #00ffe0;
            --color-surface: #111827;
            --color-text: #f9fafb;
            --color-muted: #9ca3af;
            --color-border: #374151;
        }
    </style>
</head>
<body class="bg-gray-900 dark:bg-gray-900">
    <div class="min-h-screen flex">
        <div class="hidden lg:flex lg:w-1/2 bg-gray-800 dark:bg-gray-800 flex-col justify-center items-center p-12 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-[#00ffe0]/10 to-cyan-500/10"></div>
            <div class="relative z-10 text-center">
                <h1 class="text-5xl font-bold text-white mb-4">{{ config('app.name', 'Portfolio') }}</h1>
                <p class="text-xl text-gray-400">Welcome back</p>
                <div class="mt-12 w-24 h-1 mx-auto rounded-full" style="background-color: #00ffe0;"></div>
            </div>
        </div>

        <div class="w-full lg:w-1/2 flex items-center justify-center p-8">
            <div class="w-full max-w-md">
                <div class="text-center lg:hidden mb-8">
                    <h1 class="text-3xl font-bold text-white">{{ config('app.name', 'Portfolio') }}</h1>
                </div>

                <h2 class="text-2xl font-semibold text-white mb-2">Sign in to your account</h2>
                <p class="text-gray-400 mb-8">Enter your credentials to access the admin panel</p>

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg text-sm" style="background-color: rgba(0, 255, 224, 0.1); border: 1px solid rgba(0, 255, 224, 0.2); color: #00ffe0;">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-300 mb-1">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#00ffe0] focus:border-transparent">
                        @error('email')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-300 mb-1">Password</label>
                        <input id="password" type="password" name="password" required autocomplete="current-password"
                            class="w-full px-4 py-2 bg-gray-800 border border-gray-700 rounded-lg text-white focus:outline-none focus:ring-2 focus:ring-[#00ffe0] focus:border-transparent">
                        @error('password')
                            <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="rounded bg-gray-800 border-gray-700 text-[#00ffe0] focus:ring-[#00ffe0] focus:ring-offset-gray-900">
                            <span class="ml-2 text-sm text-gray-400">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#00ffe0] hover:text-[#00ccb8]">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    <button type="submit"
                        class="w-full py-3 px-4 text-white font-medium rounded-lg transition-colors hover:opacity-90"
                        style="background-color: #00ffe0; color: #111827 !important;">
                        Sign in
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
