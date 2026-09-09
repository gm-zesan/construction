<?php

namespace Database\Seeders;

use App\Models\WebsiteSetting;
use Illuminate\Database\Seeder;

class WebsiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // 1. General Group
            [
                'key' => 'company_name',
                'value' => 'COMPANY NAME',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'company_tagline',
                'value' => 'Architectural Precision & Engineering Excellence',
                'type' => 'text',
                'group' => 'general',
            ],
            [
                'key' => 'site_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'site_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],

            // 2. Contact Group
            [
                'key' => 'primary_phone',
                'value' => '+1 (800) 555-0199',
                'type' => 'phone',
                'group' => 'contact',
            ],
            [
                'key' => 'primary_email',
                'value' => 'info@example.com',
                'type' => 'email',
                'group' => 'contact',
            ],
            [
                'key' => 'whatsapp_number',
                'value' => '+1 (800) 555-0199',
                'type' => 'phone',
                'group' => 'contact',
            ],
            [
                'key' => 'office_address',
                'value' => 'Industrial Park Suite 400, Seattle, WA 98101',
                'type' => 'textarea',
                'group' => 'contact',
            ],
            [
                'key' => 'google_maps_url',
                'value' => 'https://maps.google.com',
                'type' => 'url',
                'group' => 'contact',
            ],

            // 3. Social Media Group
            [
                'key' => 'facebook_url',
                'value' => 'https://facebook.com',
                'type' => 'url',
                'group' => 'social',
            ],
            [
                'key' => 'instagram_url',
                'value' => 'https://instagram.com',
                'type' => 'url',
                'group' => 'social',
            ],
            [
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com',
                'type' => 'url',
                'group' => 'social',
            ],
            [
                'key' => 'youtube_url',
                'value' => 'https://youtube.com',
                'type' => 'url',
                'group' => 'social',
            ],

            // 4. Business Information Group
            [
                'key' => 'office_hours',
                'value' => 'Mon - Fri: 07:00 AM - 06:00 PM',
                'type' => 'text',
                'group' => 'business',
            ],
            [
                'key' => 'copyright_text',
                'value' => '© 2026 COMPANY NAME. All Rights Reserved.',
                'type' => 'text',
                'group' => 'business',
            ],
        ];

        foreach ($settings as $setting) {
            WebsiteSetting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'],
                    'group' => $setting['group'],
                ]
            );
        }
    }
}
