<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('claim_details', function (Blueprint $table) {
            $table->date('adjustment_date')->after('end_date')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('claim_details', function (Blueprint $table) {
            $table->dropColumn('adjustment_date');
        });
    }
};
