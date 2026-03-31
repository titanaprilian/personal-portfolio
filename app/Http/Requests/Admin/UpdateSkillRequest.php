<?php

namespace App\Http\Requests\Admin;

use App\Helpers\TailwindColors;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSkillRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $validColors = array_keys(TailwindColors::getColorOptions());

        return [
            'name' => ['required', 'string', 'max:100'],
            'skill_category_id' => ['required', 'exists:skill_categories,id'],
            'proficiency' => ['required', 'integer', 'min:0', 'max:100'],
            'icon' => ['nullable', 'string', 'max:100'],
            'icon_color' => ['nullable', 'string', Rule::in($validColors)],
        ];
    }
}
