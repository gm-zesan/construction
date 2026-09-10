<?php

namespace Database\Seeders;

use App\Models\Theme;
use Illuminate\Database\Seeder;

class ThemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $themes = [
            [
                'name' => 'Default Industrial',
                'slug' => 'default',
                'directory' => 'default',
                'description' => 'Industrial & modern bold construction theme with high-contrast dark palette, dynamic orange accents, and full parallax/scroll interactions.',
                'preview_image' => 'images/themes/default-preview.jpg',
                'author' => 'Engineered Themes',
                'version' => '1.0.0',
                'is_active' => true,
                'settings' => [
                    'primary_color' => '#f95716',
                    'bg_color' => '#0b0f17',
                    'font_family' => 'Plus Jakarta Sans',
                ],
            ],
            [
                'name' => 'Apex Architectural Dark',
                'slug' => 'apex-dark',
                'directory' => 'apex-dark',
                'description' => 'Sleek luxury architectural aesthetic featuring clean grid geometry, frosted glass cards, streamlined navigation, and high-contrast typography.',
                'preview_image' => 'images/themes/apex-dark-preview.jpg',
                'author' => 'Engineered Themes',
                'version' => '1.1.0',
                'is_active' => false,
                'settings' => [
                    'primary_color' => '#f59e0b',
                    'bg_color' => '#090d16',
                    'font_family' => 'Plus Jakarta Sans',
                ],
            ],
        ];

        foreach ($themes as $themeData) {
            Theme::updateOrCreate(
                ['slug' => $themeData['slug']],
                $themeData
            );
        }
    }
}
