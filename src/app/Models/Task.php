<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'status', 'due_date'];

    protected $dates = ['due_date'];

    // 日付のインスタンス化
    public function getDueDateAttribute($value)
    {
        return $value ? Carbon::parse($value) : null;
    }

    protected static function boot()
    {
        parent::boot();

        // 期日設定
        static::creating(function ($task) {
            if (!$task->due_date) {
                $task->due_date = now()->addWeek();
            }
        });
    }
}
