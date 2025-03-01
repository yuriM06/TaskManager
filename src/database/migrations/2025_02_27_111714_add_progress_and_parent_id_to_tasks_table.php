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
            $table->unsignedInteger('progress')->default(0);  // タスクの進捗 (0〜100の範囲)
            $table->unsignedBigInteger('parent_id')->nullable();  // 親タスクのID（親子関係）
            $table->foreign('parent_id')->references('id')->on('tasks');  // 親タスクとのリレーション
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropColumn('progress');
            $table->dropColumn('parent_id');
        });
    }
};
