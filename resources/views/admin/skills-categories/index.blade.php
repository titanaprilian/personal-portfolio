<x-layouts.admin title="Skill Categories">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editCategory: null,
        editForm: { name: '' },
        deleteCategory: null,
        initEditForm() {
            if (this.editCategory) {
                this.editForm = {
                    name: this.editCategory.name || ''
                };
            }
        }
    }" x-init="$watch('editCategory', () => initEditForm())">

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Skill Categories</h1>
            <button @click="showCreate = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                + Add Category
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Name</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Skills Count</th>
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($categories as $category)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                            <td class="px-4 py-3 font-medium text-gray-900 dark:text-gray-100">{{ $category->name }}</td>
                            <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $category->skills_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <button @click="showEdit = true; editCategory = {{ $category->toJson() }}"
                                    class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm mr-3">
                                    Edit
                                </button>
                                <button @click="showDelete = true; deleteCategory = {{ json_encode(['id' => $category->id, 'name' => $category->name]) }}"
                                    class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                    Delete
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                No categories yet. Create your first category!
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-admin.dialog :open="'showCreate'" title="Add Category" :close="'showCreate = false'" max-width="max-w-md">
            <form method="POST" action="{{ route('admin.skills-categories.store') }}">
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

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" maxlength="50"
                        placeholder="e.g. Backend"
                        class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                        required>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showCreate = false" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Add Category</button>
                </div>
            </form>
        </x-admin.dialog>

        <x-admin.dialog :open="'showEdit'" title="Edit Category" :close="'showEdit = false; editCategory = null'" max-width="max-w-md">
            <div x-show="editCategory">
                <form method="POST" :action="editCategory ? `/admin/skills-categories/${editCategory.id}` : ''">
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                        <input type="text" name="name" x-model="editForm.name" maxlength="50"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            required>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEdit = false; editCategory = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Save Changes</button>
                    </div>
                </form>
            </div>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Category" :close="'showDelete = false; deleteCategory = null'" max-width="max-w-md">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to delete
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deleteCategory?.name"></span>?
            </p>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                This category has <span class="font-semibold" x-text="deleteCategory?.skills_count || 0"></span> skills.
            </p>
            <form method="POST" :action="deleteCategory ? `/admin/skills-categories/${deleteCategory.id}` : ''" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deleteCategory = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">Yes, Delete</button>
                </div>
            </form>
        </x-admin.dialog>

    </div>
</x-layouts.admin>
