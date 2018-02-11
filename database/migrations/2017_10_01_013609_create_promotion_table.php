<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id');
            $table->integer('dealer_id')->nullable()->default(null);
            $table->integer('level')->nullable()->default(null);
            $table->integer('promotion_price');
            $table->date('promotion_start_date');
            $table->date('promotion_end_date');
            $table->integer('promotion_network');
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
        Schema::dropIfExists('promotions');
    }
}
