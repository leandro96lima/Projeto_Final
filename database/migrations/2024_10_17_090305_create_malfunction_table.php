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
        Schema::create('malfunctions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->float('cost')->nullable(); // Pode ser nulo
            $table->integer('resolution_time')->nullable(); // Pode ser nulo
            $table->string('diagnosis')->nullable(); // Pode ser nulo
            $table->string('solution')->nullable(); // Pode ser nulo
            $table->boolean('urgent')->nullable();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('set null'); // Adiciona technician_id
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('malfunctions');
    }
};
