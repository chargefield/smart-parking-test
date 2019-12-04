<?php

/*
 * This file is part of Laravel Hashids.
 *
 * (c) Vincent Klaiber <hello@doubledip.se>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the connections below you wish to use as
    | your default connection for all work. Of course, you may use many
    | connections at once using the manager class.
    |
    */

    'default' => 'main',

    /*
    |--------------------------------------------------------------------------
    | Hashids Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the connections setup for your application. Example
    | configuration has been included, but you may add as many connections as
    | you would like.
    |
    */

    'connections' => [

        'main' => [
            'salt' => 'nkvUn+gdLY5MvHfsEN85a6FVA38OXLmOUcyTXEwhrbhtgr/2w1gyAHKqn99ALY/lO4CO8tc3B51U98VlcFTvVQ==',
            'length' => 64,
        ],

        'ticket' => [
            'salt' => 'BCTcbidLG/sqPFgdKKcbvJNLusVMHV3jYCVHKEH8i2VC2uiTaQDZ6lzp31FTfhlypNSRFqRK+WoHwaJjt41oHw==',
            'length' => 12,
        ],

    ],

];
