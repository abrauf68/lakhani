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
        Schema::create('project_plots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->string('block')->nullable();
            $table->string('plot_no');
            $table->string('size')->nullable();
            $table->enum('category', ['residential', 'commercial', 'industrial'])->default('residential');
            $table->decimal('price', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->longText('extra')->nullable();
            $table->string('image')->nullable();
            $table->enum('status', ['unsold', 'sold'])->default('unsold');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_plots');
    }
};
