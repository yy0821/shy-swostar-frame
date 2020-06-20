<?php

namespace App\Listeners;

use Swoole\Coroutine\Http\Client;
use Swoole\WebSocket\Frame;
use Swoole\WebSocket\Server;
use SwoStar\Event\Listener;
use SwoStar\Server\WebSocket\WebSocketServer;
use SwoStar\Server\WebSocket\Context;

class WsMessageListener extends Listener
{
    protected $name = 'ws-message';

    public function handler(WebSocketServer $webSocketServer = null,Server $server = null,Frame $frame = null)
    {
        $data = json_decode($frame->data,true);
        $this->{$data['method']}($webSocketServer,$server,$data,$frame->fd);
    }

    protected function serverBroadcast(WebSocketServer $webSocketServer = null,Server $server = null,$data,$fd)
    {
        $cli = new Client(config('server.route.host'),config('server.route.port'));
        if ($cli->upgrade("/")){
            $cli->push(json_encode([
                'method' => 'routeBroadcast',
                'msg' => $data['msg']
            ]));
        }
    }

    protected function routeBroadcast(WebSocketServer $webSocketServer = null,Server $server = null,$data,$fd)
    {
        $dataAck = [
            'method' => 'ack',
            'msg_id' => $data['msg_id']
        ];
        $server->push($fd, json_encode($dataAck));
        $webSocketServer->sendAll(json_encode($data['data']));
    }

    protected function privateChat(WebSocketServer $webSocketServer = null,Server $server = null,$data,$fd)
    {
        $clientId = $data['clientId'];
        $clientInfo = $webSocketServer->getRedis()->hGet(config('server.webSocket.jwt.key'),$clientId);
        $clientInfo = json_decode($clientInfo,true);

        var_dump($clientInfo);
        $serverInfo = explode(':',$clientInfo['url']);
        var_dump($serverInfo);
        $request = Context::get($fd)['request'];
        $token = $request->header['sec-websocket-protocol'];

        $cli = new Client($serverInfo[0],$serverInfo[1]);
        $cli->setHeaders(['sec-websocket-protocol'=>$token]);
        if ($cli->upgrade("/")){
            $cli->push(json_encode([
                'method' => 'forwarding',
                'msg' => $data['msg'],
                'fd' => $clientInfo['fd']
            ]));
        }
    }

    protected function forwarding(WebSocketServer $webSocketServer = null,Server $server = null,$data,$fd)
    {
        $server->push($data['fd'],json_encode(['msg' => $data['msg']]));
    }
}