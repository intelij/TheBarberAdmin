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
            $table->text('name')->nullable();
            $table->text('address')->nullable();
            $table->text('contact')->nullable();
            $table->text('city')->nullable();
            $table->text('state')->nullable();
            $table->text('country')->nullable();
            $table->text('payment_id')->nullable();
            $table->text('tracking_no')->nullable();
            $table->bigInteger('order_status_id')->default(1);
            $table->bigInteger('product_id')->nullable();
            $table->bigInteger('unit_price')->nullable();
            $table->bigInteger('total_price')->nullable();
            $table->bigInteger('quantity')->nullable();
            $table->bigInteger('user_id')->nullable();
            $table->bigInteger('salon_id')->nullable();
            $table->boolean('is_admin_order')->default(false);
            $table->boolean('status')->default(false);
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
