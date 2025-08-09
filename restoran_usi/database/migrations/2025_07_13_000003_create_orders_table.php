<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            // $table->dateTime('created_at');
            $table->boolean('is_paid');
            $table->decimal('total_price');
            $table->enum('payment_method', ['cash', 'card'])->default('cash');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('table_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
