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
        Schema::create('website_contents', function (Blueprint $table) {
            $table->id();
            $table->string('theme', 50)->default('default');
            $table->string('page', 50);
            $table->string('section', 100);
            $table->string('key', 100);
            $table->longText('value')->nullable();
            $table->string('type')->default('text');
            $table->string('label')->nullable();
            $table->timestamps();

            $table->unique(['theme', 'page', 'section', 'key'], 'wc_theme_page_sec_key_unique');
            $table->index(['theme', 'page'], 'wc_theme_page_index');
            $table->index('page');
            $table->index('section');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_contents');
    }
};
