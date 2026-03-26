<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePostOrder implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $postId = request()->route('post')?->id;

        $exists = \App\Models\Post::where('order', $value)
            ->when($postId, fn ($q) => $q->where('id', '!=', $postId))
            ->exists();

        if ($exists) {
            $fail('This order is already used by another post.');
        }
    }
}
