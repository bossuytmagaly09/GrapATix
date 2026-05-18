<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['customer_id']);
            $table->dropColumn('customer_id');
            
            $table->foreignId('organization_id')->after('id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->after('organization_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            // Status already exists in orders
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->foreignId('organization_id')->after('id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('event_id')->after('organization_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->foreignId('user_id')->after('event_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
            $table->string('status', 50)->default('pending')->after('qr_code');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            
            $table->foreignId('customer_id')->nullable()->constrained()->onUpdate('cascade')->onDelete('restrict');
        });

        Schema::table('tickets', function (Blueprint $table) {
            $table->dropForeign(['organization_id']);
            $table->dropColumn('organization_id');
            $table->dropForeign(['event_id']);
            $table->dropColumn('event_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('status');
        });
    }
};
