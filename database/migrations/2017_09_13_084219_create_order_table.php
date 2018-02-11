<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 16);
            $table->integer('product_id');
            $table->integer('size');
            $table->integer('src_dealer_id');
            $table->integer('tag_dealer_id')->nullable()->default(null);
            $table->integer('status')->nullable()->default(null);
            $table->tinyInteger('agree')->default(0)->comment('0: non-allowed, 1: allowed');
            $table->tinyInteger('card_type');
            $table->timestamp('valid_period')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP(0)'));;
            $table->dateTime('application_date')->nullable();
            $table->dateTime('ratification_date')->nullable();
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
