<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * return void
     */
    public function up() {

        Schema::create('boards', function (Blueprint $table) {
            $table->id('idx')->autoIncrement();
            $table->unsignedBigInteger('user_idx')->nullable();
            $table->string('title', 100);
            $table->string('content', 255);
            $table->string('boardPw', 255)->nullable();
            $table->timestamps();
            // 외래키
            $table->foreign('user_idx')->references('idx')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::dropIfExists('boards');
    }
};
