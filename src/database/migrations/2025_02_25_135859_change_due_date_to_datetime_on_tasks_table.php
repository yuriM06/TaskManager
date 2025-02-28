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
        Schema::table('tasks', function (Blueprint $table) {
            // 既存の due_date カラムを datetime 型に変更
            $table->dateTime('due_date')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            // 変更をロールバックするために元に戻す（date 型に戻す）
            $table->date('due_date')->nullable()->change();
        });
    }

};
