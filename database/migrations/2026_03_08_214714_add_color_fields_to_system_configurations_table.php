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
        Schema::table('system_configurations', function (Blueprint $table) {
            $table->string('tertiary_color')->nullable()->after('secondary_color');
            $table->string('button_color')->nullable()->after('text_color');
            $table->string('button_text_color')->nullable()->after('button_color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_configurations', function (Blueprint $table) {
            $table->dropColumn(['tertiary_color', 'button_color', 'button_text_color']);
        });
    }
};
