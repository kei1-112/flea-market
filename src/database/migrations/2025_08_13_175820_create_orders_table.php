<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchaser_id')->constrained('users')->cascadeOnDelete();
            $table->string('payment_method');
            $table->string('destination_post_number');
            $table->string('destination_address');
            $table->string('destination_building')->nullable();
            $table->integer('dealing_completed_flag_seller'); //0:取引未完了 1:取引完了済
            $table->integer('dealing_completed_flag_purchaser'); //0:取引未完了 1:取引完了済
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
