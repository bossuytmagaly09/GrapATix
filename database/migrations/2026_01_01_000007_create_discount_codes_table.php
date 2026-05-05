<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('discount_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('event_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('code', 100);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->unsignedInteger('max_uses')->nullable();
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->unsignedInteger('discount_fixed_cents')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->unique(['organization_id', 'code'], 'uq_discount_code_per_org');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discount_codes');
    }
};
