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
        Schema::create('rental_dues', function (Blueprint $table) {
            $table->id();
            $table->enum('due_type', ['rent', 'security_deposit', 'utilities', 'other_charges']);
            $table->string('description')->nullable();
            $table->decimal('original_amount', 10, 2);
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('amount_due', 10, 2);
            $table->date('due_date');
            $table->enum('status', ['paid', 'unpaid', 'partial', 'waived']);
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
            $table->foreignId('tenant_id')->constrained('tenants')->onDelete('cascade');
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
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
        Schema::dropIfExists('rental_dues');
    }
};
