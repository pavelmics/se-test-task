<?php
require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/staticHashes.php');

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Knp\Provider\ConsoleServiceProvider;

$app = new Application();

// configs app
ini_set('display_errors', 1);
$app['debug'] = true;

// eloquent orm
$app->register(
    new \BitolaCo\Silex\CapsuleServiceProvider(),
    [
        'capsule.connection' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'skyeng',
            'username' => 'skyeng',
            'password' => 'skyeng',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'logging' => true, // Toggle query logging on this connection.
        ],
    ]
);

// Twig
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/Views',
]);

// validation
$app->register(new Silex\Provider\ValidatorServiceProvider());

// middlewares
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

// console app
$app->register(new ConsoleServiceProvider(), [
    'console.name'              => 'SkyengApplication',
    'console.version'           => '1.0.0',
    'console.project_directory' => __DIR__.'/..'
]);


/**
 * DI getter
 * @return \Silex\Application
 */
function getDI()
{
    global $app;  // this is evil, I know
    return $app;
}

// rest
$restFactory = require('rest.php');
$restFactory($app);

// serve app page
$app
    ->get('/{url}', function() use ($app) {
        return $app['twig']->render('home.twig');
    })
    ->value('url', 'app')
    ->assert('url', '(app|teachers(\/add|\/\d+|\/april)?|students(\/add)?|^additional.+)');

// fallback action
$app->error(function (\Exception $e, $code) use($app) {
    if ($e instanceof ModelNotFoundException) {
        return $app->json(['error' => 'not found'], 404);
    } else {
        throw $e;
    }
});

return $app;