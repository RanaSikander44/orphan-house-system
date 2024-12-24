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
        Schema::create('child_activities', function (Blueprint $table) {
            $table->id();
            $table->string('child_id');
            $table->string('name');
            $table->string('activity_date');
            $table->string('desc');
            $table->integer('created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_activities');
    }
};
