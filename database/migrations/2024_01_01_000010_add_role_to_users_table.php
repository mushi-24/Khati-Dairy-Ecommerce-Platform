<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role', 32)->default('customer')->after('email'); // customer|admin|manager|employee|shop_owner
            $table->string('phone', 30)->nullable()->after('role');
            $table->foreignId('shop_id')->nullable()->after('phone');
            $table->boolean('is_active')->default(true)->after('shop_id');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'phone', 'shop_id', 'is_active']);
        });
    }
};
