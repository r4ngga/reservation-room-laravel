<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionPurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotion_purchases', function (Blueprint $table) {
            $table->id();
            $table->string('code_purchase')->unique();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('promotion_id');
            $table->decimal('payment', 10, 2);
            $table->enum('status_payment', ['paid', 'unpaid'])->default('unpaid');
            $table->string('photo_transfer')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('promotion_id')->references('id')->on('promotions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotion_purchases');
    }
}
