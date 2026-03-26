@php
    $oldEditProject = null;
    if ($errors->any() && old('_form') === 'edit') {
        $oldEditProject = [
            'id' => old('id'),
            'title' => old('title'),
            'slug' => old('slug'),
            'description' => old('description'),
            'body' => old('body'),
            'demo_url' => old('demo_url'),
            'github_url' => old('github_url'),
            'featured_order' => old('featured_order') ? (int) old('featured_order') : null,
            'order' => old('order') ?? 0,
            'thumbnail' => old('thumbnail'),
        ];
    }
@endphp

<x-layouts.admin title="Projects">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editProject: {{ $oldEditProject ? json_encode($oldEditProject) : 'null' }},
        deleteProject: null,
    }">
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Projects</h1>
            <button @click="showCreate = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                + New Project
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Thumbnail</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Categories</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tags</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider overflow-visible" style="width: 120px;">
                                <span>Featured</span>
                                <x-admin.tooltip text="Featured projects appear in the top 3 slots on the public page. Only 3 projects can be featured at a time." />
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider overflow-visible">
                                <span>Order</span>
                                <x-admin.tooltip text="Controls the display order on the public page. Lower numbers appear first. Featured projects use their slot number (1, 2, 3) for ordering instead." />
                            </th>
                            <th class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($projects as $project)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">
                                    @if($project->thumbnail)
                                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="" class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $project->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $project->slug }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($project->categories->take(2) as $category)
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $category->name }}</span>
                                        @endforeach
                                        @if($project->categories->count() > 2)
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">+{{ $project->categories->count() - 2 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($project->tags->take(3) as $tag)
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">{{ $tag->name }}</span>
                                        @endforeach
                                        @if($project->tags->count() > 3)
                                            <span class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">+{{ $project->tags->count() - 3 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if($project->featured_order)
                                        <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">
                                            Slot {{ $project->featured_order }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.projects.updateOrder', $project) }}" method="POST" class="flex items-center gap-1 order-form"
                                        @submit.prevent="async (e) => {
                                            const form = e.target;
                                            const input = form.querySelector('input[name=order]');
                                            const originalValue = input.value;
                                            try {
                                                const response = await fetch(form.action, {
                                                    method: 'POST',
                                                    body: new FormData(form),
                                                    headers: { 'Accept': 'application/json' }
                                                });
                                                const data = await response.json();
                                                if (response.ok) {
                                                    input.classList.remove('border-red-300', 'dark:border-red-600');
                                                    input.classList.add('border-green-300', 'dark:border-green-600');
                                                    setTimeout(() => input.classList.remove('border-green-300', 'dark:border-green-600'), 1500);
                                                } else {
                                                    input.value = originalValue;
                                                    input.classList.add('border-red-300', 'dark:border-red-600');
                                                    setTimeout(() => input.classList.remove('border-red-300', 'dark:border-red-600'), 2000);
                                                }
                                            } catch (err) {
                                                input.value = originalValue;
                                            }
                                        }">
                                        @csrf
                                        @method('PATCH')
                                        <input type="number" name="order" value="{{ $project->order }}" min="0"
                                            class="w-16 px-2 py-1 text-sm rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="submit" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" title="Update order">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button @click="showEdit = true; editProject = {{ $project->load(['categories', 'tags'])->toJson() }}"
                                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm mr-3">
                                        Edit
                                    </button>
                                    <button @click="showDelete = true; deleteProject = {{ json_encode(['id' => $project->id, 'title' => $project->title]) }}"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No projects yet. Create your first project!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
                @forelse($projects as $project)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        @if($project->thumbnail)
                            <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="" class="w-full aspect-video object-cover">
                        @else
                            <div class="w-full aspect-video bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $project->title }}</h3>
                                @if($project->featured_order)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Slot {{ $project->featured_order }}</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-1 mb-3">
                                @foreach($project->categories as $category)
                                    <span class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $category->name }}</span>
                                @endforeach
                            </div>
                            <div class="flex gap-2">
                                <button @click="showEdit = true; editProject = {{ $project->load(['categories', 'tags'])->toJson() }}"
                                    class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-colors">
                                    Edit
                                </button>
                                <button @click="showDelete = true; deleteProject = {{ json_encode(['id' => $project->id, 'title' => $project->title]) }}"
                                    class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-lg font-medium text-sm transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                        No projects yet. Create your first project!
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $projects->links() }}
        </div>

        <x-admin.dialog :open="'showCreate'" title="Add New Project" :close="'showCreate = false'" max-width="max-w-3xl">
            <form method="POST" action="{{ route('admin.projects.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_form" value="create">
                <x-admin.project-form :project="null" :categories="$categories" :tags="$tags" :occupied-slots="$occupiedSlots" formId="create-project-form" />
                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showCreate = false" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Create Project</button>
                </div>
            </form>
        </x-admin.dialog>

        <x-admin.dialog :open="'showEdit'" title="Edit Project" :close="'showEdit = false; editProject = null'" max-width="max-w-3xl">
            <template x-if="editProject">
                <form method="POST" :action="`/admin/projects/${editProject.id}`" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="title" x-model="editProject.title"
                                @input="editProject.slug = (editProject.title || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                            <input type="text" name="slug" x-model="editProject.slug"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                            <textarea name="description" x-model="editProject.description" maxlength="500"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                rows="2" required></textarea>
                            <p class="text-xs text-gray-400 mt-1" x-text="(editProject.description || '').length + '/500'"></p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body (Full Details)</label>
                            <textarea name="body" x-model="editProject.body"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                rows="4"></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Demo URL</label>
                                <input type="url" name="demo_url" x-model="editProject.demo_url"
                                    placeholder="https://..."
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GitHub URL</label>
                                <input type="url" name="github_url" x-model="editProject.github_url"
                                    placeholder="https://github.com/..."
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Thumbnail</label>
                            <div>
                                <template x-if="editProject.thumbnail">
                                    <img :src="'{{ asset('storage/') }}/' + editProject.thumbnail" class="mt-2 h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700 mb-2">
                                </template>
                                <input type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categories</label>
                            <div x-data="{ selected: editProject.categories.map(c => c.id), map: {{ $categories->pluck('name', 'id')->toJson() }} }">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <template x-for="id in selected" :key="id">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                            <span x-text="map[id]"></span>
                                            <button type="button" @click="selected = selected.filter(s => s !== id)">×</button>
                                            <input type="hidden" name="category_ids[]" :value="id">
                                        </span>
                                    </template>
                                </div>
                                <select @change="if ($event.target.value && !selected.includes(Number($event.target.value))) { selected.push(Number($event.target.value)) } $event.target.value = ''"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">+ Add category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                            <div x-data="{ selected: editProject.tags.map(t => t.id), map: {{ $tags->pluck('name', 'id')->toJson() }} }">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <template x-for="id in selected" :key="id">
                                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                            <span x-text="map[id]"></span>
                                            <button type="button" @click="selected = selected.filter(s => s !== id)">×</button>
                                            <input type="hidden" name="tag_ids[]" :value="id">
                                        </span>
                                    </template>
                                </div>
                                <select @change="if ($event.target.value && !selected.includes(Number($event.target.value))) { selected.push(Number($event.target.value)) } $event.target.value = ''"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">+ Add tag</option>
                                    @foreach($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div x-data="{ occupiedSlots: {{ json_encode($occupiedSlots) }} }">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured Slot</label>
                            <select name="featured_order"
                                x-model="editProject.featured_order"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">None</option>
                                <option value="1" x-show="!occupiedSlots.includes(1) || editProject.featured_order == 1">Slot 1 (Primary)</option>
                                <option value="2" x-show="!occupiedSlots.includes(2) || editProject.featured_order == 2">Slot 2</option>
                                <option value="3" x-show="!occupiedSlots.includes(3) || editProject.featured_order == 3">Slot 3</option>
                            </select>
                            <template x-if="occupiedSlots.length >= 3 && editProject.featured_order == null">
                                <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">All featured slots are taken. Remove a featured project first or set a featured project's slot to none.</p>
                            </template>
                            <template x-if="occupiedSlots.length > 0 && occupiedSlots.length < 3 && !occupiedSlots.includes(editProject.featured_order)">
                                <p class="text-xs text-gray-400 mt-1">Other slots are already assigned to other projects.</p>
                            </template>
                            <p class="text-xs text-gray-400 mt-1">Use inline order field in the list to reorder unfeatured projects.</p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEdit = false; editProject = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Save Changes</button>
                    </div>
                </form>
            </template>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Project" :close="'showDelete = false; deleteProject = null'" max-width="max-w-md">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Are you sure you want to delete
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deleteProject?.title"></span>?
                This action cannot be undone.
            </p>
            <form method="POST" :action="deleteProject ? `/admin/projects/${deleteProject.id}` : ''" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deleteProject = null" class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">Yes, Delete</button>
                </div>
            </form>
        </x-admin.dialog>

    </div>
</x-layouts.admin>
