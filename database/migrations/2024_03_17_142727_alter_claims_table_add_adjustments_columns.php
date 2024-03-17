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
            $table->decimal('old_value', 12, 3)->after('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('claim_details', function (Blueprint $table) {
            $table->dropColumn('adjustment_date');
            $table->dropColumn('old_value');
        });
    }
};
