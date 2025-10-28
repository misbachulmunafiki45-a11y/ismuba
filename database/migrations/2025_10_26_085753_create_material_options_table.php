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
        Schema::create('material_options', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // class_level | semester | subject
            $table->string('key');  // e.g. X, ganjil, Al Islam
            $table->string('label'); // Display label
            $table->unsignedInteger('order')->default(0);
            $table->timestamps();
            $table->unique(['type','key']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_options');
    }
};
