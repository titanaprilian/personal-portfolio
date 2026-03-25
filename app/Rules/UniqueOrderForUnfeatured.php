<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueOrderForUnfeatured implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $featuredOrder = request()->input('featured_order');

        if ($featuredOrder !== null && $featuredOrder !== '') {
            return;
        }

        $projectId = request()->route('project')?->id;

        $exists = Project::where('order', $value)
            ->whereNull('featured_order')
            ->when($projectId, fn ($q) => $q->where('id', '!=', $projectId))
            ->exists();

        if ($exists) {
            $fail('This order is already used by another unfeatured project.');
        }
    }
}
