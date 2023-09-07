<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_cards', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("product_id")->constrained("products");
            $table->integer("quantity");
            $table->float("total_price");
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
        Schema::dropIfExists('shopping_cards');
    }
}
