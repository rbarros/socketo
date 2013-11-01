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

ini_set('display_errors',1);
error_reporting(E_ALL | E_STRICT );
date_default_timezone_set('America/Sao_Paulo');

define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', realpath(__DIR__.DS.'..'.DS));
$time = time();
header('Last-Modified: '.gmdate('D, d M Y H:i:s', $time).'GMT');
/*
| ------------------------------------------------- -------------------------
| Check Extensions
| ------------------------------------------------- -------------------------
|
| The application requires some extensions to work
| And we will see if they are loaded.
|
*/

if ( ! extension_loaded('mcrypt'))
{
    die('Lemee requires the Mcrypt PHP extension.'.PHP_EOL);
    exit(1);
}

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

$composer_autoload = APP_ROOT.DS.'vendor'.DS.'autoload.php';
if(!file_exists($composer_autoload)){
    die('Please use the composer to install http://getcomposer.org');
}
require $composer_autoload;

    /*
    // Dear FIG: Thank you for PSR-0!
    use Ratchet\Server\IoServer;
    use Ratchet\Server\FlashPolicy;
    use Ratchet\WebSocket\WsServer;
    use Ratchet\Wamp\ServerProtocol;

    use React\EventLoop\Factory;
    use React\Socket\Server as Reactor;
    use React\ZMQ\Context;

    use Ratchet\Website\Bot;
    use Ratchet\Website\ChatRoom;
    use Ratchet\Website\PortLogger;
    use Ratchet\Cookbook\NullComponent;
    use Ratchet\Cookbook\MessageLogger;

    use Monolog\Logger;
    use Monolog\Handler\StreamHandler;

    // Setup logging
    $stdout = new StreamHandler('php://stdout');
    $logout = new Logger('SockOut');
    $login  = new Logger('Sock-In');
    $login->pushHandler($stdout);
    $logout->pushHandler($stdout);

    // The all mighty event loop
    $loop = Factory::create();

    // This little thing is to check for connectivity...
    // As a case study, when people connect on port 80, we're having them
    //  also connect on port 9000 and increment a counter if they connect.
    // Later, we can publish the results and find out if WebSockets over 
    //  a port other than 80 is viable (theory is blocked by firewalls).
    $context = new Context($loop);
    $push = $context->getSocket(ZMQ::SOCKET_PUSH);
    $push->connect('tcp://127.0.0.1:5555');

    // Setup our Ratchet ChatRoom application
    $webSock = new Reactor($loop);
    $webSock->listen(80, '0.0.0.0');
    $webServer = new IoServer(           // Basic I/O with clients, aww yeah
        new WsServer(                    // Boom! WebSockets
            new PortLogger($push, 80,    // Compare vs the almost over 9000 conns
                new MessageLogger(       // Log events in case of "oh noes"
                    new ServerProtocol(  // WAMP; the new hotness sub-protocol
                        new Bot(         // People kept asking me if I was a bot, so I made one!
                            new ChatRoom // ...and DISCUSS!
                        )
                    )
                  , $login
                  , $logout
                )
            )
        )
      , $webSock
    );

    // Allow Flash sockets (Internet Explorer) to connect to our app
    $flashSock = new Reactor($loop);
    $flashSock->listen(843, '0.0.0.0');
    $policy = new FlashPolicy;
    $policy->addAllowedAccess('*', 80);
    $webServer = new IoServer($policy, $flashSock);

    $logSock = new Reactor($loop);
    $logSock->listen(9000, '0.0.0.0');
    $zLogger = new IoServer(
        new WsServer(
            new PortLogger($push, 9000, new NullComponent)
        )
      , $logSock
    );

    // GO GO GO!
    $loop->run();
    */