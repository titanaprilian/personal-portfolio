@props(['project' => null, 'categories', 'tags', 'formId'])

@php
    $categoryNameMap = $categories->pluck('name', 'id')->toJson();
    $tagNameMap = $tags->pluck('name', 'id')->toJson();
@endphp

<div x-data="{
    title: '{{ old('title', $project?->title ?? '') }}',
    slug: '{{ old('slug', $project?->slug ?? '') }}',
    description: '{{ old('description', $project?->description ?? '') }}',
    selectedCategories: {{ json_encode(old('category_ids', $project?->categories->pluck('id')->toArray() ?? [])) }},
    selectedTags: {{ json_encode(old('tag_ids', $project?->tags->pluck('id')->toArray() ?? [])) }},
}">

    <div class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title</label>
            <input type="text" name="title" x-model="title"
                @input="slug = title.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '')"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                required>
            @error('title')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Slug</label>
            <input type="text" name="slug" x-model="slug"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                required>
            @error('slug')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea name="description" x-model="description" maxlength="500"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                rows="2" required></textarea>
            <p class="text-xs text-gray-400 mt-1" x-text="description.length + '/500'"></p>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Body (Full Details)</label>
            <textarea name="body"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                rows="4">{{ old('body', $project?->body ?? '') }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Demo URL</label>
                <input type="url" name="demo_url" value="{{ old('demo_url', $project?->demo_url ?? '') }}"
                    placeholder="https://..."
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                @error('demo_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">GitHub URL</label>
                <input type="url" name="github_url" value="{{ old('github_url', $project?->github_url ?? '') }}"
                    placeholder="https://github.com/..."
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                @error('github_url')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Thumbnail</label>
            <div x-data="{ preview: '{{ $project?->thumbnail ? asset('storage/' . $project->thumbnail) : '' }}' }">
                <input type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                    @change="const file = $event.target.files[0]; if (file && file.size > 2 * 1024 * 1024) { alert('File size must not exceed 2MB.'); $event.target.value = ''; preview = ''; return; } if (file) preview = URL.createObjectURL(file);"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                <template x-if="preview">
                    <img :src="preview" class="mt-2 h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                </template>
                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
            </div>
            @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Categories</label>
            <div>
                <div class="flex flex-wrap gap-2 mb-2">
                    <template x-for="id in selectedCategories" :key="id">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                            <span x-text="{{ $categoryNameMap }}[id]"></span>
                            <button type="button" @click="selectedCategories = selectedCategories.filter(s => s !== id)">×</button>
                            <input type="hidden" name="category_ids[]" :value="id">
                        </span>
                    </template>
                </div>
                <select @change="if ($event.target.value && !selectedCategories.includes(Number($event.target.value))) { selectedCategories.push(Number($event.target.value)) } $event.target.value = ''"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">+ Add category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('category_ids')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('category_ids.*')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Tags</label>
            <div>
                <div class="flex flex-wrap gap-2 mb-2">
                    <template x-for="id in selectedTags" :key="id">
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                            <span x-text="{{ $tagNameMap }}[id]"></span>
                            <button type="button" @click="selectedTags = selectedTags.filter(s => s !== id)">×</button>
                            <input type="hidden" name="tag_ids[]" :value="id">
                        </span>
                    </template>
                </div>
                <select @change="if ($event.target.value && !selectedTags.includes(Number($event.target.value))) { selectedTags.push(Number($event.target.value)) } $event.target.value = ''"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">+ Add tag</option>
                    @foreach($tags as $tag)
                        <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                    @endforeach
                </select>
            </div>
            @error('tag_ids')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('tag_ids.*')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="featured" value="1" {{ old('featured', $project?->featured ?? false) ? 'checked' : '' }}
                        class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Mark as featured</span>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order</label>
                <input type="number" name="order" value="{{ old('order', $project?->order ?? 0) }}" min="0"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                @error('order')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>
</div>
