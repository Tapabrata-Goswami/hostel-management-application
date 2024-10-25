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
        Schema::create('user_permission', function(Blueprint $table){
            $table->id();
            $table->string('user_id')->nullable();
            $table->string('profile_edit')->nullable();
            $table->string('add_guest')->nullable();
            $table->string('guest_list')->nullable();
            $table->string('guest_edit')->nullable();
            $table->string('guest_delete')->nullable();
            $table->string('guest_comment')->nullable();
            $table->string('archive_guest')->nullable();
            $table->string('manager_list')->nullable();
            $table->string('manager_edit')->nullable();
            $table->string('manager_delete')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_permission');
    }
};
