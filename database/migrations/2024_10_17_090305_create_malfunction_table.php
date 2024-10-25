<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('malfunctions', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('open');
            $table->float('cost')->nullable();
            $table->integer('resolution_time')->nullable();
            $table->string('diagnosis')->nullable();
            $table->string('solution')->nullable();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null');
            $table->boolean('urgent')->default(false); // Adicionei a coluna urgent
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('malfunctions');
    }
};
