<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
  (new Dotenv\Dotenv(__DIR__ . '/../'))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
  //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
  realpath(__DIR__ . '/../')
);

$app->withFacades();
$app->withEloquent();

/*
 |--------------------------------------------------------------------------
 | JWT
 |--------------------------------------------------------------------------
 |
 */
$app->configure('auth');
$app->configure('jwt');

//解决jwt 生成token错误，添加下两行。Jason
$app->alias('auth', 'Illuminate\Auth\AuthManager');
$app->alias('cache', 'Illuminate\Cache\CacheManager');

class_alias('Tymon\JWTAuth\Facades\JWTAuth', 'JWTAuth');
/** This gives you finer control over the payloads you create if you require it.
 *  Source: https://github.com/tymondesigns/jwt-auth/wiki/Installation
 */
class_alias('Tymon\JWTAuth\Facades\JWTFactory', 'JWTFactory');

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
  Illuminate\Contracts\Debug\ExceptionHandler::class,
  App\Exceptions\Handler::class
);

$app->singleton(
  Illuminate\Contracts\Console\Kernel::class,
  App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

 $app->middleware([
  palanik\lumen\Middleware\LumenCors::class
 ]);

$app->routeMiddleware([
  'jwt.auth'    => Tymon\JWTAuth\Middleware\Authenticate::class,
  'jwt.refresh' => Tymon\JWTAuth\Middleware\RefreshToken::class,
]);
/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(Tymon\JWTAuth\Providers\LumenServiceProvider::class);
$app->register(Coolcode\Shared\Providers\SharedServiceProvider::class);
$app->register(Mnabialek\LaravelSqlLogger\Providers\ServiceProvider::class);
$app->register(Dingo\Api\Provider\LumenServiceProvider::class);
$app->register(Jenssegers\Agent\AgentServiceProvider::class);

app('Dingo\Api\Auth\Auth')->extend('jwt', function ($app) {
  return new Dingo\Api\Auth\Provider\JWT($app['Tymon\JWTAuth\JWTAuth']);
});
// json 输出格式
$app['Dingo\Api\Transformer\Factory']->setAdapter(function ($app) {
  $fractal = new League\Fractal\Manager;
  $fractal->setSerializer(new App\Http\Common\NoDataArraySerializer);
  return new Dingo\Api\Transformer\Adapter\Fractal($fractal);
});

// 异常信息处理
app('Dingo\Api\Exception\Handler')->register(function (Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
  abort(404, trans('error.not_found'));
});

// 错误信息处理
$app['Dingo\Api\Exception\Handler']->setErrorFormat([
  'error' => [
    'message'     => ':message',
    'errors'      => ':errors',
    'debug'       => ':debug'
  ]
]);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->group(['namespace' => 'App\Http\Controllers'], function ($app) {
  require __DIR__ . '/../app/Http/routes.php';
});

return $app;
