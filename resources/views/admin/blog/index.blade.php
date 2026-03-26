<x-layouts.admin title="Blog Posts">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editPost: null,
        deletePost: null,
    }">
        @if (session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">Blog Posts</h1>
            <button @click="showCreate = true"
                class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">
                + New Post
            </button>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm overflow-hidden">
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Thumbnail</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Title</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Category</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Tags</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Status</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Reading Time</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider overflow-visible">
                                <span>Order</span>
                                <x-admin.tooltip text="Controls the display order. Lower numbers appear first. You can swap orders by changing the number to an existing value." />
                            </th>
                            <th
                                class="px-4 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($posts as $post)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="px-4 py-3">
                                    @if ($post->thumbnail)
                                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt=""
                                            class="w-12 h-12 rounded-lg object-cover">
                                    @else
                                        <div
                                            class="w-12 h-12 rounded-lg bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</div>
                                    <div class="text-sm text-gray-500">{{ $post->slug }}</div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($post->category)
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $post->category->name }}</span>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex flex-wrap gap-1">
                                        @foreach ($post->tags->take(3) as $tag)
                                            <span
                                                class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">{{ $tag->name }}</span>
                                        @endforeach
                                        @if ($post->tags->count() > 3)
                                            <span
                                                class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">+{{ $post->tags->count() - 3 }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if ($post->published_at && $post->published_at->isPast())
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Published</span>
                                    @elseif($post->published_at && $post->published_at->isFuture())
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300">Scheduled</span>
                                    @else
                                        <span
                                            class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">Draft</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-gray-600 dark:text-gray-400">{{ $post->reading_time }} min
                                    read</td>
                                <td class="px-4 py-3">
                                    <form action="{{ route('admin.blog.updateOrder', $post) }}" method="POST" class="flex items-center gap-1 order-form"
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
                                                    window.location.href = window.location.href;
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
                                        <input type="number" name="order" value="{{ $post->order }}" min="0"
                                            class="w-16 px-2 py-1 text-sm rounded border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                        <button type="submit" class="text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400" title="Update order">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                        </button>
                                    </form>
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <button @click="showEdit = true; editPost = @js(['id' => $post->id, 'title' => $post->title, 'slug' => $post->slug, 'body' => $post->body, 'category_id' => $post->category_id, 'thumbnail' => $post->thumbnail, 'published_at' => $post->published_at ? $post->published_at->toIsoString() : null, 'tags' => $post->tags->pluck('id')->toArray()])"
                                        class="text-indigo-600 hover:text-indigo-800 dark:text-indigo-400 dark:hover:text-indigo-300 font-medium text-sm mr-3">
                                        Edit
                                    </button>
                                    <button @click="showDelete = true; deletePost = @js(['id' => $post->id, 'title' => $post->title])"
                                        class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium text-sm">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">
                                    No posts yet. Create your first post!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="md:hidden grid grid-cols-1 sm:grid-cols-2 gap-4 p-4">
                @forelse($posts as $post)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg overflow-hidden">
                        @if ($post->thumbnail)
                            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt=""
                                class="w-full aspect-video object-cover">
                        @else
                            <div
                                class="w-full aspect-video bg-gray-200 dark:bg-gray-600 flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-medium text-gray-900 dark:text-gray-100">{{ $post->title }}</h3>
                                @if ($post->published_at && $post->published_at->isPast())
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300">Published</span>
                                @elseif($post->published_at && $post->published_at->isFuture())
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/40 dark:text-yellow-300">Scheduled</span>
                                @else
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">Draft</span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-1 mb-3">
                                @if ($post->category)
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">{{ $post->category->name }}</span>
                                @endif
                                @foreach ($post->tags->take(2) as $tag)
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $post->reading_time }} min
                                read</div>
                            <div class="flex gap-2">
                                <button @click="showEdit = true; editPost = @js(['id' => $post->id, 'title' => $post->title, 'slug' => $post->slug, 'body' => $post->body, 'category_id' => $post->category_id, 'thumbnail' => $post->thumbnail, 'published_at' => $post->published_at ? $post->published_at->toIsoString() : null, 'tags' => $post->tags->pluck('id')->toArray()])"
                                    class="flex-1 px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium text-sm transition-colors">
                                    Edit
                                </button>
                                <button @click="showDelete = true; deletePost = @js(['id' => $post->id, 'title' => $post->title])"
                                    class="px-3 py-2 bg-red-100 hover:bg-red-200 text-red-700 dark:bg-red-900/40 dark:text-red-300 rounded-lg font-medium text-sm transition-colors">
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-8 text-gray-500 dark:text-gray-400">
                        No posts yet. Create your first post!
                    </div>
                @endforelse
            </div>
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>

        <x-admin.dialog :open="'showCreate'" title="New Blog Post" :close="'showCreate = false'" max-width="max-w-4xl">
            <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_form" value="create">

                <div class="space-y-4">
                    <div x-data="{ title: '{{ old('title', '') }}', slug: '{{ old('slug', '') }}' }">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="title" value="{{ old('title') }}"
                                @input="title = $event.target.value; slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                            <input type="text" name="slug" value="{{ old('slug') }}" x-model="slug"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                        <select name="category_id"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">— No category —</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                        <div x-data="{ selected: {{ json_encode(old('tag_ids', [])) }}, map: {{ $tags->pluck('name', 'id')->toJson() }} }">
                            <div class="flex flex-wrap gap-2 mb-2">
                                <template x-for="id in selected" :key="id">
                                    <span
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                        <span x-text="map[id]"></span>
                                        <button type="button"
                                            @click="selected = selected.filter(s => s !== id)">×</button>
                                        <input type="hidden" name="tag_ids[]" :value="id">
                                    </span>
                                </template>
                            </div>
                            <select
                                @change="if ($event.target.value && !selected.includes(Number($event.target.value))) { selected.push(Number($event.target.value)) } $event.target.value = ''"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">+ Add tag</option>
                                @foreach ($tags as $tag)
                                    <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div x-data="quillEditor('{{ old('body', '') }}')">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body</label>
                        <div class="bg-white dark:bg-gray-800 dark:text-gray-100">
                            <div x-ref="editor" style="min-height: 200px;"></div>
                        </div>
                        <textarea name="body" x-ref="textarea" class="hidden">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured
                            Image</label>
                        <div x-data="{ preview: null }">
                            <input type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                                @change="const file = $event.target.files[0]; if (file) { if (file.size > 2 * 1024 * 1024) { alert('File size must be less than 2MB'); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                            <template x-if="preview">
                                <img :src="preview"
                                    class="mt-2 h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                            </template>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Publish Date <span class="text-gray-400 text-xs">(leave empty to save as draft)</span>
                        </label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showCreate = false"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Create
                        Post</button>
                </div>
            </form>
        </x-admin.dialog>

        <x-admin.dialog :open="'showEdit'" title="Edit Post" :close="'showEdit = false; editPost = null'" max-width="max-w-4xl">
            <template x-if="editPost">
                <form method="POST" :action="`/admin/blog/${editPost.id}`" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">

                    <div class="space-y-4">
                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
                            <input type="text" name="title" x-model="editPost.title"
                                @input="editPost.slug = (editPost.title || '').toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
                            <input type="text" name="slug" x-model="editPost.slug"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                        </div>

                        <div>
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                            <select name="category_id" x-model="editPost.category_id"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">— No category —</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
                            <div x-data="{ selected: editPost.tags || [], map: {{ $tags->pluck('name', 'id')->toJson() }} }">
                                <div class="flex flex-wrap gap-2 mb-2">
                                    <template x-for="id in selected" :key="id">
                                        <span
                                            class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                            <span x-text="map[id]"></span>
                                            <button type="button"
                                                @click="selected = selected.filter(s => s !== id)">×</button>
                                            <input type="hidden" name="tag_ids[]" :value="id">
                                        </span>
                                    </template>
                                </div>
                                <select
                                    @change="if ($event.target.value && !selected.includes(Number($event.target.value))) { selected.push(Number($event.target.value)); editPost.tags = selected; } $event.target.value = ''"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">+ Add tag</option>
                                    @foreach ($tags as $tag)
                                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div x-data="quillEditor(editPost.body)">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body</label>
                            <div class="bg-white dark:bg-gray-800 dark:text-gray-100"
                                @set-edit-content.window="if(editPost) { quill.root.innerHTML = editPost.body }">
                                <div x-ref="editor" style="min-height: 200px;"></div>
                            </div>
                            <textarea name="body" x-ref="textarea" x-model="editPost.body" class="hidden"></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured
                                Image</label>
                            <div x-data="{ preview: null }">
                                <template x-if="editPost.thumbnail && !preview">
                                    <img :src="'{{ asset('storage/') }}/' + editPost.thumbnail"
                                        class="mt-2 h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700 mb-2">
                                </template>
                                <template x-if="preview">
                                    <img :src="preview"
                                        class="mt-2 h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700 mb-2">
                                </template>
                                <input type="file" name="thumbnail"
                                    accept="image/jpg,image/jpeg,image/png,image/webp"
                                    @change="const file = $event.target.files[0]; if (file) { if (file.size > 2 * 1024 * 1024) { alert('File size must be less than 2MB'); $event.target.value = ''; return; } const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); }"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Publish Date <span class="text-gray-400 text-xs">(leave empty to save as draft)</span>
                            </label>
                            <input type="datetime-local" name="published_at"
                                :value="editPost.published_at ? new Date(editPost.published_at).toISOString().slice(0, 16) : ''"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button type="button" @click="showEdit = false; editPost = null"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg font-medium transition-colors">Save
                            Changes</button>
                    </div>
                </form>
            </template>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Post" :close="'showDelete = false; deletePost = null'" max-width="max-w-md">
            <p class="text-gray-600 dark:text-gray-400 text-sm">
                Are you sure you want to delete
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deletePost?.title"></span>?
                This action cannot be undone.
            </p>
            <form method="POST" :action="deletePost ? `/admin/blog/${deletePost.id}` : ''" class="mt-6">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deletePost = null"
                        class="px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">Cancel</button>
                    <button type="submit"
                        class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors">Yes,
                        Delete</button>
                </div>
            </form>
        </x-admin.dialog>

    </div>
</x-layouts.admin>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('quillEditor', (content) => ({
            quill: null,
            init() {
                this.quill = new Quill(this.$refs.editor, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            // Added heading levels here
                            [{
                                'header': [1, 2, 3, false]
                            }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{
                                'list': 'ordered'
                            }, {
                                'list': 'bullet'
                            }],
                            ['link', 'blockquote', 'code-block'],
                            ['clean']
                        ]
                    }
                });

                if (content) {
                    this.quill.root.innerHTML = content;
                }

                this.quill.on('text-change', () => {
                    this.$refs.textarea.value = this.quill.root.innerHTML;
                    this.$refs.textarea.dispatchEvent(new Event('input'));
                });
            }
        }))
    })
</script>
