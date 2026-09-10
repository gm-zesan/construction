<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('website_contents', 'theme')) {
            Schema::table('website_contents', function (Blueprint $table) {
                $table->string('theme', 50)->default('default')->after('id');
                $table->string('page', 50)->change();
                $table->string('section', 100)->change();
                $table->string('key', 100)->change();
            });
        }

        // Drop legacy unique index if still present
        try {
            Schema::table('website_contents', function (Blueprint $table) {
                $table->dropUnique('website_contents_page_section_key_unique');
            });
        } catch (\Throwable $e) {
            // Index might not exist
        }

        // Ensure theme composite unique index exists
        try {
            Schema::table('website_contents', function (Blueprint $table) {
                $table->unique(['theme', 'page', 'section', 'key'], 'wc_theme_page_sec_key_unique');
                $table->index(['theme', 'page'], 'wc_theme_page_index');
            });
        } catch (\Throwable $e) {
            // Index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_contents', function (Blueprint $table) {
            try {
                $table->dropUnique('wc_theme_page_sec_key_unique');
                $table->dropIndex('wc_theme_page_index');
            } catch (\Throwable $e) {}

            if (Schema::hasColumn('website_contents', 'theme')) {
                $table->dropColumn('theme');
            }
        });
    }
};
