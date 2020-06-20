<?php
return [
    "local" => [
        "host" => "49.234.25.98",
        "port" => 9500,
    ],
    "route" => [
        "host" => "49.234.25.98",
        "port" => 9800,
    ],
    "tcp" => [
        "host" => "0.0.0.0",
        "port" => 9500,
        "config" => [
            "worker_num" => 4,
            "task_worker_num" => 0
        ],
    ],
    "udp" => [
        "host" => "0.0.0.0",
        "port" => 9500,
        "config" => [
            "worker_num" => 2,
            "task_worker_num" => 0
        ],
    ],
    "webSocket" => [
        "is_handShake" => 1,
        "jwt" => [
            "key" => 'swoCloud-server',
            "alg" => [
                'HS256'
            ],
        ],
        "host" => "0.0.0.0",
        "port" => 9500,
        "config" => [
            "worker_num" => 2,
            "task_worker_num" => 0,
            'reload_async' => true
        ],
    ],
    "http" => [
        "host" => "0.0.0.0",
        "port" => 9500,
        "config" => [
            "worker_num" => 1,
            "task_worker_num" => 0
        ],
    ],
    "is_rpc" => 0,
    "rpc" => [
        "host" => "127.0.0.1",
        "port" => 9501,
        "config" => [

        ],
    ]
];