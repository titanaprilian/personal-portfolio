@props(['name', 'value' => '', 'placeholder' => 'Write something...'])

<div>
    <textarea 
        name="{{ $name }}" 
        placeholder="{{ $placeholder }}"
        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:border-indigo-500 focus:ring-indigo-500"
        rows="10"
    >{{ $value }}</textarea>
</div>
