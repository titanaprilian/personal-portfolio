@props(['project' => null, 'categories', 'tags', 'formId', 'occupiedSlots' => []])

@php
    $categoryNameMap = $categories->pluck('name', 'id')->toJson();
    $tagNameMap = $tags->pluck('name', 'id')->toJson();
    $currentSlot = $project?->featured_order ?? null;
    $filteredSlots = array_filter([1, 2, 3], fn($slot) => !in_array($slot, $occupiedSlots) || $slot === $currentSlot);
    $hasHiddenSlots = count($filteredSlots) < 3;
@endphp

<div x-data="{
    title: '{{ old('title', $project?->title ?? '') }}',
    slug: '{{ old('slug', $project?->slug ?? '') }}',
    description: '{{ old('description', $project?->description ?? '') }}',
    featuredOrder: {{ json_encode(old('featured_order', $project?->featured_order ?? null)) }},
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
            <textarea name="body" id="body-editor" x-data
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
                rows="4">{{ old('body', $project?->body ?? '') }}</textarea>
            @error('body')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

@push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const easyMDE = new EasyMDE({
                    element: document.getElementById('body-editor'),
                    spellChecker: false,
                    placeholder: 'Write your project details in markdown...',
                    status: false,
                    toolbar: ['bold', 'italic', 'heading', '|', 'quote', 'code', 'code-block', '|', 'unordered-list', 'ordered-list', '|', 'link', '|', 'preview', 'side-by-side', 'fullscreen'],
                    sideBySideFullspace: false,
                });

                const form = document.getElementById('{{ $formId }}');
                if (form) {
                    form.addEventListener('submit', function() {
                        const simpleMDE = document.querySelector('.editor-wrapper');
                        const textarea = document.getElementById('body-editor');
                        if (textarea && textarea.value) {
                            textarea.value = easyMDE.value();
                        }
                    });
                }
            });
        </script>
        @endpush

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
            <div x-data="{ preview: '{{ $project?->thumbnail ? asset('storage/' . $project->thumbnail) : '' }}', fileName: '' }">
                <div class="relative">
                    <input type="file" name="thumbnail" accept="image/jpg,image/jpeg,image/png,image/webp"
                        @change="const file = $event.target.files[0]; if (file && file.size > 2 * 1024 * 1024) { alert('File size must not exceed 2MB.'); $event.target.value = ''; preview = ''; fileName = ''; return; } if (file) { preview = URL.createObjectURL(file); fileName = file.name; }"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                    <div class="flex items-center justify-center w-full h-32 border-2 border-dashed rounded-lg transition-colors
                        {{ $project?->thumbnail ? 'border-gray-300 dark:border-gray-600' : 'border-gray-300 dark:border-gray-600 hover:border-indigo-500 dark:hover:border-indigo-500' }}
                        dark:bg-gray-800">
                        <template x-if="!preview">
                            <div class="text-center p-4">
                                <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-medium text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 dark:hover:text-indigo-300">Click to upload</span>
                                    or drag and drop
                                </p>
                                <p class="text-xs text-gray-400 mt-1">JPG, PNG, WEBP · Max 2MB</p>
                            </div>
                        </template>
                    </div>
                </div>
                <template x-if="preview">
                    <div class="relative mt-2 group">
                        <img :src="preview" class="h-32 w-auto rounded-lg object-cover border border-gray-200 dark:border-gray-700">
                        <button type="button" @click="preview = ''; fileName = ''; $refs.fileInput.value = ''"
                            class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity hover:bg-red-600">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </template>
                <input type="file" x-ref="fileInput" style="display: none;">
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

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Featured Slot</label>
            <select name="featured_order" x-model="featuredOrder"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500">
                <option value="">None</option>
                @if(in_array(1, $filteredSlots))
                    <option value="1" {{ old('featured_order', $project?->featured_order ?? '') == 1 ? 'selected' : '' }}>Slot 1 (Primary)</option>
                @endif
                @if(in_array(2, $filteredSlots))
                    <option value="2" {{ old('featured_order', $project?->featured_order ?? '') == 2 ? 'selected' : '' }}>Slot 2</option>
                @endif
                @if(in_array(3, $filteredSlots))
                    <option value="3" {{ old('featured_order', $project?->featured_order ?? '') == 3 ? 'selected' : '' }}>Slot 3</option>
                @endif
            </select>
            @if($hasHiddenSlots && count($filteredSlots) === 0)
                <p class="text-xs text-amber-600 dark:text-amber-400 mt-1">All featured slots are taken. Remove a featured project first or set a featured project's slot to none.</p>
            @elseif($hasHiddenSlots)
                <p class="text-xs text-gray-400 mt-1">Other slots are already assigned to other projects.</p>
            @else
                <p class="text-xs text-gray-400 mt-1">Max 3 featured projects allowed</p>
            @endif
            <p class="text-xs text-gray-400 mt-1">Use inline order field in the list to reorder unfeatured projects.</p>
            @error('featured_order')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>
    </div>
</div>
