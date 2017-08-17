

<?php
use Ratchet\Server\IoServer;
use Wshandler\SocketController;

    require dirname(__DIR__) . '/vendor/autoload.php';

    $server = IoServer::factory(
        new SocketController(),
        8080
    );

    $server->run();
?>