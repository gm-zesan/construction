<?php

namespace Database\Seeders;

use App\Models\WebsiteContent;
use Illuminate\Database\Seeder;

class ApexDarkThemeContentSeeder extends Seeder
{
    /**
     * Run the database seeds for Apex Architectural Dark Theme content.
     */
    public function run(): void
    {
        $contents = [
            // =========================================================================
            // APEX ARCHITECTURAL DARK THEME (theme = 'apex-dark')
            // =========================================================================

            // -------------------------------------------------------------------------
            // 1. PAGE: home
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Apex Luxury & Architectural Engineering',
                'type' => 'text',
                'label' => 'Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'headline',
                'value' => 'Engineering <span class="apex-gradient-text">Masterpieces</span> That Redefine Skylines.',
                'type' => 'text',
                'label' => 'Hero Headline',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'subheadline',
                'value' => 'From high-load commercial superstructures to precision parametric civic engineering, Apex delivers uncompromising build excellence and iconic architectural vision.',
                'type' => 'textarea',
                'label' => 'Hero Subheadline',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'primary_btn_text',
                'value' => 'Explore Portfolio',
                'type' => 'text',
                'label' => 'Primary Button Text',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'secondary_btn_text',
                'value' => 'Consult Engineers',
                'type' => 'text',
                'label' => 'Secondary Button Text',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'hero',
                'key' => 'stat_number',
                'value' => '99.8%',
                'type' => 'text',
                'label' => 'Safety & Precision Score',
            ],

            // --- Section: about_story ---
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'about_story',
                'key' => 'badge',
                'value' => 'The Apex Manifesto',
                'type' => 'text',
                'label' => 'Story Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'about_story',
                'key' => 'exp_years',
                'value' => '18',
                'type' => 'text',
                'label' => 'Years of Experience',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'about_story',
                'key' => 'description',
                'value' => 'Apex merges computational generative design, advanced concrete metallurgy, and hyper-accurate site supervision to turn daring concepts into resilient, monumental structures.',
                'type' => 'textarea',
                'label' => 'Story Description',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'about_story',
                'key' => 'btn_text',
                'value' => 'Discover Our Method',
                'type' => 'text',
                'label' => 'Story Button Text',
            ],

            // --- Section: experience ---
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'badge',
                'value' => 'Telemetry & Impact',
                'type' => 'text',
                'label' => 'Telemetry Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_1_count',
                'value' => '350',
                'type' => 'text',
                'label' => 'Delivered Projects Count',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_1_title',
                'value' => 'Superstructures Delivered',
                'type' => 'text',
                'label' => 'Delivered Projects Label',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_2_count',
                'value' => '100%',
                'type' => 'text',
                'label' => 'Seismic Compliance Percentage',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_2_title',
                'value' => 'Seismic & Wind Code Compliance',
                'type' => 'text',
                'label' => 'Compliance Label',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_3_count',
                'value' => '18',
                'type' => 'text',
                'label' => 'Years in Engineering',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_3_title',
                'value' => 'Years of Field Innovation',
                'type' => 'text',
                'label' => 'Field Innovation Label',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_4_count',
                'value' => '95+',
                'type' => 'text',
                'label' => 'Chartered Engineers Count',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'experience',
                'key' => 'stat_4_title',
                'value' => 'Chartered Structural Leads',
                'type' => 'text',
                'label' => 'Engineers Label',
            ],

            // --- Section: services ---
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'services',
                'key' => 'badge',
                'value' => 'Capabilities & Discipline',
                'type' => 'text',
                'label' => 'Services Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'services',
                'key' => 'title',
                'value' => 'Specialized Engineering & Ultra-Structure Disciplines',
                'type' => 'text',
                'label' => 'Services Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'services',
                'key' => 'subtitle',
                'value' => 'Parametric BIM coordination, advanced concrete metallurgy, and turnkey superstructure project management.',
                'type' => 'textarea',
                'label' => 'Services Subtitle',
            ],

            // --- Section: projects ---
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'projects',
                'key' => 'badge',
                'value' => 'Portfolio of Excellence',
                'type' => 'text',
                'label' => 'Projects Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'projects',
                'key' => 'title',
                'value' => 'Landmark Superstructures & Architectural Icons',
                'type' => 'text',
                'label' => 'Projects Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'home',
                'section' => 'projects',
                'key' => 'subtitle',
                'value' => 'Explore our signature collection of luxury towers, commercial hubs, and high-load industrial infrastructures.',
                'type' => 'textarea',
                'label' => 'Projects Subtitle',
            ],

            // -------------------------------------------------------------------------
            // 2. PAGE: about
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Corporate Dossier & Heritage',
                'type' => 'text',
                'label' => 'About Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'hero',
                'key' => 'title',
                'value' => 'Engineering the <span class="apex-gradient-text">Impossible</span> Since 2008.',
                'type' => 'text',
                'label' => 'About Hero Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'hero',
                'key' => 'subtitle',
                'value' => 'Apex is an international multidisciplinary construction and structural engineering enterprise specializing in monumental high-rises, civic infrastructures, and sustainable architectural frameworks.',
                'type' => 'textarea',
                'label' => 'About Hero Subtitle',
            ],

            // --- Section: story ---
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'story',
                'key' => 'exp_years',
                'value' => '18+',
                'type' => 'text',
                'label' => 'Story Experience Years',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'story',
                'key' => 'heading',
                'value' => 'Precision Physics & <span class="apex-gradient-text">Architectural Innovation</span>.',
                'type' => 'text',
                'label' => 'Story Heading',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'story',
                'key' => 'description',
                'value' => 'Founded by a consortium of visionary structural engineers and master architects, Apex has grown into an international powerhouse. We combine computational generative design, advanced concrete metallurgy, and hyper-accurate site supervision to turn daring concepts into resilient reality.',
                'type' => 'textarea',
                'label' => 'Story Full Description',
            ],

            // --- Section: leadership ---
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'leadership',
                'key' => 'title',
                'value' => 'Engineering Leadership & Directors',
                'type' => 'text',
                'label' => 'Leadership Section Title',
            ],

            // --- Section: accreditations ---
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'accreditations',
                'key' => 'title',
                'value' => 'Accreditations & Industry Honours',
                'type' => 'text',
                'label' => 'Accreditations Section Title',
            ],

            // --- Section: cta ---
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'cta',
                'key' => 'title',
                'value' => 'Partner With Apex on Your Next Landmark Build.',
                'type' => 'text',
                'label' => 'About CTA Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'about',
                'section' => 'cta',
                'key' => 'btn_text',
                'value' => 'Schedule Executive Consultation',
                'type' => 'text',
                'label' => 'About CTA Button Text',
            ],

            // -------------------------------------------------------------------------
            // 3. PAGE: projects
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'projects',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Landmark Portfolio',
                'type' => 'text',
                'label' => 'Projects Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'projects',
                'section' => 'hero',
                'key' => 'title',
                'value' => 'Masterpieces of <span class="apex-gradient-text">Structural Engineering</span>.',
                'type' => 'text',
                'label' => 'Projects Hero Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'projects',
                'section' => 'hero',
                'key' => 'subtitle',
                'value' => 'Explore our signature portfolio of commercial towers, civic superstructures, and industrial facilities delivered with zero deviance.',
                'type' => 'textarea',
                'label' => 'Projects Hero Subtitle',
            ],

            // -------------------------------------------------------------------------
            // 4. PAGE: articles
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'articles',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Engineering Journal & Insights',
                'type' => 'text',
                'label' => 'Articles Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'articles',
                'section' => 'hero',
                'key' => 'title',
                'value' => 'Material Science & <span class="apex-gradient-text">Site Intelligence</span>.',
                'type' => 'text',
                'label' => 'Articles Hero Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'articles',
                'section' => 'hero',
                'key' => 'subtitle',
                'value' => 'Technical publications, computational civil research, and site methodology reports from our practicing engineering leads.',
                'type' => 'textarea',
                'label' => 'Articles Hero Subtitle',
            ],

            // -------------------------------------------------------------------------
            // 5. PAGE: team
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'team',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Technical Directorate',
                'type' => 'text',
                'label' => 'Team Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'team',
                'section' => 'hero',
                'key' => 'title',
                'value' => 'Master Engineers & <span class="apex-gradient-text">Architectural Leads</span>.',
                'type' => 'text',
                'label' => 'Team Hero Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'team',
                'section' => 'hero',
                'key' => 'subtitle',
                'value' => 'Our multidisciplinary team of licensed structural engineers, geotechnical consultants, computational architects, and project directors.',
                'type' => 'textarea',
                'label' => 'Team Hero Subtitle',
            ],

            // -------------------------------------------------------------------------
            // 6. PAGE: contact
            // -------------------------------------------------------------------------
            // --- Section: hero ---
            [
                'theme' => 'apex-dark',
                'page' => 'contact',
                'section' => 'hero',
                'key' => 'badge',
                'value' => 'Executive Briefing & Inquiries',
                'type' => 'text',
                'label' => 'Contact Hero Badge',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'contact',
                'section' => 'hero',
                'key' => 'title',
                'value' => 'Initiate a <span class="apex-gradient-text">Confidential Briefing</span>.',
                'type' => 'text',
                'label' => 'Contact Hero Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'contact',
                'section' => 'hero',
                'key' => 'subtitle',
                'value' => 'Engage our technical partners and senior structural consultants for feasibility assessments, parametric audits, or comprehensive turnkey construction tenders.',
                'type' => 'textarea',
                'label' => 'Contact Hero Subtitle',
            ],

            // -------------------------------------------------------------------------
            // 7. PAGE: footer
            // -------------------------------------------------------------------------
            // --- Section: about ---
            [
                'theme' => 'apex-dark',
                'page' => 'footer',
                'section' => 'about',
                'key' => 'description',
                'value' => 'Delivering iconic commercial, industrial, and civil infrastructure with cutting-edge engineering precision.',
                'type' => 'textarea',
                'label' => 'Footer About Description',
            ],
            // --- Section: brand_bio ---
            [
                'theme' => 'apex-dark',
                'page' => 'footer',
                'section' => 'brand_bio',
                'key' => 'description',
                'value' => 'Apex is an elite architectural engineering and luxury infrastructure firm delivering monumental high-rises and sustainable structures worldwide.',
                'type' => 'textarea',
                'label' => 'Footer Brand Bio',
            ],
            // --- Section: cta ---
            [
                'theme' => 'apex-dark',
                'page' => 'footer',
                'section' => 'cta',
                'key' => 'title',
                'value' => 'Ready to Build an Iconic Structure?',
                'type' => 'text',
                'label' => 'Footer CTA Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'footer',
                'section' => 'cta',
                'key' => 'subtitle',
                'value' => 'Connect with our lead structural engineers and architectural directors for a confidential project review.',
                'type' => 'textarea',
                'label' => 'Footer CTA Subtitle',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'footer',
                'section' => 'cta',
                'key' => 'btn_text',
                'value' => 'Initiate Project Brief',
                'type' => 'text',
                'label' => 'Footer CTA Button Text',
            ],

            // -------------------------------------------------------------------------
            // 8. PAGE: seo
            // -------------------------------------------------------------------------
            // --- Section: meta ---
            [
                'theme' => 'apex-dark',
                'page' => 'seo',
                'section' => 'meta',
                'key' => 'meta_title',
                'value' => 'Apex Architectural Engineering — Luxury Construction & Modern Superstructures',
                'type' => 'text',
                'label' => 'Global Meta Title',
            ],
            [
                'theme' => 'apex-dark',
                'page' => 'seo',
                'section' => 'meta',
                'key' => 'meta_description',
                'value' => 'Apex is a global leader in high-rise architectural engineering, seismic-rated superstructure construction, and luxury turnkey development.',
                'type' => 'textarea',
                'label' => 'Global Meta Description',
            ],
        ];

        foreach ($contents as $content) {
            WebsiteContent::updateOrCreate(
                [
                    'theme' => 'apex-dark',
                    'page' => $content['page'],
                    'section' => $content['section'],
                    'key' => $content['key'],
                ],
                [
                    'value' => $content['value'],
                    'type' => $content['type'],
                    'label' => $content['label'] ?? null,
                ]
            );
        }

        WebsiteContent::clearPageCache(null, 'apex-dark');
    }
}
