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
                $table->float('cost');
                $table->integer('resolution_time');
                $table->string('diagnosis');
                $table->string('solution');
                $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade');
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
