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
            $table->string('status')->default('open');
            $table->boolean('urgent')->default(false);
            $table->dateTime('open_date');
            $table->dateTime('progress_date')->nullable();
            $table->dateTime('close_date')->nullable();
            $table->integer('wait_time')->nullable();
            $table->integer('resolution_time')->nullable();

            // First define the user_id column
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Define other foreign keys
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
