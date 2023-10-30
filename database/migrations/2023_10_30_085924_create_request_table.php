<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('request', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("service_id");
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('operator_id');
            $table->unsignedBigInteger('comment_id');
            $table->foreign('service_id')->references('id')->on('service');
            $table->foreign('comment_id')->references('id')->on('comment');
            $table->foreign('client_id')->references('id')->on('client');
            $table->foreign('operator_id')->references('id')->on('users');
            $table->enum('type', ['обращение', 'жалоба']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request');
    }
};
