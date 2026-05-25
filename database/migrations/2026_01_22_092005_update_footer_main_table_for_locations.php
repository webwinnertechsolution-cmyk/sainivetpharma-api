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
            // Drop old columns
            $table->dropColumn(['image1', 'text1', 'image2', 'text2', 'description']);
            
            // Add new location columns
            $table->string('location1_icon', 100)->after('id');
            $table->text('location1_text')->after('location1_icon');
            $table->string('location2_icon', 100)->after('location1_text');
            $table->text('location2_text')->after('location2_icon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('footer_main', function (Blueprint $table) {
            // Drop new columns
            $table->dropColumn(['location1_icon', 'location1_text', 'location2_icon', 'location2_text']);
            
            // Restore old columns
            $table->string('image1')->after('id');
            $table->string('text1')->after('image1');
            $table->string('image2')->after('text1');
            $table->string('text2')->after('image2');
            $table->text('description')->after('text2');
        });
    }
};
