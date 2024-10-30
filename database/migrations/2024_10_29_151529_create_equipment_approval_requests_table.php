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
        Schema::create('equipment_approval_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipments')->onDelete('cascade'); // ID do ticket que requer aprovação
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // ID do usuário que criou o ticket
            $table->foreignId('approved_by_admin_id')->nullable()->constrained('users')->onDelete('set null'); // Admin que aprovou/rejeitou
            $table->string('status')->default('pending'); // 'pending', 'approved', 'rejected'
            $table->text('comments')->nullable(); // Comentários adicionais do admin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('equipment_approval_requests');
    }
};
