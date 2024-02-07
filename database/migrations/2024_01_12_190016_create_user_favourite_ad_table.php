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
        Schema::create('user_favourite_ad', function (Blueprint $table) {
            
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('user_id');
            
            // Chiavi esterne
            $table->foreign('ad_id')->references('id')->on('ads');
            $table->foreign('user_id')->references('id')->on('users');

            // Unici combinando ad_id e user_id
            $table->unique(['ad_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_favourite_ad');
    }
};
