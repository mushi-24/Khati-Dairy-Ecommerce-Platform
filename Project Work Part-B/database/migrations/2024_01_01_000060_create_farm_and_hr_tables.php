<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('production_records', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->decimal('quantity', 12, 2);
            $table->string('unit', 30);
            $table->date('production_date');
            $table->string('batch_reference')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('distributions', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->foreignId('shop_id')->constrained()->cascadeOnDelete();
            $table->decimal('quantity', 12, 2);
            $table->string('unit', 30);
            $table->date('distribution_date');
            $table->decimal('remaining_farm_stock', 12, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('inventory_items', function (Blueprint $table) {
            $table->id();
            $table->enum('location_type', ['farm', 'shop', 'online']);
            $table->foreignId('shop_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('product_id')->nullable()->constrained()->nullOnDelete();
            $table->string('product_name');
            $table->decimal('quantity', 12, 2)->default(0);
            $table->string('unit', 30);
            $table->decimal('low_threshold', 12, 2)->default(10);
            $table->timestamps();
        });

        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('employee_id')->unique();
            $table->string('name');
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('position')->nullable();
            $table->string('department')->nullable();
            $table->date('joining_date')->nullable();
            $table->decimal('salary', 12, 2)->default(0);
            $table->enum('status', ['active', 'inactive', 'on_leave'])->default('active');
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->text('address')->nullable();
            $table->timestamps();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['present', 'absent', 'late', 'leave']);
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->unique(['employee_id', 'date']);
        });

        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->string('month', 7); // YYYY-MM
            $table->decimal('basic_salary', 12, 2);
            $table->unsignedInteger('days_present')->default(0);
            $table->unsignedInteger('days_absent')->default(0);
            $table->unsignedInteger('days_late')->default(0);
            $table->unsignedInteger('days_leave')->default(0);
            $table->decimal('bonus', 12, 2)->default(0);
            $table->decimal('deduction', 12, 2)->default(0);
            $table->decimal('net_salary', 12, 2);
            $table->date('payment_date')->nullable();
            $table->enum('payment_status', ['pending', 'processing', 'paid'])->default('pending');
            $table->text('note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salaries');
        Schema::dropIfExists('attendances');
        Schema::dropIfExists('employees');
        Schema::dropIfExists('inventory_items');
        Schema::dropIfExists('distributions');
        Schema::dropIfExists('production_records');
    }
};
