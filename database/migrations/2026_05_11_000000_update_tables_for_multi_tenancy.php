<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Voeg 'slug' toe aan organizations (uniek)
        Schema::table('organizations', function (Blueprint $table) {
            if (!Schema::hasColumn('organizations', 'slug')) {
                $table->string('slug')->after('name')->nullable()->unique();
            }
        });

        // 2. Voeg 'organization_id' toe aan categories
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'organization_id')) {
                $table->foreignId('organization_id')
                    ->after('id')
                    ->nullable() // Tijdelijk nullable voor bestaande data
                    ->constrained()
                    ->onUpdate('cascade')
                    ->onDelete('restrict');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
        });

        Schema::table('organizations', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
