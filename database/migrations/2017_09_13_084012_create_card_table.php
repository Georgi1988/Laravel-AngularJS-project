<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cards', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');
            $table->string('code', 16);
            $table->string('passwd', 16);
            $table->integer('product_id');
            $table->integer('dealer_id')->nullable()->default(null);
            $table->integer('user_id')->nullable()->default(null);
            $table->integer('status')->default(0);
            $table->dateTime('register_datetime')->nullable()->default(null);
            $table->dateTime('active_datetime')->nullable()->default(null);
            $table->integer('customer_id')->nullable()->default(null);
            $table->string('machine_code', 12)->nullable()->default(null);
            $table->dateTime('valid_period')->nullable()->default(null);
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
        Schema::dropIfExists('cards');
    }
}
