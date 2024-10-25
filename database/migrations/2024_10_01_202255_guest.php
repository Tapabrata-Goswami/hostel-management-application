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
        Schema::create('guest', function(Blueprint $table){
            $table->id();
            $table->string('archive_status')->default(false);
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('check_in_date')->nullable();
            $table->date('check_out_date')->nullable();
            $table->string('room_number')->nullable();
            $table->string('bed_number')->nullable();
            $table->boolean('booking')->default(false);
            $table->boolean('flyer')->default(false);
            $table->boolean('interdependent')->default(false);
            $table->string('passport_scan')->nullable();
            $table->string('contact_no', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest');
    }
};
