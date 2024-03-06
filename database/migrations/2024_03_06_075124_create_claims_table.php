<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('claims', function (Blueprint $table) {
            $table->id();
            $table->foreignId('result_id')->references('id')->on('results');
            $table->foreignId('client_id')->references('id')->on('clients');
            $table->date('result_date');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('consumption');
            $table->decimal('total_amount',12,3)->nullable();
            $table->decimal('amount_paid',12,3)->default(0);
            $table->boolean('is_paid')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('claims');
    }
};
