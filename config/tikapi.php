<?php

return [
    // Primary API Key (Bearer)
    'api_key' => env('TIKAPI_API_KEY', ''),


    // Optional Account Key (for authenticated endpoints)
    'account_key' => env('TIKAPI_ACCOUNT_KEY', null),


    // Base URL — useful for sandbox toggling
    'base_url' => env('TIKAPI_BASE_URL', 'https://api.tikapi.io'),


    // Guzzle options (timeout, proxy, etc.)
    'guzzle' => [
        'timeout' => 10,
    ],
];