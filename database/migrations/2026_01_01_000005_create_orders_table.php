<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('customer_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('payment_id')->nullable();
            $table->unsignedInteger('total_cents');
            $table->string('status', 50)->default('paid');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
