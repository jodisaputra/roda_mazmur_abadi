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
        // For SQLite, we'll rely on application logic to ensure uniqueness
        // Add comment to document the business rule
        Schema::table('product_images', function (Blueprint $table) {
            // Business rule: Only one image per product can have is_primary = true
            // This is enforced by application logic in ProductService
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // No database changes to rollback
    }
};
