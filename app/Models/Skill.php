<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'skill_category_id',
        'proficiency',
        'icon',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'proficiency' => 'integer',
            'order' => 'integer',
        ];
    }

    public function skillCategory(): BelongsTo
    {
        return $this->belongsTo(SkillCategory::class);
    }
}
