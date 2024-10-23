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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('description');
            $table->dateTime('open_date');
            $table->dateTime('close_date')->nullable();
            $table->integer('wait_time')->nullable();
            $table->boolean('urgent');
            $table->foreignId('technician_id')->nullable()->constrained('technicians')->onDelete('cascade');
            $table->foreignId('malfunction_id')->nullable()->constrained('malfunctions')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tickets');
    }
};
