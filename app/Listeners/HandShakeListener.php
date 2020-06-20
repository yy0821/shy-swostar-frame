<?php

namespace App\Listeners;

use Swoole\Http\Request;
use Swoole\Http\Response;
use SwoStar\Event\Listener;
use Firebase\JWT\JWT;
use SwoStar\Server\WebSocket\WebSocketServer;

class HandShakeListener extends Listener
{
    protected $name = 'ws-hand';

    public function handler(WebSocketServer $server = null, Request  $request = null, Response $response = null)
    {
        $token = $request->header['sec-websocket-protocol'];
        if (empty($token) || !($this->check($server, $token, $request->fd))) {
            $response->end();
            return false;
        }
        $this->handshake($request, $response);
    }

    protected function check(WebSocketServer $server, $token,$fd)
    {
        try{
            $key = config('server.webSocket.jwt.key');
            $alg = config('server.webSocket.jwt.alg');
            $jwt = JWT::decode($token,$key,$alg);
            $userInfo = $jwt->data;
            $server->getRedis()->hSet($key,$userInfo->uid,json_encode([
                'fd' => $fd,
                'url' => $userInfo->serverUrl
            ]));
            return true;
        }catch (\Exception $e){
            return false;
        }
    }

    protected function handshake(Request $request, Response $response)
    {
        $secWebSocketKey = $request->header['sec-websocket-key'];
        $patten = '#^[+/0-9A-Za-z]{21}[AQgw]==$#';
        if (0 === preg_match($patten, $secWebSocketKey) || 16 !== strlen(base64_decode($secWebSocketKey))) {
            $response->end();
            return false;
        }
        $key = base64_encode(
            sha1(
                $request->header['sec-websocket-key'] . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11',
                true
            )
        );

        $headers = [
            'Upgrade' => 'websocket',
            'Connection' => 'Upgrade',
            'Sec-WebSocket-Accept' => $key,
            'Sec-WebSocket-Version' => '13',
        ];

        if (isset($request->header['sec-websocket-protocol'])) {
            $headers['Sec-WebSocket-Protocol'] = $request->header['sec-websocket-protocol'];
        }

        foreach ($headers as $key => $val) {
            $response->header($key, $val);
        }

        $response->status(101);
        $response->end();
    }
}