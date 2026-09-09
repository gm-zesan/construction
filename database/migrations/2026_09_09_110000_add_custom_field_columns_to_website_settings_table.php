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
        Schema::table('website_settings', function (Blueprint $table) {
            $table->string('label')->nullable()->after('key');
            $table->string('placeholder')->nullable()->after('type');
            $table->string('col_class')->nullable()->default('col-md-6 col-12')->after('group');
            $table->boolean('is_custom')->default(false)->after('col_class');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('website_settings', function (Blueprint $table) {
            $table->dropColumn(['label', 'placeholder', 'col_class', 'is_custom']);
        });
    }
};
