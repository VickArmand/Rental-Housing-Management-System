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
        Schema::create('rental_incomes', function (Blueprint $table) {
            $table->id();
            $table->enum('income_type', ['rent', 'deposit', 'utility', 'other']);
            $table->decimal('amount', 10, 2);
            $table->date('income_date');
            $table->text('description')->nullable();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->decimal('original_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('balance_due', 10, 2);
            $table->string('income_reference')->unique();
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'cash', 'mobile_money']);
            $table->enum('status', ['complete', 'partial', 'unpaid', 'waived']);
            $table->timestamps();
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rental_incomes');
    }
};
