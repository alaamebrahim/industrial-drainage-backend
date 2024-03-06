<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claim_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('claim_id')->references('id')->on('claims');
            $table->string('key');
            $table->decimal('value',12,3);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claim_details');
    }
};
