<?php

return [
    'fees' => [
        'bank' => 2500,
        'ewallet' => 1200,
        'gateway' => 0,
    ],

    'channels' => [
        [
            'id' => 'gateway_midtrans',
            'type' => 'gateway',
            'name' => 'Midtrans Auto Payment',
            'number' => '-',
            'holder' => 'Secure Gateway',
            'description' => 'Pembayaran otomatis (VA, QRIS, e-wallet, kartu) dengan status real-time.',
        ],
        [
            'id' => 'bank_mandiri',
            'type' => 'bank',
            'name' => 'Bank Mandiri',
            'number' => '1440024797661',
            'holder' => 'Guntur',
        ],
        [
            'id' => 'bank_seabank',
            'type' => 'bank',
            'name' => 'Seabank',
            'number' => '901269725883',
            'holder' => 'Guntur',
        ],
        [
            'id' => 'bank_jago',
            'type' => 'bank',
            'name' => 'Bank Jago',
            'number' => '15672773536',
            'holder' => 'Guntur',
        ],
        [
            'id' => 'ewallet_dana',
            'type' => 'ewallet',
            'name' => 'DANA',
            'number' => '081615060504',
            'holder' => 'Khairunisa',
        ],
        [
            'id' => 'ewallet_shopeepay',
            'type' => 'ewallet',
            'name' => 'ShopeePay',
            'number' => '081615060504',
            'holder' => 'Khairunisa',
        ],
        [
            'id' => 'ewallet_ovo',
            'type' => 'ewallet',
            'name' => 'OVO',
            'number' => '082110831473',
            'holder' => 'Guntur',
        ],
        [
            'id' => 'ewallet_gopay',
            'type' => 'ewallet',
            'name' => 'GoPay',
            'number' => '082110831473',
            'holder' => 'Guntur',
        ],
    ],
];
