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
        Schema::table('footer_main', function (Blueprint $table) {
            $table->string('copyright_year')->default('2024')->after('location2_text');
            $table->string('copyright_text')->default('Red-Labs')->after('copyright_year');
            $table->string('powered_by_text')->default('Red Engineers')->after('copyright_text');
            $table->string('powered_by_link')->default('https://redengineers.com.au/')->after('powered_by_text');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_main', function (Blueprint $table) {
            $table->dropColumn(['copyright_year', 'copyright_text', 'powered_by_text', 'powered_by_link']);
        });
    }
};
