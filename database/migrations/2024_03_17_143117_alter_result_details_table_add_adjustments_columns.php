<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('result_details', function (Blueprint $table) {
            $table->date('adjustment_date')->after('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('result_details', function (Blueprint $table) {
            $table->dropColumn('adjustment_date');
        });
    }
};
