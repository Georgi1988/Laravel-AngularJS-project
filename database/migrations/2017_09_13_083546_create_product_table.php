<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('level1_id');
            $table->integer('level2_id');
            $table->string('name', 64);
            $table->string('code', 16);
            $table->string('description');
            $table->boolean('status');
            $table->integer('valid_period')->default(0);
            $table->string('image_url');
            $table->integer('standard_price');
            $table->integer('purchase_price_level1')->nullable()->default(null);
            $table->integer('purchase_price_level2')->nullable()->default(null);
            $table->integer('purchase_price_level3')->nullable()->default(null);
            $table->integer('sale_price_level1')->nullable()->default(null);
            $table->integer('sale_price_level2')->nullable()->default(null);
            $table->integer('sale_price_level3')->nullable()->default(null);
            $table->integer('price_sku')->nullable()->default(null);
            $table->integer('price_si')->nullable()->default(null);
            $table->integer('price_st')->nullable()->default(null);
            $table->integer('price_so')->nullable()->default(null);
            $table->integer('price_fd')->nullable()->default(null);
            $table->integer('price_mdf')->nullable()->default(null);
            $table->float('discount_rate', 8, 2)->nullable()->default(null);
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
