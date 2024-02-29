<?php

return [
    'client_id' => env('EINVOICE_CLIENT_ID'),
    'client_key1' => env('EINVOICE_KEY1'),
    'client_key2' => env('EINVOICE_KEY2'),
    'env' => env('EINVOICE_ENV'),
    'registration_no' => env('EINVOICE_REGISTRATION_NO'),
    'registration_name' => env('EINVOICE_REGISTRATION_NAME'),

    'registration' => [
        'username' => env('EINVOICE_SIGNATURE_API_USERNAME'),
        'password' => env('EINVOICE_SIGNATURE_API_PASSWORD'),
        'url' => env('EINVOICE_SIGNATURE_API_URL'),
    ],
];
