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
        Schema::create('tenant_reminder_statuses', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['pending', 'sent', 'acknowledged', 'dismissed']);
            $table->foreignId('reminder_id')->constrained('reminders')->onDelete('cascade');
            $table->date('acknowledged_at')->nullable();
            $table->date('dismissed_at')->nullable();
            $table->date('sent_at')->nullable();
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
        Schema::dropIfExists('tenant_reminder_statuses');
    }
};
