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
        Schema::create('rental_expenses', function (Blueprint $table) {
            $table->id();
            $table->enum('expense_type', ['maintenance', 'utilities', 'deposit_refund', 'property_tax', 'insurance', 'other']);
            $table->decimal('amount', 10, 2);
            $table->text('description')->nullable();
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade')->nullable();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade')->nullable();
            $table->foreignId('owner_id')->constrained('owners')->onDelete('cascade');
            $table->string('expense_reference')->unique();
            $table->enum('payment_method', ['credit_card', 'bank_transfer', 'cash', 'mobile_money']);
            $table->enum('status', ['paid', 'unpaid', 'partial']);
            $table->date('payment_date')->nullable();
            $table->decimal('original_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('balance_due', 10, 2);
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
        Schema::dropIfExists('rental_expenses');
    }
};
