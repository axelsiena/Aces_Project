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
        Schema::create('ads', function (Blueprint $table) {
            
            $table->id();
            $table->string('title',100);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('user_id');
            $table->float('price');
            $table->string('description',500);
            $table->timestamps();
            $table->boolean('is_accepted')->default(false);
            $table->unsignedBigInteger('revisioned_by_user_id')->nullable();
            $table->softDeletes();

            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('revisioned_by_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
