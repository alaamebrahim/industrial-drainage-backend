<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->dropColumn('result_detail_id');
            $table->dropIndex('claims_result_id_foreign');
            $table->dropColumn('result_id');
        });
    }

    public function down(): void
    {
        Schema::table('claims', function (Blueprint $table) {
            $table->date('result_date');
            $table->foreignId('client_id')->references('id')->on('clients');
        });
    }
};
