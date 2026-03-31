<x-layouts.admin title="Resume">
    <div x-data="{
        showUpload: {{ $errors->any() ? 'true' : 'false' }},
        showDelete: false,
        deleteResume: null,
        previewUrl: null,
        previewReady: false,
        uploadFile: null,
        uploadFileName: '',
        submittingUpload: false,
        submittingDelete: false,
    }">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-xl font-semibold text-gray-800 dark:text-gray-100">Resume</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Manage your resume versions. Only one can be active at a time.
                </p>
            </div>
            <button
                type="button"
                @click="showUpload = true"
                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium transition-colors">
                + Upload New Resume
            </button>
        </div>

        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition
                 class="mb-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 px-4 py-3 text-sm text-green-700 dark:text-green-400">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 x-transition
                 class="mb-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-700 dark:text-red-400">
                {{ session('error') }}
            </div>
        @endif

        @forelse($resumes as $resume)
            <div class="flex gap-4 p-4 rounded-xl border
                {{ $resume->is_active
                    ? 'border-indigo-300 dark:border-indigo-700 bg-indigo-50/50 dark:bg-indigo-900/10'
                    : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900' }}
                mb-4 transition-colors">
                <div class="flex-shrink-0 w-32 h-44 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 relative group">
                    <iframe
                        src="{{ Storage::url($resume->file_path) }}#toolbar=0&navpanes=0&scrollbar=0&view=FitH"
                        class="w-full h-full pointer-events-none scale-[0.5] origin-top-left"
                        style="width: 200%; height: 200%;"
                        loading="lazy"
                        title="{{ $resume->label }}"
                    ></iframe>
                    <a href="{{ Storage::url($resume->file_path) }}" target="_blank" class="absolute inset-0 flex items-center justify-center bg-black/0 hover:bg-black/30 transition-colors group">
                        <span class="opacity-0 group-hover:opacity-100 text-white text-xs font-medium bg-black/60 px-2 py-1 rounded transition-opacity">View PDF</span>
                    </a>
                </div>
                <div class="flex-1 min-w-0 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center gap-2 flex-wrap">
                            <h3 class="font-semibold text-gray-800 dark:text-gray-100 text-sm">{{ $resume->label }}</h3>
                            @if($resume->is_active)
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900/40 dark:text-indigo-300">
                                    ✓ Active
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                            Uploaded {{ $resume->created_at->diffForHumans() }} · {{ $resume->created_at->format('M d, Y') }}
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                            <a href="{{ Storage::url($resume->file_path) }}" target="_blank" class="hover:text-indigo-500 underline underline-offset-2">
                                {{ basename($resume->file_path) }}
                            </a>
                        </p>
                    </div>
                    <div class="flex items-center gap-2 flex-wrap mt-3">
                        @if(!$resume->is_active)
                            <form method="POST" action="{{ route('admin.resume.setActive', $resume) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg border border-indigo-300 dark:border-indigo-700 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 transition-colors">
                                    Set as Active
                                </button>
                            </form>
                        @else
                            <span class="text-xs text-gray-400 dark:text-gray-500 italic">Currently active — visible on your portfolio</span>
                        @endif
                        <a href="{{ Storage::url($resume->file_path) }}" download="{{ Str::slug($resume->label) }}.pdf" class="text-xs px-3 py-1.5 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            ↓ Download
                        </a>
                        @if(!$resume->is_active)
                            <button type="button" @click="showDelete = true; deleteResume = @js($resume->only(['id', 'label']))" class="text-xs px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-800 text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                Delete
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center py-20 text-center rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700">
                <div class="w-12 h-12 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                </div>
                <p class="text-sm text-gray-400 dark:text-gray-500 mb-3">No resumes uploaded yet.</p>
                <button @click="showUpload = true" class="text-sm text-indigo-600 dark:text-indigo-400 hover:underline">Upload your first resume →</button>
            </div>
        @endforelse

        <x-admin.dialog :open="'showUpload'" title="Upload New Resume" :close="'showUpload = false; previewUrl = null; previewReady = false; uploadFileName = \'\''" max-width="max-w-2xl">
            <form method="POST" action="{{ route('admin.resume.store') }}" enctype="multipart/form-data" x-data @submit.prevent="if (!uploadFile) { alert('Please select a PDF file.'); return; } submittingUpload = true; $el.submit();">
                @csrf
                <div x-show="!previewUrl">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Label <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="label" value="{{ old('label') }}" placeholder="e.g. Resume v3 – Full Stack, March 2026" maxlength="100" required class="w-full rounded-lg border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-3 py-2 text-sm text-gray-900 dark:text-gray-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                        @error('label')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="relative flex flex-col items-center justify-center rounded-xl border-2 border-dashed border-gray-200 dark:border-gray-700 p-8 text-center hover:border-indigo-400 transition-colors cursor-pointer" @click="$refs.pdfInput.click()" @dragover.prevent @drop.prevent="const file = $event.dataTransfer.files[0]; if (file && file.type === 'application/pdf') { $refs.pdfInput.files = $event.dataTransfer.files; previewUrl = URL.createObjectURL(file); uploadFileName = file.name; uploadFile = file; }">
                        <svg class="w-10 h-10 text-gray-300 dark:text-gray-600 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                        </svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <span class="text-indigo-600 dark:text-indigo-400 font-medium">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">PDF only · Max 5MB</p>
                        <template x-if="uploadFileName">
                            <p class="text-xs text-indigo-600 dark:text-indigo-400 mt-2 font-medium" x-text="uploadFileName"></p>
                        </template>
                    </div>
                    <input type="file" name="resume_file" accept="application/pdf" x-ref="pdfInput" class="hidden" @change="const file = $event.target.files[0]; if (!file) return; if (file.size > 5 * 1024 * 1024) { alert('File size must not exceed 5MB.'); $event.target.value = ''; return; } previewUrl = URL.createObjectURL(file); uploadFileName = file.name; uploadFile = file;" />
                    @error('resume_file')
                        <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div x-show="previewUrl">
                    <div class="mb-3 flex items-center justify-between">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Preview your resume before uploading:</p>
                        <button type="button" @click="previewUrl = null; uploadFileName = ''" class="text-xs text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">← Change file</button>
                    </div>
                    <div class="rounded-lg overflow-hidden border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-800 h-96">
                        <iframe :src="previewUrl" class="w-full h-full" title="PDF Preview" @load="previewReady = true"></iframe>
                        <div x-show="!previewReady" class="w-full h-full flex items-center justify-center">
                            <p class="text-sm text-gray-400 animate-pulse">Loading preview...</p>
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 text-center"><span x-text="uploadFileName"></span></p>
                </div>
                <div class="flex justify-between items-center mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button type="button" @click="showUpload = false; previewUrl = null; previewReady = false; uploadFileName = ''" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                    <div class="flex gap-2">
                        <button x-show="!previewUrl" type="submit" :disabled="submittingUpload" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white text-sm font-medium transition-colors disabled:cursor-not-allowed flex items-center gap-2">
                            <span x-show="!submittingUpload">Upload Resume</span>
                            <span x-show="submittingUpload" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Uploading...
                            </span>
                        </button>
                        <button x-show="previewUrl" type="submit" :disabled="submittingUpload" class="px-4 py-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 disabled:bg-indigo-400 text-white text-sm font-medium transition-colors disabled:cursor-not-allowed flex items-center gap-2">
                            <span x-show="!submittingUpload">Confirm & Upload</span>
                            <span x-show="submittingUpload" class="flex items-center gap-2">
                                <svg class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                                </svg>
                                Uploading...
                            </span>
                        </button>
                    </div>
                </div>
            </form>
        </x-admin.dialog>

        <x-admin.dialog :open="'showDelete'" title="Delete Resume" :close="'showDelete = false; deleteResume = null'" max-width="max-w-md">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Are you sure you want to permanently delete
                <span class="font-semibold text-gray-800 dark:text-gray-200" x-text="deleteResume?.label"></span>?
                The PDF file will be removed from storage. This cannot be undone.
            </p>
            <form method="POST" :action="`/admin/resume/${deleteResume?.id}`" class="mt-6" @submit="submittingDelete = true">
                @csrf
                @method('DELETE')
                <div class="flex justify-end gap-3">
                    <button type="button" @click="showDelete = false; deleteResume = null" class="text-sm text-gray-500 hover:text-gray-700 dark:hover:text-gray-300">Cancel</button>
                    <button type="submit" :disabled="submittingDelete" class="bg-red-600 hover:bg-red-700 disabled:bg-red-400 text-white px-4 py-2 rounded-lg text-sm transition-colors disabled:cursor-not-allowed flex items-center gap-2">
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
