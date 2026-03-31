<?php

namespace App\Helpers;

class TailwindColors
{
    public static function getHex(string $colorName): ?string
    {
        $colors = [
            'slate' => '#64748b', 'gray' => '#6b7280', 'zinc' => '#71717a', 'neutral' => '#737373',
            'stone' => '#78716c', 'red' => '#dc2626', 'orange' => '#ea580c', 'amber' => '#d97706',
            'yellow' => '#ca8a04', 'lime' => '#65a30d', 'green' => '#16a34a', 'emerald' => '#059669',
            'teal' => '#0d9488', 'cyan' => '#0891b2', 'sky' => '#0284c7', 'blue' => '#2563eb',
            'indigo' => '#4f46e5', 'violet' => '#7c3aed', 'purple' => '#9333ea', 'fuchsia' => '#c026d3',
            'pink' => '#db2777', 'rose' => '#e11d48', 'white' => '#ffffff',
        ];

        return $colors[$colorName] ?? null;
    }

    public static function getColorOptions(): array
    {
        return [
            'red' => '#ef4444',
            'orange' => '#f97316',
            'amber' => '#f59e0b',
            'yellow' => '#eab308',
            'lime' => '#84cc16',
            'green' => '#22c55e',
            'emerald' => '#10b981',
            'teal' => '#14b8a6',
            'cyan' => '#06b6d4',
            'sky' => '#0ea5e9',
            'blue' => '#3b82f6',
            'indigo' => '#6366f1',
            'violet' => '#8b5cf6',
            'purple' => '#a855f7',
            'fuchsia' => '#d946ef',
            'pink' => '#ec4899',
            'rose' => '#f43f5e',
            'white' => '#ffffff',
        ];
    }
}
