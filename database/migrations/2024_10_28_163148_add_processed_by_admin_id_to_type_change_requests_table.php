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
        Schema::table('type_change_requests', function (Blueprint $table) {
            $table->unsignedBigInteger('processed_by_admin_id')->nullable()->after('status');
            $table->foreign('processed_by_admin_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('type_change_requests', function (Blueprint $table) {
            $table->dropForeign(['processed_by_admin_id']);
            $table->dropColumn('processed_by_admin_id');
        });
    }
};
