<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */

    protected $namespace = 'App\\Http\\Controllers';

    // web.phpに直接記述するのではなく、2つのファイルに分ける
    // front.php ： 一般ユーザー用
    // back.php ： 管理画面用
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            // フロント画面
            Route::middleware('web')  //ルーティングに共通のミドルウェア（前処理）を適用できる。ミドルウェアの設定は、「app/Http/kernel.php」で行う
                ->namespace($this->namespace . '\Front')
                ->as('front.')  //リンクを設定するときのルート名
                ->group(base_path('routes/front.php'));
            
            // 管理画面
            Route::prefix('admin')  // prefix：ルーティングURLの頭に共通のURLをつけることができる
                ->middleware('web', 'auth')  //authを追加することで、ログインしないとアクセスできなくする
                ->namespace($this->namespace . '\Back')
                ->as('back.')  //リンクを設定するときのルート名
                ->group(base_path('routes/back.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
