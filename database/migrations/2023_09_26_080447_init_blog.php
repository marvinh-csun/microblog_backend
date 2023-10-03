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
        // Command To Create this file 
        // ./vendor/bin/sail artisan make:migration init_blog

        Schema::create("blogs", function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string("title", 512);
            $table->string("slug", 1024);
            $table->string("description", 2048);
            $table->text("body");
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create("blog_recommendations", function(Blueprint $table){
            $table->unsignedBigInteger("parent_blog_id");
            $table->foreign("parent_blog_id")->references('id')->on('blogs')->onDelete('cascade');
            $table->unsignedBigInteger("child_blog_id");
            $table->foreign("child_blog_id")->references('id')->on('blogs')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create("comments", function(Blueprint $table){
            $table->bigIncrements('id');
            $table->string("comment", 2048);
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references('id')->on("users");
            $table->unsignedBigInteger("parent_id")->nullable();
            $table->timestamps();
            $table->unsignedBigInteger('blog_id');
            $table->foreign("blog_id")->references('id')->on('blogs')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
