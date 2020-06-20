<?php

namespace App\Listeners;

use SwoStar\Event\Listener;
use Swoole\Coroutine\Http\Client;

class StartListener extends Listener
{
    protected $name = 'start';

    public function handler()
    {
        go(function (){
            $cli = new Client(config('server.route.host'),config('server.route.port'));
            if ($cli->upgrade("/")){
                $data = [
                    'host' => config('server.local.host'),
                    'port' => config('server.local.port'),
                    'serverName' => 'swostar_im1',
                    'method' => 'register'
                ];
            }
            $cli->push(json_encode($data));
            swoole_timer_tick(3000,function () use ($cli){
                $cli->push('',WEBSOCKET_OPCODE_PING);
            });
        });
    }
}