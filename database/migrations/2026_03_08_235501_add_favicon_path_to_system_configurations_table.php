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
        if (! Schema::hasTable('system_configurations')) {
            return;
        }

        Schema::table('system_configurations', function (Blueprint $table) {
            $table->string('favicon_path')->nullable()->after('logo_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('system_configurations')) {
            return;
        }

        Schema::table('system_configurations', function (Blueprint $table) {
            $table->dropColumn('favicon_path');
        });
    }
};
