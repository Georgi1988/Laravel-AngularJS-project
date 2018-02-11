<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('status');
            $table->integer('product_id');
            $table->integer('card_id');
            $table->integer('tag_dealer_id');
            $table->integer('src_dealer_id')->default(0);
            $table->integer('seller_id')->nullable()->default(null);
            $table->decimal('purchase_price', 10, 4)->default(0.0000);
            $table->decimal('sale_price', 10, 4);
            $table->dateTime('sale_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->tinyInteger('balance_state')->default(0);
            $table->timestamps();

            $table->unique(['card_id', 'tag_dealer_id'], 'card_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
