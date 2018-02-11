<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->nullable()->default(null);
            $table->string('name', 50);
            $table->integer('customer_type_id')->nullable()->default(null);
            $table->string('address', 128)->nullable()->default(null);
            $table->string('area', 16)->nullable()->default(null);
            $table->string('province', 16)->nullable()->default(null);
            $table->string('city', 16)->nullable()->default(null);
            $table->string('link')->nullable()->default(null);
            $table->string('dd_account');
            $table->integer('level');
            $table->integer('parent_id');
            $table->integer('detail_id')->nullable()->default(null);
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
        Schema::dropIfExists('dealers');
    }
}
