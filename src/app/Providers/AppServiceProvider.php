<?php

namespace App\Providers;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // 全ページで期限日の近いタスクがある場合に件数をアラーム
        View::composer('*', function ($view) {
            $view->with('taskCount', Task::alertTasks()->count());
        });

        date_default_timezone_set(config('app.timezone'));
        Carbon::setLocale(config('app.locale'));
    }
}
