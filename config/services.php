<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'vkontakte' => [
        'version' => '5.71',
        'client_id' => env('VKONTAKTE_APP_KEY'),
        'client_secret' => env('VKONTAKTE_APP_SECRET'),
        'redirect' => env('APP_URL', 'http://localhost') . '/social-auth/callback/vkontakte',
    ],
];
