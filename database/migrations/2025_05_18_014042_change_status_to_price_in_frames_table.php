<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            // First add the new price column
            $table->decimal('price', 10, 2)->default(0)->after('image_path');

            // Finally, drop the status column
            $table->dropColumn('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('frames', function (Blueprint $table) {
            // Add status column back
            $table->string('status')->default('free')->after('image_path');

            // Drop price column
            $table->dropColumn('price');
        });
    }
};
