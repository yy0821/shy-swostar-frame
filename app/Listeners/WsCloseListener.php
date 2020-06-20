<?php

namespace App\Listeners;

use SwoStar\Event\Listener;
use Firebase\JWT\JWT;
use SwoStar\Server\WebSocket\Context;
use SwoStar\Server\WebSocket\WebSocketServer;

class WsCloseListener extends Listener
{
    protected $name = 'ws-close';

    public function handler(WebSocketServer $webSocketServer = null,$server = null, $fd = null)
    {
        $request = Context::get($fd)['request'];
        $token = $request->header['sec-websocket-protocol'];

        $key = config('server.webSocket.jwt.key');
        $alg = config('server.webSocket.jwt.alg');
        $jwt = JWT::decode($token, $key, $alg);
        $webSocketServer->getRedis()->hDel($key, $jwt->data->uid);
    }
}