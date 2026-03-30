<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.getItem('darkMode') === 'true',
    sidebarOpen: false,
    init() {
        this.$watch('darkMode', val => {
            localStorage.setItem('darkMode', val)
            document.documentElement.classList.toggle('dark', val)
        })
        document.documentElement.classList.toggle('dark', this.darkMode)
    }
}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
    <style>
        [x-cloak] { display: none !important; }
        /* Editor container - highest priority */
        .EasyMDEContainer .editor-toolbar { 
            background-color: #1f2937 !important; 
            border-bottom: 1px solid #4b5563 !important; 
        }
        .EasyMDEContainer .editor-toolbar a, 
        .EasyMDEContainer .editor-toolbar button,
        .EasyMDEContainer .editor-toolbar > * { 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .editor-toolbar a:hover, 
        .EasyMDEContainer .editor-toolbar a.active,
        .EasyMDEContainer .editor-toolbar button:hover { 
            background-color: #fff !important; 
            color: #000 !important; 
        }
        .EasyMDEContainer .editor-toolbar i.separator { 
            border-color: #4b5563 !important; 
        }
        /* Editor area */
        .EasyMDEContainer .CodeMirror { 
            background-color: #1f2937 !important; 
            border: 1px solid #4b5563 !important; 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .CodeMirror-cursor { 
            border-color: #fff !important; 
        }
        .EasyMDEContainer .CodeMirror.CodeMirror-focused .CodeMirror-selected { 
            background: #374151 !important; 
        }
        .EasyMDEContainer .CodeMirror-selected { 
            background: #374151 !important; 
        }
        .EasyMDEContainer .CodeMirror-lines, 
        .EasyMDEContainer .CodeMirror pre { 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .CodeMirror textarea { 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .CodeMirror textarea::placeholder { 
            color: #9ca3af !important; 
        }
        /* Preview */
        .EasyMDEContainer .editor-preview { 
            background-color: #1f2937 !important; 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .editor-preview pre { 
            background-color: #111827 !important; 
            border: 1px solid #374151 !important; 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .editor-preview-full { 
            background-color: #1f2937 !important; 
            color: #e5e7eb !important; 
        }
        .EasyMDEContainer .editor-statusbar { 
            display: none !important; 
        }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900">
    <div class="flex h-screen overflow-hidden">
        <x-admin.sidebar />

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-20 bg-black/50 lg:hidden"></div>

        <div class="flex flex-col flex-1 overflow-hidden">
            <x-admin.topbar />

            <main class="flex-1 overflow-y-auto p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
    @stack('scripts')
</body>

</html>
