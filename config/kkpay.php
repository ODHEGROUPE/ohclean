<?php

return [
    // Les clés que tu as déjà dans ton .env
    'cle_publique' => env('KKIAPAY_PUBLIC_KEY'),
    'cle_privee' => env('KKIAPAY_PRIVATE_KEY'),
    'cle_secrete' => env('KKIAPAY_SECRET'),

    // Les URLs
    'url_api' => 'https://api.kkiapay.com',
    'url_webhook' => env('APP_URL') . '/webhook/kkiapay',
];
