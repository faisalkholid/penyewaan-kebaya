<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->id();
            // $table->json('dresses');
            $table->date('rental_date');
            $table->date('return_date');
            $table->decimal('total_price', 10, 2);
            $table->enum('status', ['pengajuan', 'disewa', 'batal', 'selesai'])->default('pengajuan');
            $table->string('user_name');
            $table->string('user_phone');
            $table->string('user_address');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rentals');
    }
};
