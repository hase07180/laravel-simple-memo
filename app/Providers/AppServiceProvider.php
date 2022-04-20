<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Memo;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        // 全てのメソッド呼ばれる前に先に呼ばれるメソッド
        view()->composer('*', function ($view) {
            $memos = Memo::select('memos.*')
                ->where('user_id', '=', \Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('updated_at', 'DESC') // ASC=小さい順, DESC=大きい順
                ->get();

            $tags = Tag::where('user_id', '=', Auth::id())
                ->whereNull('deleted_at')
                ->orderBy('id', 'DESC') // ASC=小さい順, DESC=大きい順
                ->get();

            $view->with('memos', $memos)->with('tags', $tags);
        });
    }
}
