<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use League\CommonMark\CommonMarkConverter;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'body',
        'thumbnail',
        'demo_url',
        'github_url',
        'featured_order',
        'order',
    ];

    protected function casts(): array
    {
        return [
            'featured_order' => 'integer',
            'order' => 'integer',
        ];
    }

    public function scopeFeatured($query)
    {
        return $query->whereNotNull('featured_order')->orderBy('featured_order');
    }

    public static function getNextOrder(): int
    {
        $maxOrder = static::whereNull('featured_order')->max('order');

        return ($maxOrder ?? -1) + 1;
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProjectCategory::class, 'project_category', 'project_id', 'category_id');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ProjectTag::class, 'project_tag', 'project_id', 'tag_id');
    }

    public function getBodyHtmlAttribute(): string
    {
        if (empty($this->body)) {
            return '';
        }

        $converter = new CommonMarkConverter([
            'html_input' => 'strip',
            'allow_unsafe_links' => false,
        ]);

        return $converter->convert($this->body);
    }
}
