<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('rental_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->foreignId('dress_id')->constrained('dresses')->onDelete('cascade');
            $table->string('name');
            $table->string('size');
            $table->string('category');
            $table->decimal('rental_price', 12, 2);
            $table->integer('quantity')->default(1);
            $table->string('status')->nullable();
            $table->string('description')->nullable();
            $table->string('image_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rental_details');
    }
};
