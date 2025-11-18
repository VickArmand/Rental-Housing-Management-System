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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_name');
            $table->text('description')->nullable();
            $table->decimal('monthly_rent', 10, 2);
            $table->decimal('security_deposit', 10, 2)->default(0);
            $table->decimal('other_charges', 10, 2)->default(0);
            $table->integer('maximum_capacity')->default(1);
            $table->boolean('is_vacant')->default(true);
            $table->boolean('is_active')->default(true);
            $table->foreignId('rental_id')->constrained('rentals')->onDelete('cascade');
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
        Schema::dropIfExists('rooms');
    }
};
