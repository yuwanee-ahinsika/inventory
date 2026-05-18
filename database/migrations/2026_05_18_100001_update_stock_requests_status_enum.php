<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Change the ENUM column to accept new HOD workflow statuses
        DB::statement("ALTER TABLE stock_requests MODIFY COLUMN status ENUM('pending', 'pending_hod', 'pending_manager', 'approved', 'rejected') DEFAULT 'pending_hod'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE stock_requests MODIFY COLUMN status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending'");
    }
};
