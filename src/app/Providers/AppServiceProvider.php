<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Task;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 期限日を超過かつ完了ステータスでは無いタスク
        View::composer('*', function ($view) {
            $today = Carbon::today();
            $taskCount = Task::whereDate('due_date', '<', $today)
                ->where('status', '!=', 'completed')
                ->count();
            $view->with('taskCount', $taskCount);
        });
    }
}
