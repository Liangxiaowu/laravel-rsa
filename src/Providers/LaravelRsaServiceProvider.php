<?php


namespace LaraRsa\Providers;


use Illuminate\Support\ServiceProvider;

class LaravelRsaServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $path = realpath(__DIR__.'/../../config/config.php');
        dd($path);
//        $this->publishes([$path => config_path('jwt.php')], 'config');
//        $this->mergeConfigFrom($path, 'jwt');
//
//        $this->aliasMiddleware();
//
//        $this->extendAuthGuard();
    }

    /**
     * {@inheritdoc}
     */
    protected function registerStorageProvider()
    {
//        $this->app->singleton('tymon.jwt.provider.storage', function () {
//            $instance = $this->getConfigInstance('providers.storage');
//
//            if (method_exists($instance, 'setLaravelVersion')) {
//                $instance->setLaravelVersion($this->app->version());
//            }
//
//            return $instance;
//        });
    }

    /**
     * Alias the middleware.
     *
     * @return void
     */
    protected function aliasMiddleware()
    {
//        $router = $this->app['router'];
//
//        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';
//
//        foreach ($this->middlewareAliases as $alias => $middleware) {
//            $router->$method($alias, $middleware);
//        }
    }
}
