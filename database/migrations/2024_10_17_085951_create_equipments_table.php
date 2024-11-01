<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('equipments', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('manufacturer')->nullable();
            $table->string('model')->nullable();
            $table->string('room')->nullable();
            $table->string('serial_number');
            $table->boolean('is_approved')->default(true);
            $table->timestamps();

            $table->unique(['type', 'serial_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('equipments');
    }
};
