<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('reference_number')->nullable()->unique();
        });

        DB::table('orders')
            ->whereNull('reference_number')
            ->orWhere('reference_number', '')
            ->update([
                'reference_number' => DB::raw("CONCAT('ORD-', id)")
            ]);

        Schema::table('orders', function (Blueprint $table) {
            $table->unique('reference_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
