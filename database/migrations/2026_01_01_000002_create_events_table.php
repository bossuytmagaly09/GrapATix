<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('organization_id')->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('venue_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            $table->uuid('uuid')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('subdomain', 100)->nullable()->unique();
            $table->boolean('use_venue_capacity')->default(false);
            $table->unsignedInteger('max_capacity')->nullable();
            $table->unsignedInteger('price_cents')->default(0);
            $table->datetime('start_date');
            $table->datetime('end_date')->nullable();
            $table->string('event_image', 500)->nullable();
            $table->string('header_image', 500)->nullable();
            $table->string('background_image', 500)->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
