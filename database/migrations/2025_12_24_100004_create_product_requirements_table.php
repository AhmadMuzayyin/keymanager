<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_requirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('runtime_type', ['php', 'nodejs', 'java', 'kotlin', 'python', 'flutter', 'electron', 'dotnet']);
            $table->string('min_version', 20)->nullable();
            $table->string('recommended_version', 20)->nullable();
            $table->json('additional_requirements')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_requirements');
    }
};
