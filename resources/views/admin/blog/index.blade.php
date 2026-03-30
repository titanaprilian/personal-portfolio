@php
    $oldEditPost = null;
    if ($errors->any() && old('_form') === 'edit') {
        $oldEditPost = [
            'id' => old('id'),
            'title' => old('title'),
            'slug' => old('slug'),
            'category_id' => old('category_id'),
            'body' => old('body'),
            'published_at' => old('published_at'),
            'tags' => array_map('intval', old('tag_ids', [])),
            'thumbnail' => old('thumbnail_path'), // We should pass the path back if we want to preserve preview
        ];
    }
@endphp

<x-layouts.admin title="Blog Posts">
    <div x-data="{
        showCreate: {{ $errors->any() && old('_form') === 'create' ? 'true' : 'false' }},
        showEdit: {{ $errors->any() && old('_form') === 'edit' ? 'true' : 'false' }},
        showDelete: false,
        editPost: {{ $oldEditPost ? json_encode($oldEditPost) : 'null' }},
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
            <button @click="showCreate = true; setTimeout(() => initCreateEditor(), 100)"
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
                                        @foreach ($tags->whereIn('id', $post->tags->pluck('id')) as $tag)
                                            <span
                                                class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                                {{ $tag->name }}
                                            </span>
                                        @endforeach
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
                                    <button
                                        @click="showEdit = true; editPost = @js(['id' => $post->id, 'title' => $post->title, 'slug' => $post->slug, 'body' => $post->body, 'category_id' => $post->category_id, 'thumbnail' => $post->thumbnail, 'published_at' => $post->published_at ? $post->published_at->toIsoString() : null, 'tags' => $post->tags->pluck('id')->toArray()]); setTimeout(() => initEditEditor(editPost.body), 100)"
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
                                @foreach ($tags->whereIn('id', $post->tags->pluck('id')) as $tag)
                                    <span
                                        class="px-2 py-0.5 text-xs rounded-full bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mb-3">{{ $post->reading_time }} min
                                read</div>
                            <div class="flex gap-2">
                                <button
                                    @click="showEdit = true; editPost = @js(['id' => $post->id, 'title' => $post->title, 'slug' => $post->slug, 'body' => $post->body, 'category_id' => $post->category_id, 'thumbnail' => $post->thumbnail, 'published_at' => $post->published_at ? $post->published_at->toIsoString() : null, 'tags' => $post->tags->pluck('id')->toArray()]); setTimeout(() => initEditEditor(editPost.body), 100)"
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

        <x-admin.dialog :open="'showCreate'" title="Add New Post" :close="'showCreate = false'" max-width="max-w-4xl">
            <form method="POST" action="{{ route('admin.blog.store') }}" enctype="multipart/form-data" id="create-post-form">
                @csrf
                <input type="hidden" name="_form" value="create">

                <div class="space-y-4">
                    <div class="grid md:grid-cols-2 gap-4">
                        <div x-data="{ title: '{{ old('title', '') }}', slug: '{{ old('slug', '') }}' }" class="col-span-full grid md:grid-cols-2 gap-4">
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

                        <div x-data="dateTimePicker('{{ old('published_at') }}')">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Publish Date <span class="text-gray-400 text-xs">(optional)</span>
                            </label>
                            <div class="relative">
                                <input type="hidden" name="published_at" x-model="value">
                                <button type="button" @click="showPicker = !showPicker"
                                    class="w-full flex items-center justify-between px-4 py-2 text-left rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                    <span x-text="displayValue"></span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </button>

                                <div x-show="showPicker" @click.away="showPicker = false" x-cloak
                                    class="absolute left-0 mt-2 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 w-full sm:w-80">
                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Date</label>
                                            <input type="date" x-model="date"
                                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                        </div>
                                        
                                        <div class="grid grid-cols-2 gap-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Hour</label>
                                                <div class="grid grid-cols-4 gap-1 overflow-y-auto max-h-40 p-1 border border-gray-100 dark:border-gray-700 rounded-lg">
                                                    <template x-for="h in Array.from({length: 24}, (_, i) => i)" :key="h">
                                                        <button type="button" 
                                                            @click="selectHour(h)"
                                                            :class="hour == h.toString().padStart(2, '0') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 dark:hover:bg-indigo-900/40 text-gray-700 dark:text-gray-300'"
                                                            class="px-1 py-2 text-xs rounded transition-colors"
                                                            x-text="h.toString().padStart(2, '0')"></button>
                                                    </template>
                                                </div>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Minute</label>
                                                <div class="grid grid-cols-2 gap-1 overflow-y-auto max-h-40 p-1 border border-gray-100 dark:border-gray-700 rounded-lg">
                                                    <template x-for="m in Array.from({length: 12}, (_, i) => i * 5)" :key="m">
                                                        <button type="button" 
                                                            @click="selectMinute(m)"
                                                            :class="selectedMinute == m.toString().padStart(2, '0') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 dark:hover:bg-indigo-900/40 text-gray-700 dark:text-gray-300'"
                                                            class="px-1 py-2 text-xs rounded transition-colors"
                                                            x-text="m.toString().padStart(2, '0')"></button>
                                                    </template>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                                            <button type="button" @click="clear()" 
                                                class="text-xs text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                Clear to Draft
                                            </button>
                                            <button type="button" @click="showPicker = false" 
                                                class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition-colors">
                                                Done
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body</label>
                        <textarea name="body" id="body-editor"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            rows="4">{{ old('body') }}</textarea>
                        @error('body')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured
                            Image</label>
                        <div x-data="{ preview: null, fileName: '' }">
                            <div class="relative">
                                <input type="file" name="thumbnail" x-ref="thumbnailInput"
                                    accept="image/jpg,image/jpeg,image/png,image/webp"
                                    @change="const file = $event.target.files[0]; if (file) { if (file.size > 2 * 1024 * 1024) { alert('File size must be less than 2MB'); $event.target.value = ''; preview = ''; fileName = ''; return; } const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); fileName = file.name; }"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center justify-center w-full h-48 border-2 border-dashed rounded-lg transition-colors
                                    border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-500 dark:bg-gray-800 overflow-hidden">
                                    <template x-if="!preview">
                                        <div class="text-center p-4">
                                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">Click to upload</span>
                                                or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <div class="relative group p-2">
                                            <img :src="preview"
                                                class="h-32 w-auto max-w-full rounded-lg object-contain shadow-sm">
                                            <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" @click.stop="preview = null; fileName = ''; $refs.thumbnailInput.value = ''"
                                                    class="bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 shadow-md">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
                        </div>
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
                <form method="POST" :action="`/admin/blog/${editPost.id}`" enctype="multipart/form-data" id="edit-post-form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_form" value="edit">
                    <input type="hidden" name="id" :value="editPost.id">

                    <div class="space-y-4">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div class="col-span-full grid md:grid-cols-2 gap-4">
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

                            <div x-data="dateTimePicker(editPost.published_at)">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                    Publish Date <span class="text-gray-400 text-xs">(optional)</span>
                                </label>
                                <div class="relative">
                                    <input type="hidden" name="published_at" x-model="value">
                                    <button type="button" @click="showPicker = !showPicker"
                                        class="w-full flex items-center justify-between px-4 py-2 text-left rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                                        <span x-text="displayValue"></span>
                                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </button>

                                    <div x-show="showPicker" @click.away="showPicker = false" x-cloak
                                        class="absolute left-0 mt-2 p-4 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-200 dark:border-gray-700 z-50 w-full sm:w-80">
                                        <div class="space-y-4">
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Date</label>
                                                <input type="date" x-model="date"
                                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </div>
                                            
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Hour</label>
                                                    <div class="grid grid-cols-4 gap-1 overflow-y-auto max-h-40 p-1 border border-gray-100 dark:border-gray-700 rounded-lg">
                                                        <template x-for="h in Array.from({length: 24}, (_, i) => i)" :key="h">
                                                            <button type="button" 
                                                                @click="selectHour(h)"
                                                                :class="hour == h.toString().padStart(2, '0') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 dark:hover:bg-indigo-900/40 text-gray-700 dark:text-gray-300'"
                                                                class="px-1 py-2 text-xs rounded transition-colors"
                                                                x-text="h.toString().padStart(2, '0')"></button>
                                                        </template>
                                                    </div>
                                                </div>
                                                <div>
                                                    <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Minute</label>
                                                    <div class="grid grid-cols-2 gap-1 overflow-y-auto max-h-40 p-1 border border-gray-100 dark:border-gray-700 rounded-lg">
                                                        <template x-for="m in Array.from({length: 12}, (_, i) => i * 5)" :key="m">
                                                            <button type="button" 
                                                                @click="selectMinute(m)"
                                                                :class="selectedMinute == m.toString().padStart(2, '0') ? 'bg-indigo-600 text-white' : 'hover:bg-indigo-50 dark:hover:bg-indigo-900/40 text-gray-700 dark:text-gray-300'"
                                                                class="px-1 py-2 text-xs rounded transition-colors"
                                                                x-text="m.toString().padStart(2, '0')"></button>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="flex items-center justify-between pt-2 border-t border-gray-100 dark:border-gray-700">
                                                <button type="button" @click="clear()" 
                                                    class="text-xs text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium">
                                                    Clear to Draft
                                                </button>
                                                <button type="button" @click="showPicker = false" 
                                                    class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-xs font-medium hover:bg-indigo-700 transition-colors">
                                                    Done
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body</label>
                        <textarea name="body" id="body-editor-edit" x-model="editPost.body"
                            class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                            rows="4"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured
                            Image</label>
                        <div x-data="{ preview: editPost.thumbnail ? '{{ asset('storage/') }}/' + editPost.thumbnail : null, fileName: '' }">
                            <div class="relative">
                                <input type="file" name="thumbnail" x-ref="thumbnailInput"
                                    accept="image/jpg,image/jpeg,image/png,image/webp"
                                    @change="const file = $event.target.files[0]; if (file) { if (file.size > 2 * 1024 * 1024) { alert('File size must be less than 2MB'); $event.target.value = ''; preview = ''; fileName = ''; return; } const reader = new FileReader(); reader.onload = (e) => preview = e.target.result; reader.readAsDataURL(file); fileName = file.name; }"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center justify-center w-full h-48 border-2 border-dashed rounded-lg transition-colors
                                    border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-500 dark:bg-gray-800 overflow-hidden">
                                    <template x-if="!preview">
                                        <div class="text-center p-4">
                                            <svg class="mx-auto h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                                <span class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500">Click to upload</span>
                                                or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                                        </div>
                                    </template>
                                    <template x-if="preview">
                                        <div class="relative group p-2">
                                            <img :src="preview"
                                                class="h-32 w-auto max-w-full rounded-lg object-contain shadow-sm">
                                            <div class="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                <button type="button" @click.stop="preview = null; fileName = ''; $refs.thumbnailInput.value = ''"
                                                    class="bg-red-500 text-white rounded-full p-1.5 hover:bg-red-600 shadow-md">
                                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </div>
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

    @push('scripts')
    <script>
        window.createEasyMDE = null;
        window.editEasyMDE = null;

        window.initCreateEditor = function() {
            const textarea = document.getElementById('body-editor');
            if (!textarea || window.createEasyMDE) return;

            window.createEasyMDE = new EasyMDE({
                element: textarea,
                spellChecker: false,
                placeholder: 'Write your post in markdown...',
                status: false,
                toolbar: ['bold', 'italic', 'heading', '|', 'quote', 'code', 'code-block', '|', 'unordered-list', 'ordered-list', '|', 'link', '|', 'preview', 'side-by-side', 'fullscreen'],
                sideBySideFullspace: false,
            });
        };

        window.initEditEditor = function(content) {
            const textarea = document.getElementById('body-editor-edit');
            if (!textarea) return;

            if (window.editEasyMDE) {
                try {
                    window.editEasyMDE.toTextArea();
                } catch (e) {}
                window.editEasyMDE = null;
            }

            textarea.value = content || '';
            window.editEasyMDE = new EasyMDE({
                element: textarea,
                spellChecker: false,
                placeholder: 'Write your post in markdown...',
                status: false,
                toolbar: ['bold', 'italic', 'heading', '|', 'quote', 'code', 'code-block', '|', 'unordered-list', 'ordered-list', '|', 'link', '|', 'preview', 'side-by-side', 'fullscreen'],
                sideBySideFullspace: false,
            });

            window.editEasyMDE.codemirror.on('change', () => {
                textarea.value = window.editEasyMDE.value();
                textarea.dispatchEvent(new Event('input'));
            });
        };

        const registerDateTimePicker = () => {
            Alpine.data('dateTimePicker', (initialValue) => ({
                value: initialValue || '',
                date: '',
                hour: '00',
                selectedMinute: '00',
                showPicker: false,
                init() {
                    if (this.value) {
                        const d = new Date(this.value.replace(' ', 'T'));
                        if (!isNaN(d.getTime())) {
                            const year = d.getFullYear();
                            const month = (d.getMonth() + 1).toString().padStart(2, '0');
                            const day = d.getDate().toString().padStart(2, '0');
                            this.date = `${year}-${month}-${day}`;
                            this.hour = d.getHours().toString().padStart(2, '0');
                            this.selectedMinute = d.getMinutes().toString().padStart(2, '0');
                        }
                    }
                    this.$watch('date', () => this.updateValue());
                    this.$watch('hour', () => this.updateValue());
                    this.$watch('selectedMinute', () => this.updateValue());
                },
                updateValue() {
                    if (this.date) {
                        this.value = `${this.date} ${this.hour}:${this.selectedMinute}`;
                    } else {
                        this.value = '';
                    }
                },
                get displayValue() {
                    if (!this.value || !this.date) return 'Draft (Immediate)';
                    const d = new Date(this.date + 'T' + this.hour + ':' + this.selectedMinute);
                    if (isNaN(d.getTime())) return 'Draft (Immediate)';
                    return d.toLocaleDateString([], {
                        year: 'numeric',
                        month: 'short',
                        day: 'numeric'
                    }) + ' ' + this.hour + ':' + this.selectedMinute;
                },
                selectHour(h) {
                    this.hour = h.toString().padStart(2, '0');
                },
                selectMinute(m) {
                    this.selectedMinute = m.toString().padStart(2, '0');
                },
                clear() {
                    this.date = '';
                    this.value = '';
                    this.showPicker = false;
                }
            }));
        };

        if (typeof Alpine !== 'undefined' && Alpine.data) {
            registerDateTimePicker();
        } else {
            document.addEventListener('alpine:init', registerDateTimePicker);
        }

        (function() {
            document.addEventListener('DOMContentLoaded', function() {
                window.initCreateEditor();

                const createForm = document.getElementById('create-post-form');
                if (createForm) {
                    createForm.addEventListener('submit', function() {
                        if (window.createEasyMDE) {
                            const area = document.getElementById('body-editor');
                            if (area) area.value = window.createEasyMDE.value();
                        }
                    });
                }

                const editForm = document.getElementById('edit-post-form');
                if (editForm) {
                    editForm.addEventListener('submit', function() {
                        if (window.editEasyMDE) {
                            const area = document.getElementById('body-editor-edit');
                            if (area) area.value = window.editEasyMDE.value();
                        }
                    });
                }

                const editObserver = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'style') {
                            const target = mutation.target;
                            if (target.style.display !== 'none' && target.getAttribute('x-show') === 'showEdit') {
                                const rootEl = document.querySelector('[x-data]');
                                if (rootEl && window.Alpine) {
                                    const rootData = window.Alpine.$data(rootEl);
                                    if (rootData && rootData.editPost) {
                                        setTimeout(() => window.initEditEditor(rootData.editPost.body), 50);
                                    }
                                }
                            }
                        }
                    });
                });

                const editDialog = document.querySelector('[x-show="showEdit"]');
                if (editDialog) {
                    editObserver.observe(editDialog, {
                        attributes: true
                    });
                    if (editDialog.style.display !== 'none') {
                        const rootEl = document.querySelector('[x-data]');
                        if (rootEl && window.Alpine) {
                            const rootData = window.Alpine.$data(rootEl);
                            if (rootData && rootData.editPost) {
                                setTimeout(() => window.initEditEditor(rootData.editPost.body), 100);
                            }
                        }
                    }
                }
            });
        })();
    </script>
    @endpush
</x-layouts.admin>
