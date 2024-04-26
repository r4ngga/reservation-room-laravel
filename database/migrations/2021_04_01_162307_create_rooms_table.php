<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number_room');
            $table->string('facility')->nullable();
            $table->string('class', 50)->nullable(); //1 vip, 2 premium, 3 reguler
            $table->string('capacity', 50)->nullable();
            $table->string('status', 50)->nullable();//0 free, 1 full, 2 booked
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
        Schema::dropIfExists('rooms');
    }
}
