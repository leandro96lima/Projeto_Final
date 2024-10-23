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
        Schema::create('type_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID do usuário que solicitou
            $table->string('requested_type'); // Tipo solicitado pelo usuário
            $table->string('status')->default('pending'); // Status da solicitação: 'pending', 'approved', 'rejected'
            $table->text('reason'); // Motivo da solicitação
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('type_change_requests');
    }
};
