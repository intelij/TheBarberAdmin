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
            $table->text('name');
            $table->text('address');
            $table->text('contact');
            $table->text('city');
            $table->text('state');
            $table->text('country');
            $table->text('payment_id');
            $table->text('tracking_no')->nullable();
            $table->bigInteger('order_status_id')->default(1);
            $table->bigInteger('product_id');
            $table->bigInteger('unit_price');
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('quantity');
            $table->bigInteger('user_id');
            $table->boolean('is_admin_order')->default(false);
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
