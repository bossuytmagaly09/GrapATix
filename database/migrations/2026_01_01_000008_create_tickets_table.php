<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ticket_type_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('temporary_order_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('order_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->string('qr_code', 500)->unique();
            $table->timestamp('scanned_at')->nullable();
            $table->foreignId('scanned_by')->nullable()->constrained('users')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
