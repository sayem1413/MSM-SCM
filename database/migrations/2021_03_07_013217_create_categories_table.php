<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 200);
            $table->text('description', 2000)->nullable();
            $table->nestedSet();
            $table->string('image_path')->nullable();
            $table->boolean('active')->default(0);

            $table->string('seo_url', 200)->nullable();
            $table->string('meta_keyword', 500)->nullable();
            $table->string('meta_description', 1000)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
