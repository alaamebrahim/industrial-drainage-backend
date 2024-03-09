<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('claim_details', function (Blueprint $table) {
            $table->foreignId('result_detail_id')->after('claim_id')->references('id')->on('result_details');
            $table->date('start_date')->after('result_detail_id');
            $table->date('end_date')->after('start_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('claim_details', function (Blueprint $table) {
            $table->dropColumn('result_detail_id');
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
        });
    }
};
