<x-layouts.admin title="Work Experience">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editExperience: null,
        deleteExperience: null,
        submittingCreate: false,
        submittingEdit: false,
        submittingDelete: false,
    }">

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Work Experience</h1>
            <button
                @click="showCreate = true"
                class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg transition-colors"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Experience
            </button>
        </div>

        @if(session('success'))
            <div
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-400"
            >
                {{ session('success') }}
            </div>
        @endif

        <div class="relative">
            <div class="absolute left-5 top-0 bottom-0 w-px bg-gray-200 dark:bg-gray-700"></div>

            <div class="space-y-6">
                @if($experiences->count() > 0)
                    @foreach($experiences as $experience)
                        @php
                            $domain = Str::slug($experience->company) . '.com';
                            $logoUrl = "https://www.google.com/s2/favicons?domain={$domain}&sz=64";
                            $editData = $experience->toArray();
                            $editData['start_date'] = $experience->start_date->format('Y-m-d');
                            $editData['end_date'] = $experience->end_date?->format('Y-m-d');
                        @endphp

                        <div class="relative flex gap-4 items-start">
                            <div class="relative z-10 flex-shrink-0">
                                <div x-data="{ logoFailed: false }" class="w-10 h-10 rounded-lg ring-2 ring-white dark:ring-gray-900 overflow-hidden">
                                    <img x-show="!logoFailed" src="{{ $logoUrl }}" alt="{{ $experience->company }}" x-on:error="logoFailed = true" class="w-full h-full object-contain bg-white p-1" />
                                    <div x-show="logoFailed" class="w-full h-full bg-indigo-100 dark:bg-indigo-900/40 flex items-center justify-center">
                                        <span class="text-indigo-600 dark:text-indigo-400 font-bold text-sm">{{ strtoupper(substr($experience->company, 0, 1)) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 min-w-0 rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 p-4 shadow-sm">
                                <div class="flex flex-wrap items-start justify-between gap-2">
                                    <div>
                                        <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $experience->role }}</h3>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $experience->company }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($experience->is_current)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400">Current</span>
                                        @endif
                                        <button @click="showEdit = true; editExperience = @js($editData)" class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline">Edit</button>
                                        <button @click="showDelete = true; deleteExperience = @js($experience->only(['id', 'role', 'company']))" class="text-xs text-red-500 hover:underline">Delete</button>
                                    </div>
                                </div>

                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                    {{ $experience->start_date->format('M Y') }}
                                    —
                                    {{ $experience->is_current ? 'Present' : ($experience->end_date?->format('M Y') ?? '—') }}
                                    @php
                                        $end = $experience->is_current ? now() : $experience->end_date;
                                        $duration = $experience->start_date->diffForHumans($end, ['parts' => 2, 'join' => ', ', 'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE]);
                                    @endphp
                                    <span class="ml-1 text-gray-300 dark:text-gray-600">·</span>
                                    <span class="ml-1">{{ $duration }}</span>
                                </p>

                                @if($experience->description)
                                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $experience->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="py-16 text-center text-gray-400 dark:text-gray-500">
                        <p class="text-sm">No experience entries yet.</p>
                        <button @click="showCreate = true" class="mt-3 text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Add your first experience →</button>
                    </div>
                @endif
            </div>
        </div>

        <x-admin.dialog :open="'showCreate'" title="Add Experience" :close="'showCreate = false'" max-width="max-w-lg">
            <form method="POST" action="{{ route('admin.experiences.store') }}" @submit="submittingCreate = true">
                @csrf
                <input type="hidden" name="_form" value="create" />

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
                        <input type="text" name="company" maxlength="150" value="{{ old('company') }}" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Acme Corp" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                        <input type="text" name="role" maxlength="150" value="{{ old('role') }}" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="e.g. Senior Backend Developer" />
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                        <textarea name="description" rows="4" maxlength="1000" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" placeholder="Briefly describe your responsibilities and achievements...">{{ old('description') }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Max 1000 characters. Optional.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                        <input type="date" name="start_date" value="{{ old('start_date') }}" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                    </div>

                    <div x-data="{ isCurrent: {{ old('is_current') ? 'true' : 'false' }} }">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="is_current" value="1" x-model="isCurrent" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                            <span class="text-sm text-gray-700 dark:text-gray-300">I currently work here</span>
                        </label>

                        <div x-show="!isCurrent" x-transition class="mt-3">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                            <input type="date" name="end_date" value="{{ old('end_date') }}" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                        <input type="number" name="order" value="{{ old('order', 0) }}" min="0" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                        <p class="text-xs text-gray-400 mt-1">Lower numbers appear first when dates are equal.</p>
                    </div>
                </div>

                @if($errors->any() && old('_form') === 'create')
                    <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 mb-4 mt-4">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showCreate = false" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" :disabled="submittingCreate" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 rounded-lg transition-colors disabled:cursor-not-allowed flex items-center gap-2">
                        <span x-show="!submittingCreate">Add Experience</span>
                        <span x-show="submittingCreate" class="flex items-center gap-2">
                            <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                            Adding...
                        </span>
                    </button>
                </div>
            </form>
        </x-admin.dialog>

        <x-admin.dialog :open="'showEdit'" title="Edit Experience" :close="'showEdit = false; editExperience = null'" max-width="max-w-lg">
            <template x-if="editExperience !== null">
                <form method="POST" :action="`{{ route('admin.experiences.index') }}/${editExperience.id}`" @submit="submittingEdit = true">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit" />

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Company</label>
                            <input type="text" name="company" maxlength="150" :value="editExperience.company" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Role</label>
                            <input type="text" name="role" maxlength="150" :value="editExperience.role" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <input type="hidden" name="description" x-model="editExperience.description">
                            <textarea rows="4" maxlength="1000" x-text="editExperience.description" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <p class="text-xs text-gray-400 mt-1">Max 1000 characters. Optional.</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Start Date</label>
                            <input type="date" name="start_date" :value="editExperience.start_date" required class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                        </div>

                        <div x-data="{ isCurrent: false }" x-effect="isCurrent = editExperience.is_current">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="is_current" value="1" x-model="isCurrent" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" />
                                <span class="text-sm text-gray-700 dark:text-gray-300">I currently work here</span>
                            </label>

                            <div x-show="!isCurrent" x-transition class="mt-3">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">End Date</label>
                                <input type="date" name="end_date" :value="editExperience.end_date" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                            <input type="number" name="order" :value="editExperience.order" min="0" class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500" />
                            <p class="text-xs text-gray-400 mt-1">Lower numbers appear first when dates are equal.</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEdit = false; editExperience = null" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" :disabled="submittingEdit" class="px-4 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 rounded-lg transition-colors disabled:cursor-not-allowed flex items-center gap-2">
                            <span x-show="!submittingEdit">Save Changes</span>
                            <span x-show="submittingEdit" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </template>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Experience" :close="'showDelete = false'" max-width="max-w-md">
            <template x-if="deleteExperience !== null">
                <form method="POST" :action="`{{ route('admin.experiences.index') }}/${deleteExperience.id}`" @submit="submittingDelete = true">
                    @csrf
                    @method('DELETE')
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        Are you sure you want to delete
                        <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="`${deleteExperience.role} at ${deleteExperience.company}`"></span>?
                        This action cannot be undone.
                    </p>
                    <div class="flex justify-end gap-3 mt-6">
                        <button type="button" @click="showDelete = false; deleteExperience = null" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" :disabled="submittingDelete" class="bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white px-4 py-2 rounded-lg text-sm disabled:cursor-not-allowed flex items-center gap-2">
                            <span x-show="!submittingDelete">Yes, Delete</span>
                            <span x-show="submittingDelete" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Deleting...
                            </span>
                        </button>
                    </div>
                </form>
            </template>
        </x-admin.dialog>

    </div>
</x-layouts.admin>
