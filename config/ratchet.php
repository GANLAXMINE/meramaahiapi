<?php

return [

   
    /*
    |--------------------------------------------------------------------------
    | Laravel Ratchet Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can define the default settings for Laravel Ratchet.
    |
    */

    'class'           => App\Http\Controllers\RatchetServer::class,
    'host'            => '0.0.0.0', // Prepend tls:// to host address to enable SSL/TLS. Example: tls://0.0.0.0
    'port'            => '8081',
    'connectionLimit' => false,
    'throttle'        => [
        'onOpen'    => '500:1',
        'onMessage' => '200:1',
     ],
    'abortOnMessageThrottle' => false,
    'blackList'              => [],
    'zmq'                    => [
        'host'   => '127.0.0.1',
        'port'   => 5555,
//        'method' => \ZMQ::SOCKET_PULL,
    ],
    /**
     * Look up http://php.net/manual/en/context.ssl.php to configure SSL/TLS.
     */
    'tls'             => [
        // 'peer_name' => '',
        // 'verify_peer' => true,
        // 'verify_peer_name' => true,
        // 'allow_self_signed' => false,
        'cafile' => env('SSL_CA_FILE', ''),
        'capath' => env('SSL_CA_PATH', ''),
        'local_cert' => env('SSL_PUBLIC_CERT', ''),
        'local_pk' => env('SSL_PRIVATE_KEY', ''),
        'passphrase' => env('SSL_PASSPHRASE', ''),
    ],
];
