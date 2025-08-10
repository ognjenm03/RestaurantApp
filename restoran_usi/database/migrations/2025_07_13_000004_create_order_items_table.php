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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('order_item_id');
            $table->integer('quantity');
            $table->decimal('price', 8, 2);  // bolje je precizirati decimal(8,2)
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('item_id');  // dodaj item_id

            $table->timestamps();

            // Definiši strane ključeve (foreign keys)
            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('item_id')->references('item_id')->on('menu_items')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
