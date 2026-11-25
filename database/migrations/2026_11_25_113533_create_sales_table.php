<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
    $table->id();
    $table->string('nomor_struk', 25)->unique();
    $table->foreignId('user_id')->constrained('users');
    $table->unsignedInteger('total');
    $table->unsignedInteger('bayar');
    $table->unsignedInteger('kembalian');
    $table->enum('status', ['selesai', 'batal'])->default('selesai');
    $table->string('alasan_batal')->nullable();
    $table->timestamp('dibatalkan_pada')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
