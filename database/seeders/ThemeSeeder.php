<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Classic Dark',
                'slug' => 'classic-dark',
                'description' => 'Dark neon portfolio with bold sections and typed headlines.',
                'view_path' => 'themes.classic-dark.show',
                'is_active' => true,
            ],
            [
                'name' => 'Aurora Depth',
                'slug' => 'modern-light',
                'description' => 'Immersive 3D glass panels, floating hero stage, and cyan depth.',
                'view_path' => 'themes.modern-light.show',
                'is_active' => true,
            ],
            [
                'name' => 'Studio Orbit',
                'slug' => 'minimal-pro',
                'description' => 'Isometric 3D slabs, bold typography, and high-impact modern layout.',
                'view_path' => 'themes.minimal-pro.show',
                'is_active' => true,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::updateOrCreate(['slug' => $theme['slug']], $theme);
        }
    }
}
