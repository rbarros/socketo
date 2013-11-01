<?php
/**
 * This file is part of the Nocriz API (http://nocriz.com)
 *
 * Copyright (c) 2013  Nocriz API (http://nocriz.com)
 *
 * For the full copyright and license information, please view
 * the file license.txt that was distributed with this source code.
 */

/**
 * Nocriz API 
 *
 * @package  Nocriz
 * @author   Ramon Barros <contato@ramon-barros.com>
 */

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| This application is installed by the Composer, 
| that provides a class loader automatically.
| Use it to seamlessly and feel free to relax.
|
*/

require __DIR__.'/../app/bootstrap.php';

use MyApp\Url;

define('BASEURL', trim(Url::getBaseUrl(),'/').'/');

$app = new Silex\Application();
$app['debug'] = true;

$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../views',
));

/*
$app['menu'] = $app->share(function ($app) {
    $data = require __DIR__.'/../src/menus.php';
    return new Ratchet\Menu($app['request'], $data);
});
*/

$app->get('/{page}', function ($page) use ($app) {
    $page = rtrim($page, '/');

    if (!file_exists(__DIR__.'/../views/'.$page.'.html.twig')) {
        $app->abort(404);
    }

    return $app['twig']->render($page.'.html.twig', array('baseurl' => BASEURL) );
})
->assert('page', '[a-zA-Z0-9\/_-]+')
->value('page', 'demo');

$app->error(function ($e, $code) use ($app) {
    if (404 === $code) {
        return $app['twig']->render('404.html.twig');
    }
});

$app->run();