<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedInteger('user_id');
			$table->foreign('user_id')->references('id')->on('users')->onUpdata('cascade')->onDelete('cascade');
			$table->unsignedInteger('item_id');
			$table->foreign('item_id')->references('id')->on('items')->onUpdata('cascade')->onDelete('cascade');
			$table->integer('quantity');
			$table->timestamps();
            $table->string('delete_flag')->default('off');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
