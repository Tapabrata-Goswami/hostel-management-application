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
        Schema::create('guest_payment', function(Blueprint $table){
            $table->id();
    
            // Foreign key referencing the guests table
            $table->string('guest_id');
        
            // Enum type for payment status (e.g., pending, completed, failed)
            $table->enum('payment_status', ['pending', 'completed', 'failed'])->default('pending');
            $table->boolean('daily')->default(false);
            $table->boolean('monthly')->default(false);
            $table->string('total_amount')->nullable();
            $table->string('paid_amount')->nullable();
            $table->string('pending_amount')->nullable();
            // Optional comment about the payment (use nullable for optional fields)
            $table->string('payment_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_payment');
    }
};
