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
        Schema::table('posts', function (Blueprint $table) {
            $table->integer('order')->nullable()->after('reading_time');
        });

        \DB::statement('SET @order := -1');
        \DB::statement('UPDATE posts SET `order` = (@order := @order + 1) ORDER BY created_at DESC');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};
