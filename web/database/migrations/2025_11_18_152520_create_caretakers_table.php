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
        Schema::create('caretakers', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('surname');
            $table->string('identification_number')->unique();
            $table->string('phone_number');
            $table->string('emergency_contact-name');
            $table->string('emergency_contact_phone');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->boolean('is_forbidden')->default(false);
            $table->text('forbidden_reason')->nullable();
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
        Schema::dropIfExists('caretakers');
    }
};
