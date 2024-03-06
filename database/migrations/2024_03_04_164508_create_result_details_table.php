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
        Schema::create('result_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->references('id')->on('results');
            $table->foreignId('sample_id')->references('id')->on('samples');
            $table->foreignId('sample_detail_id')->references('id')->on('sample_details');
            $table->double('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_details');
    }
};
