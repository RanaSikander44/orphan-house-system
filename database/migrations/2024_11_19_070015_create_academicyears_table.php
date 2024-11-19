<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academicyears', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('year'); // Store numeric year values, e.g., 2024
            $table->string('title'); // Title of the academic year
            $table->date('starting_date'); // Corrected column name
            $table->date('ending_date');   // Ending date of the academic year
            $table->timestamps();          // Created and updated timestamps
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academicyears');
    }
};
