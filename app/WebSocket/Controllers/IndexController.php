<?php

namespace App\WebSocket\Controllers;

use Swoole\WebSocket\Server;

class IndexController extends BaseController
{
    public function open(Server $server, $request)
    {
        dd('indexController open');
    }

    public function message(Server $server, $frame)
    {
        $server->push($frame->fd, "this is server" . $frame->fd);
    }

    public function close(Server $ser, $fd)
    {
        dd('客户端：'.$fd ."已关闭");
    }
}