<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

//     'payu' => [
//     'key' => 'ZattCr', 
//     'salt' => 'VtflJ1Tjg19blbdoUBemM5hBCT97ztHF', 
//     'base_url' => 'https://test.payu.in/_payment',
// ],
'payu' => [
    'key' => 'Qh6UVk', 
    'salt' => 'C2r3CejSZZ3sHssGfSPAogsW9ZWJgR9v', 
    'base_url' => 'https://secure.payu.in/_payment',
],
];
