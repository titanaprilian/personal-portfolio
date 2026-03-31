<x-layouts.admin title="Skills">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editSkill: null,
        editForm: { name: '', skill_category_id: '', proficiency: 80, icon: '', icon_color: '' },
        deleteSkill: null,
        colorOptions: {{ json_encode(\App\Helpers\TailwindColors::getColorOptions()) }},
        createIcon: '{{ old('icon', '') }}',
        createIconColor: '{{ old('icon_color', '') }}',
        createColorOpen: false,
        editColorOpen: false,
        submittingCreate: false,
        submittingEdit: false,
        submittingDelete: false,
        initEditForm() {
            if (this.editSkill) {
                this.editForm = {
                    name: this.editSkill.name || '',
                    skill_category_id: this.editSkill.skill_category_id || '',
                    proficiency: this.editSkill.proficiency ?? 80,
                    icon: this.editSkill.icon || '',
                    icon_color: this.editSkill.icon_color || ''
                };
                this.$nextTick(() => {
                    const pickerWrapper = this.$el.querySelector('.edit-icon-picker [x-data]');
                    if (pickerWrapper) {
                        const pickerData = Alpine.$data(pickerWrapper);
                        pickerData.selectedSlug = this.editSkill.icon || '';
                        pickerData.applyInitialValue();
                    }
                });
            }
        }
    }" x-init="$watch('editSkill', () => initEditForm())">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Skills</h1>
            <button @click="showCreate = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                + Add Skill
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Icon</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Proficiency</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Color</th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($skills as $skill)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">
                                    @if($skill->icon)
                                        <img src="https://cdn.simpleicons.org/{{ $skill->icon }}{{ $skill->icon_color ? '/' . ltrim(\App\Helpers\TailwindColors::getHex($skill->icon_color), '#') : '' }}"
                                             alt="{{ $skill->name }}"
                                             class="w-8 h-8 object-contain">
                                    @else
                                        <div class="w-8 h-8 rounded bg-gray-100 dark:bg-gray-700"></div>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $skill->name }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $skill->skillCategory->name }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 min-w-32">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                            <div
                                                class="h-full rounded-full bg-indigo-500 transition-all"
                                                style="width: {{ $skill->proficiency }}%"
                                            ></div>
                                        </div>
                                        <span class="text-xs text-gray-500 dark:text-gray-400 w-8 text-right">
                                            {{ $skill->proficiency }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($skill->icon_color)
                                        <div class="flex items-center gap-2">
                                            <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600"
                                                  style="background-color: {{ \App\Helpers\TailwindColors::getHex($skill->icon_color) }}"></span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ $skill->icon_color }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button @click="showEdit = true; editSkill = {{ $skill->toJson() }}"
                                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm mr-3">
                                        Edit
                                    </button>
                                    <button @click="showDelete = true; deleteSkill = {{ json_encode(['id' => $skill->id, 'name' => $skill->name]) }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No skills yet. Create your first skill!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
                @forelse($skills as $skill)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        <div class="p-4">
                            <div class="flex items-center gap-3 mb-3">
                                @if($skill->icon)
                                    <img src="https://cdn.simpleicons.org/{{ $skill->icon }}{{ $skill->icon_color ? '/' . ltrim(\App\Helpers\TailwindColors::getHex($skill->icon_color), '#') : '' }}"
                                         alt="{{ $skill->name }}"
                                         class="w-10 h-10 object-contain">
                                @else
                                    <div class="w-10 h-10 rounded bg-gray-100 dark:bg-gray-700"></div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $skill->name }}</h3>
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $skill->skillCategory->name }}
                                    </span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="text-xs text-gray-500">Proficiency</span>
                                    <span class="text-xs font-medium text-indigo-600">{{ $skill->proficiency }}%</span>
                                </div>
                                <div class="h-2 rounded-full bg-gray-100 dark:bg-gray-700 overflow-hidden">
                                    <div class="h-full rounded-full bg-indigo-500" style="width: {{ $skill->proficiency }}%"></div>
                                </div>
                            </div>
                            <div class="flex gap-2">
                                <button @click="showEdit = true; editSkill = {{ $skill->toJson() }}"
                                    class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-colors">
                                    Edit
                                </button>
                                <button @click="showDelete = true; deleteSkill = {{ json_encode(['id' => $skill->id, 'name' => $skill->name]) }}"
                                    class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-lg font-medium text-sm transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                        No skills yet. Create your first skill!
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $skills->links() }}
        </div>

        <x-admin.dialog :open="'showCreate'" title="Add Skill" :close="'showCreate = false'" max-width="max-w-lg">
            <form method="POST" action="{{ route('admin.skills.store') }}" @submit="submittingCreate = true">
                @csrf
                <input type="hidden" name="_form" value="create">

                @if($errors->any())
                    <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 mb-4">
                        <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" maxlength="100"
                            placeholder="e.g. Laravel"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="skill_category_id"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                            <option value="">— Select category —</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('skill_category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div x-data="{ proficiency: {{ old('proficiency', 80) }} }">
                        <div class="flex items-center justify-between mb-1">
                            <label class="text-sm text-gray-700 dark:text-gray-300">Proficiency</label>
                            <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400" x-text="proficiency + '%'"></span>
                        </div>
                        <input
                            type="range"
                            name="proficiency"
                            min="0" max="100" step="1"
                            x-model.number="proficiency"
                            class="w-full accent-indigo-600"
                        >
                        <div class="flex justify-between text-xs text-gray-400 mt-1">
                            <span>0%</span><span>50%</span><span>100%</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Icon <span class="text-gray-400 text-xs">(optional)</span>
                        </label>
                        <div class="flex items-center gap-3">
                            <div class="flex-1" @input="createIcon = $el.querySelector('[name=icon]').value">
                                <x-admin.icon-picker name="icon" value="{{ old('icon', '') }}" />
                            </div>
                            <div x-show="createIcon" class="flex items-center gap-2">
                                <img :src="'https://cdn.simpleicons.org/' + createIcon + (createIconColor ? '/' + createIconColor : '')"
                                     class="w-8 h-8 object-contain"
                                     onerror="this.style.display='none'">
                                <span x-show="createIconColor" class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600"
                                      :style="'background-color: ' + colorOptions[createIconColor]"></span>
                            </div>
                        </div>
                    </div>

                    <div x-show="createIcon" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Icon Color <span class="text-gray-400 text-xs">(optional)</span>
                        </label>
                        <div class="relative" :class="createColorOpen ? 'pb-16' : ''">
                            <button type="button" @click="createColorOpen = !createColorOpen" class="w-full flex items-center justify-between px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500">
                                <span x-show="createIconColor" class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                    <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600" :style="'background-color: ' + colorOptions[createIconColor]"></span>
                                    <span x-text="createIconColor.charAt(0).toUpperCase() + createIconColor.slice(1)"></span>
                                </span>
                                <span x-show="!createIconColor" class="text-gray-400">Select color</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="createColorOpen" @click.outside="createColorOpen = false" x-transition class="absolute z-10 w-full mt-1 py-1 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-600 shadow-lg max-h-48 overflow-y-auto">
                                <button type="button" @click="createIconColor = ''; createColorOpen = false" class="w-full px-3 py-2 text-left text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Default
                                </button>
                                <template x-for="(hex, color) in colorOptions" :key="color">
                                    <button type="button" @click="createIconColor = color; createColorOpen = false" class="w-full flex items-center gap-2 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100">
                                        <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600" :style="'background-color: ' + hex"></span>
                                        <span x-text="color.charAt(0).toUpperCase() + color.slice(1)"></span>
                                    </button>
                                </template>
                            </div>
                        </div>
                        <input type="hidden" name="icon_color" :value="createIconColor">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showCreate = false" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" :disabled="submittingCreate" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white rounded-lg font-medium transition-colors disabled:cursor-not-allowed flex items-center gap-2">
                        <span x-show="!submittingCreate">Add Skill</span>
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

        <x-admin.dialog :open="'showEdit'" title="Edit Skill" :close="'showEdit = false; editSkill = null'" max-width="max-w-lg">
            <div x-show="editSkill">
                <form method="POST" :action="editSkill ? `/admin/skills/${editSkill.id}` : ''" @submit="submittingEdit = true">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">

                    @if($errors->any())
                        <div class="rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 p-3 mb-4">
                            <ul class="list-disc list-inside text-sm text-red-600 dark:text-red-400 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                            <input type="text" name="name" x-model="editForm.name" maxlength="100"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                            <select name="skill_category_id" x-model="editForm.skill_category_id"
                                class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">— Select category —</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label class="text-sm text-gray-700 dark:text-gray-300">Proficiency</label>
                                <span class="text-sm font-semibold text-indigo-600 dark:text-indigo-400" x-text="editForm.proficiency + '%'"></span>
                            </div>
                            <input
                                type="range"
                                name="proficiency"
                                min="0" max="100" step="1"
                                x-model.number="editForm.proficiency"
                                class="w-full accent-indigo-600"
                            >
                            <div class="flex justify-between text-xs text-gray-400 mt-1">
                                <span>0%</span><span>50%</span><span>100%</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Icon <span class="text-gray-400 text-xs">(optional)</span>
                            </label>
                            <div class="flex items-center gap-3">
                                <div class="flex-1 edit-icon-picker">
                                    <x-admin.icon-picker name="icon" value="" />
                                </div>
                            </div>
                        </div>

                        <div x-show="editForm.icon" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Icon Color <span class="text-gray-400 text-xs">(optional)</span>
                            </label>
                            <div class="relative" :class="editColorOpen ? 'pb-16' : ''">
                                <button type="button" @click="editColorOpen = !editColorOpen" class="block w-full flex items-center justify-between px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 focus:border-indigo-500 focus:ring-indigo-500">
                                    <span x-show="editForm.icon_color" class="flex items-center gap-2 text-gray-900 dark:text-gray-100">
                                        <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600" :style="'background-color: ' + colorOptions[editForm.icon_color]"></span>
                                        <span x-text="editForm.icon_color.charAt(0).toUpperCase() + editForm.icon_color.slice(1)"></span>
                                    </span>
                                    <span x-show="!editForm.icon_color" class="text-gray-400">Select color</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div x-show="editColorOpen" @click.outside="editColorOpen = false" x-transition class="absolute z-10 w-full mt-1 py-1 bg-white dark:bg-gray-800 rounded-lg border border-gray-300 dark:border-gray-600 shadow-lg max-h-48 overflow-y-auto">
                                    <button type="button" @click="editForm.icon_color = ''; editColorOpen = false" class="w-full px-3 py-2 text-left text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Default
                                    </button>
                                    <template x-for="(hex, color) in colorOptions" :key="color">
                                        <button type="button" @click="editForm.icon_color = color; editColorOpen = false" class="w-full flex items-center gap-2 px-3 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 text-gray-900 dark:text-gray-100">
                                            <span class="w-4 h-4 rounded-full border border-gray-200 dark:border-gray-600" :style="'background-color: ' + hex"></span>
                                            <span x-text="color.charAt(0).toUpperCase() + color.slice(1)"></span>
                                        </button>
                                    </template>
                                </div>
                            </div>
                            <input type="hidden" name="icon_color" :value="editForm.icon_color">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEdit = false; editSkill = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" :disabled="submittingEdit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white rounded-lg font-medium transition-colors disabled:cursor-not-allowed flex items-center gap-2">
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
            </div>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Skill" :close="'showDelete = false; deleteSkill = null'" max-width="max-w-md">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deleteSkill?.name"></span>?
            </p>
            <form method="POST" :action="deleteSkill ? `/admin/skills/${deleteSkill.id}` : ''" class="mt-6" @submit="submittingDelete = true">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deleteSkill = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" :disabled="submittingDelete" class="px-4 py-2 bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white rounded-lg font-medium transition-colors disabled:cursor-not-allowed flex items-center gap-2">
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
        </x-admin.dialog>

    </div>
</x-layouts.admin>
