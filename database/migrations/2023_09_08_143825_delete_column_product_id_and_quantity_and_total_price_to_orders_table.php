<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteColumnProductIdAndQuantityAndTotalPriceToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(["product_id"]);
            $table->dropColumn("product_id");
            $table->dropColumn("quantity");
            $table->dropColumn("total_price");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId("product_id")
                ->constrained("products")
                ->after("id");
            $table->integer("quantity")->after("product_id");
            $table->decimal("total_price", 10, 2)->after("quantity");

        });
    }
}
