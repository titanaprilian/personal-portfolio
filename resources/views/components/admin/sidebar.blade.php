<aside
    class="fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-white border-r border-gray-200 dark:bg-gray-900 dark:border-gray-700 lg:static lg:translate-x-0 transition-transform duration-300"
    :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
>
    <x-admin.sidebar-header />
    <x-admin.sidebar-nav />
    <x-admin.sidebar-footer />
</aside>
