<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string("code")->unique();
            $table->string("name");
            $table->string("image_path");
            $table->string("price");
            $table->string("quantity");
            $table->foreignId("brand_id")->constrained("brands");
            $table->foreignId("color_id")->constrained("colors");
            $table->foreignId("category_id")->constrained("categories");
            $table->string("note")->nullable();
            $table->enum("gender", ["male", "female", "male-female"]);
            $table->string("origin")->nullable();
            $table->string("function")->nullable();
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
        Schema::dropIfExists('products');
    }
}
