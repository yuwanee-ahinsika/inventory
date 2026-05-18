<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add hod_id to users table (which HOD supervises this department user)
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('hod_id')->nullable()->after('department_id')->constrained('users')->nullOnDelete();
        });

        // Add HOD approval tracking to stock_requests table
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->string('hod_status')->default('pending_hod')->after('status');
            $table->foreignId('hod_approved_by')->nullable()->after('processed_by')->constrained('users')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('stock_requests', function (Blueprint $table) {
            $table->dropForeign(['hod_approved_by']);
            $table->dropColumn(['hod_status', 'hod_approved_by']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['hod_id']);
            $table->dropColumn('hod_id');
        });
    }
};
