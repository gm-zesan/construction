<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WebsiteContentSeeder extends Seeder
{
    /**
     * Run all theme-scoped website content seeders.
     */
    public function run(): void
    {
        $this->call([
            DefaultThemeContentSeeder::class,
            ApexDarkThemeContentSeeder::class,
        ]);
    }
}
