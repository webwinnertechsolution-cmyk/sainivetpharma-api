<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Table 1: blog_blog_category
        Schema::create('blog_blog_category', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('blog_category_id');
            
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('blog_category_id')->references('id')->on('blog_categories')->onDelete('cascade');
            
            $table->primary(['blog_id', 'blog_category_id']);
        });

        // Table 2: blog_blog_tag
        Schema::create('blog_blog_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('blog_id');
            $table->unsignedBigInteger('blog_tag_id');
            
            $table->foreign('blog_id')->references('id')->on('blogs')->onDelete('cascade');
            $table->foreign('blog_tag_id')->references('id')->on('blog_tags')->onDelete('cascade');
            
            $table->primary(['blog_id', 'blog_tag_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('blog_blog_tag');
        Schema::dropIfExists('blog_blog_category');
    }
};
