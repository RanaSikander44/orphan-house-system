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
        Schema::table('academicyears', function (Blueprint $table) {
            $table->boolean('status')->default(0)->nullable(false)->after('ending_date'); // Adjust 'some_column' to place it after the desired column
       //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('academicyears', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
