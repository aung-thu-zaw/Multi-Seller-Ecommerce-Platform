<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId("parent_id")->nullable()->references("id")->on("blog_categories")->cascadeOnDelete();
            $table->string("name")->unique();
            $table->string("slug")->unique();
            $table->string("image")->nullable();
            $table->enum("status", ["show","hide"])->default("show");
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('blog_categories');
    }
};
