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

// Dear FIG: Thank you for PSR-0!
use Ratchet\App;
use Ratchet\Wamp\ServerProtocol;

use Ratchet\Website\Chat\Bot;
use Ratchet\Website\Chat\ChatRoom;
use Ratchet\Website\MessageLogger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

    // Composer: The greatest thing since sliced bread
    require dirname(__DIR__) . '/vendor/autoload.php';

    $host = 'localhost';
    if (file_exists(__DIR__ . '/config.php')) {
        require __DIR__ . '/config.php';
    }

    // Setup logging
    $stdout = new StreamHandler('php://stdout');
    $logout = new Logger('SockOut');
    $login  = new Logger('Sock-In');
    $login->pushHandler($stdout);
    $logout->pushHandler($stdout);

    $app = new App($host);
    $app->route('/chat',
        new MessageLogger(       // Log events in case of "oh noes"
            new ServerProtocol(  // WAMP; the new hotness sub-protocol
                new Bot(         // People kept asking me if I was a bot, so I made one!
                    new ChatRoom // ...and DISCUSS!
                )
            )
            , $login
            , $logout
        )
    );

    // GO GO GO!
    $app->run();