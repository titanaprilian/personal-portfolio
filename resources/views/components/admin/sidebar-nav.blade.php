@php
$unreadCount = \App\Models\Contact::whereNull('read_at')->count();
@endphp

<div class="flex-1 overflow-y-auto py-4">
    <a
        href="{{ route('admin.dashboard') }}"
        class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 mb-4 transition-colors {{ request()->url() === route('admin.dashboard') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
    >
        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
        </svg>
        Dashboard
    </a>

    <div x-data="{ open: true }">
        <button
            @click="open = !open"
            class="flex w-full items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        >
            <span>Menu</span>
            <svg
                :class="open ? 'rotate-180' : ''"
                class="h-4 w-4 transition-transform"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-1 space-y-1">
            <a
                href="{{ route('admin.projects.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.projects.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                Projects
            </a>

            <a
                href="{{ route('admin.blog.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.blog.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Blog Posts
            </a>

            <a
                href="{{ route('admin.skills.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.skills.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
                Skills
            </a>

            <a
                href="{{ route('admin.skills-categories.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.skills-categories.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                </svg>
                Skill Categories
            </a>

            <a
                href="{{ route('admin.experiences.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.experiences.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Experience
            </a>

            <a
                href="{{ route('admin.contacts.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.contacts.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                Messages
                @if($unreadCount > 0)
                    <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                        {{ $unreadCount }}
                    </span>
                @endif
            </a>

            <a
                href="{{ route('admin.resume.index') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('admin.resume.index') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                </svg>
                Resume
            </a>
        </div>
    </div>

    <div x-data="{ open: true }" class="mt-4">
        <button
            @click="open = !open"
            class="flex w-full items-center justify-between px-4 py-2 text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200"
        >
            <span>Settings</span>
            <svg
                :class="open ? 'rotate-180' : ''"
                class="h-4 w-4 transition-transform"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" x-transition class="mt-1 space-y-1">
            <a
                href="{{ route('profile.edit') }}"
                class="flex items-center gap-3 px-4 py-2 text-sm rounded-lg mx-2 transition-colors {{ request()->url() === route('profile.edit') ? 'bg-indigo-50 text-indigo-600 font-medium dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800' }}"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </a>
        </div>
    </div>
</div>
