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
        Schema::create('delegation_works', function (Blueprint $table) {
            $table->id();
            $table->integer('year');
            $table->longText('content')->nullable();
            $table->unsignedBigInteger('dele_id')->nullable();
            $table->foreign('dele_id')->references('id')->on('delegations')->onDelete('SET NULL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delegation_works');
    }
};
