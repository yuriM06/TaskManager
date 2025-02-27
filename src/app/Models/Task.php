<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'due_date',
        'progress',
        'parent_id',
    ];

    protected $dates = ['start_date', 'due_date'];

    // 親タスクとのリレーション
    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    // 子タスクとのリレーション
    public function children()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    // 日付のインスタンス化（null対応）
    // 日付のインスタンス化
    public function getStartDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format('Y-m-d') : null;
    }

    protected static function boot()
    {
        parent::boot();

        // 期日設定
        static::creating(function ($task) {
            if (!$task->due_date) {
                $task->due_date = now()->addWeek();  // 期日が設定されていなければ1週間後をデフォルト
            }
            if (!$task->start_date) {
                $task->start_date = now();  // 開始日が設定されていなければ今日をデフォルト
            }
        });
    }
}
