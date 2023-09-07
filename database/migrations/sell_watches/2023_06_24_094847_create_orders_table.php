<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->constrained("users");
            $table->foreignId("product_id")->constrained("products");
            $table->integer("quantity");
            $table->float("total_price");
            $table->dateTime("order_date");
            $table->string("shipping_address");
            $table->enum("payment_method", ["cast"])->default("cast");
            $table->enum("status", ["pending", "processing","in_transit", "completed", "decline"])->default("pending");
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
        Schema::dropIfExists('orders');
    }
}
