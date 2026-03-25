<?php

namespace App\Rules;

use App\Models\Project;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class FeaturedOrderLimit implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $existingCount = Project::whereNotNull('featured_order')->count();

        $projectId = request()->route('project')?->id;
        if ($projectId) {
            $currentProject = Project::find($projectId);
            if ($currentProject && $currentProject->featured_order !== null) {
                $existingCount--;
            }
        }

        if ($existingCount >= 3) {
            $fail('Only 3 projects can be featured at a time. Please remove a featured project first.');
        }

        $occupiedSlot = Project::where('featured_order', $value)
            ->when($projectId, fn ($q) => $q->where('id', '!=', $projectId))
            ->exists();

        if ($occupiedSlot) {
            $fail("Slot {$value} is already occupied by another project.");
        }
    }
}
