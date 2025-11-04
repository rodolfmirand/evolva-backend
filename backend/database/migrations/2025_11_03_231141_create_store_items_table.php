<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('store_items', function (Blueprint $table) {
            $table->id();

            $table->string("name");

            $table->text('description')->nullable();

            $table->string('type');

            $table->string('image_url')->nullable();

            $table->integer('price')->default(0);

            $table->boolean('is_active')->default(true);


            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('store_items');
    }
};
