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
        Schema::create('menu_items', function (Blueprint $table) {
            $table->bigIncrements('item_id');
            $table->string('name');
            $table->decimal('price');
            // $table->unsignedBigInteger('order_item_id')->nullable();
            $table->unsignedBigInteger('menu_categorie_id');
            $table->string('image')->nullable();

            $table->timestamps();

            $table->foreign('menu_categorie_id')->references('category_id')->on('menu_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
