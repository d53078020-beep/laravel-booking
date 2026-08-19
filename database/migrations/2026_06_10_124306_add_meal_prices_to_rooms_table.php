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
        Schema::table('rooms', function (Blueprint $table) {
            $table->decimal('breakfast_price', 10, 2)->default(0);
            $table->decimal('half_board_price', 10, 2)->default(0);
            $table->decimal('all_inclusive_price', 10, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rooms', function (Blueprint $table) {
            $table->dropColumn([
                'breakfast_price',
                'half_board_price',
                'all_inclusive_price',
            ]);
        });
    }
};
