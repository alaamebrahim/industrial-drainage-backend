<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sample_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sample_id')->references('id')->on('samples');
            $table->string('description');
            $table->integer('price');
            $table->string('duration')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sample_details');
    }
};
