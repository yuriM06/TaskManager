<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'tasks';

    protected $fillable = [
        'title',
        'description',
        'status',
        'start_date',
        'due_date',
        'progress',
        'parent_id',
    ];

    protected $casts = [
        'start_date'=> 'datetime:Y-m-d',
        'due_date'=> 'datetime:Y-m-d',
    ];

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

    protected static function boot()
    {
        parent::boot();

        // 期日設定
        static::creating(function ($task) {
            if (!$task->due_date) {
                $task->due_date = now()->addWeek();
            }
            if (!$task->start_date) {
                $task->start_date = now();
            }
        });
    }

    public function scopeAlertTasks($query)
    {
        return $query->whereDate('due_date', '<=', now())
                     ->where('status', '!=', 'completed');
    }
}
