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
            $table->unsignedInteger('idx');
            $table->unsignedInteger('user_idx')->nullable();
            $table->string('title', 100);
            $table->string('content', 255);
            $table->string('boardPw');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() {
        Schema::dropIfExists('boards');
    }
};
