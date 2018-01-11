<?php

namespace Chenmobuys\ChenJWT;

use Illuminate\Support\ServiceProvider;

class JWTServiceProvider extends ServiceProvider
{

    /**
     * boot
     * @return void
     */
    public function boot()
    {
        //从应用根目录的config文件夹中加载用户的jwt配置文件
        $this->app->configure('jwt');

        //获取扩展包配置文件的真实路径
        $path = realpath(__DIR__ . '/../config/jwt.php');

        //将扩展包的配置文件merge进用户的配置文件中
        $this->mergeConfigFrom($path, 'jwt');
    }

    /**
     * register
     * @return void
     */
    public function register()
    {
        $this->registerRouteMiddleware();
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        //$this->app->middleware($this->routeMiddleware);
    }

}