<?php

namespace App\WebSocket\Controllers;

use Swoole\WebSocket\Server;

abstract class BaseController
{
    abstract function open(Server $server, $request);
    abstract function message(Server $server, $frame);
    abstract function close(Server $ser, $fd);
}