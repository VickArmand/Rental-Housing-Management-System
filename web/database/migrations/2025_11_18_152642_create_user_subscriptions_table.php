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
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id(); 
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subscription_id')->constrained('subscriptions')->onDelete('cascade');
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('amount_paid', 10, 2);
            $table->decimal('balance_due', 10, 2);
            $table->date('payment_date');
            $table->string('transaction_reference')->unique();
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
        Schema::dropIfExists('user_subscriptions');
    }
};
