<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type');
            $table->integer('src_dealer_id');
            $table->integer('src_user_id');
            $table->integer('tag_dealer_id')->nullable()->default(null);
            $table->integer('tag_user_id')->nullable()->default(null);
            $table->string('url', 512);
            $table->string('message', 512);
            $table->mediumText('html_message');
            $table->string('table_name', 32);
            $table->integer('table_id');
            $table->dateTime('register_date', 512);
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
        Schema::dropIfExists('messages');
    }
}
