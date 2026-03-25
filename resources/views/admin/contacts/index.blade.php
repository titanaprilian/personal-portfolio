<x-layouts.admin title="Messages">
    <div x-data="{
        showDelete: false,
        selected: null,
        deleteContact: null,
    }">

        <div class="flex items-center gap-3 mb-6">
            <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Messages</h1>
            @if($unreadCount > 0)
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                    {{ $unreadCount }} unread
                </span>
            @else
                <span class="text-sm text-gray-400 dark:text-gray-500">All caught up ✓</span>
            @endif
        </div>

        <div class="flex gap-0 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 overflow-hidden" style="height: calc(100vh - 180px);">
            <div class="w-full md:w-80 lg:w-96 flex-shrink-0 border-r border-gray-200 dark:border-gray-700 overflow-y-auto">
                @forelse($contacts as $contact)
                    <button
                        type="button"
                        @click="
                            selected = @js([
                                'id' => $contact->id,
                                'name' => $contact->name,
                                'email' => $contact->email,
                                'message' => $contact->message,
                                'read_at' => $contact->read_at?->toIso8601String(),
                                'created_at' => $contact->created_at->toIso8601String()
                            ]);
                        "
                        :class="selected && selected.id === {{ $contact->id }} ? 'bg-indigo-50 dark:bg-indigo-900/20 border-l-2 border-l-indigo-500' : '{{ is_null($contact->read_at) ? 'bg-indigo-50/60 dark:bg-indigo-900/10' : '' }}'"
                        class="w-full text-left px-4 py-3 border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/60 transition-colors"
                    >
                        <div class="flex items-start justify-between gap-2">
                            <div class="mt-1.5 flex-shrink-0">
                                @if(is_null($contact->read_at))
                                    <div class="w-2 h-2 rounded-full bg-indigo-500"></div>
                                @else
                                    <div class="w-2 h-2 rounded-full bg-transparent"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <span class="text-sm truncate {{ is_null($contact->read_at) ? 'font-semibold text-gray-800 dark:text-gray-100' : 'font-medium text-gray-600 dark:text-gray-400' }}">
                                        {{ $contact->name }}
                                    </span>
                                    <span class="text-xs text-gray-400 dark:text-gray-500 flex-shrink-0">
                                        {{ $contact->created_at->diffForHumans(short: true) }}
                                    </span>
                                </div>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate mt-0.5">
                                    {{ $contact->email }}
                                </p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 truncate mt-1 leading-relaxed">
                                    {{ Str::limit($contact->message, 80) }}
                                </p>
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 text-center px-4">
                        <p class="text-gray-400 dark:text-gray-500 text-sm">No messages yet.</p>
                    </div>
                @endforelse

                @if($contacts->hasPages())
                    <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                        {{ $contacts->links() }}
                    </div>
                @endif
            </div>

            <div class="hidden md:flex flex-1 flex-col min-w-0">
                <template x-if="selected">
                    <div class="flex flex-col h-full">
                        <div class="p-6 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <p class="font-semibold text-gray-800 dark:text-gray-100" x-text="selected.name"></p>
                                    <a :href="`mailto:${selected.email}`" class="text-xs text-indigo-500 hover:underline" x-text="selected.email"></a>
                                </div>
                                <div class="text-right flex-shrink-0">
                                    <p class="text-xs text-gray-400 dark:text-gray-500" x-text="new Date(selected.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' })"></p>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5" x-text="new Date(selected.created_at).toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })"></p>
                                </div>
                            </div>
                        </div>

                        <div class="flex-1 overflow-y-auto p-6">
                            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed whitespace-pre-wrap" x-text="selected.message"></p>
                            </div>
                        </div>

                        <div class="p-4 border-t border-gray-100 dark:border-gray-800 flex-shrink-0">
                            <div class="flex items-center justify-between">
                                <div class="flex gap-2">
                                    <button 
                                        @click="
                                            fetch(`/admin/contacts/${selected.id}/unread`, { 
                                                method: 'POST', 
                                                body: '_method=PATCH', 
                                                headers: { 
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 
                                                    'Content-Type': 'application/x-www-form-urlencoded' 
                                                } 
                                            }).then(() => { 
                                                window.location.reload();
                                            });
                                        "
                                        x-show="selected.read_at"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                                        Mark as Unread
                                    </button>
                                    <button 
                                        @click="
                                            fetch(`/admin/contacts/${selected.id}/read`, { 
                                                method: 'POST', 
                                                body: '_method=PATCH', 
                                                headers: { 
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 
                                                    'Content-Type': 'application/x-www-form-urlencoded' 
                                                } 
                                            }).then(() => { 
                                                window.location.reload();
                                            });
                                        "
                                        x-show="!selected.read_at"
                                        class="text-xs px-3 py-1.5 rounded-lg border border-indigo-300 dark:border-indigo-700 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                        Mark as Read
                                    </button>
                                    <a :href="`mailto:${selected.email}?subject=Re: Your message`" class="text-xs px-3 py-1.5 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white transition-colors">
                                        Reply via Email
                                    </a>
                                </div>

                                <button type="button" @click="showDelete = true; deleteContact = { id: selected.id, name: selected.name }" class="text-xs px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </template>

                <template x-if="!selected">
                    <div class="flex-1 flex items-center justify-center text-center p-8">
                        <div>
                            <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 13.5h3.86a2.25 2.25 0 012.012 1.244l.256.512a2.25 2.25 0 002.013 1.244h3.218a2.25 2.25 0 002.013-1.244l.256-.512a2.25 2.25 0 012.013-1.244h3.859m-19.5.338V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18v-4.162c0-.224-.034-.447-.1-.661L19.24 5.338a2.25 2.25 0 00-2.15-1.588H6.911a2.25 2.25 0 00-2.15 1.588L2.35 13.177a2.25 2.25 0 00-.1.661z" />
                                </svg>
                            </div>
                            <p class="text-sm text-gray-400 dark:text-gray-500">
                                Select a message to read it
                            </p>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <x-admin.dialog :open="'showDelete'" title="Delete Message" :close="'showDelete = false; deleteContact = null'" max-width="max-w-md">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete the message from
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deleteContact?.name"></span>?
                This action cannot be undone.
            </p>

            <form method="POST" :action="`/admin/contacts/${deleteContact?.id}`" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deleteContact = null" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">Yes, Delete</button>
                </div>
            </form>
        </x-admin.dialog>

    </div>
</x-layouts.admin>
