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
        Schema::table('banom_officers', function (Blueprint $table) {
            if (!Schema::hasColumn('banom_officers', 'division_id')) {
                $table->foreignId('division_id')->nullable()->after('position_id')->constrained('divisions')->nullOnDelete();
            }
            if (!Schema::hasColumn('banom_officers', 'urutan_wakil')) {
                $table->integer('urutan_wakil')->nullable()->after('urutan');
            }
        });

        // Add index on member_id if not present
        try {
            Schema::table('banom_officers', function (Blueprint $table) {
                $table->index('member_id');
            });
        } catch (\Throwable $e) {
            // Index already exists
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banom_officers', function (Blueprint $table) {
            if (Schema::hasColumn('banom_officers', 'division_id')) {
                $table->dropForeign(['division_id']);
                $table->dropColumn(['division_id']);
            }
            if (Schema::hasColumn('banom_officers', 'urutan_wakil')) {
                $table->dropColumn(['urutan_wakil']);
            }
        });
    }
};
