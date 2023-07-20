<?php

return [
    'campaigns' => [
        'from' => [
            'name' => env('MAIL_FROM_NAME'),
            'email' => env('MAIL_FROM_ADDRESS'),
        ],
    ],
    'email_template_variables' => [
        'USERNAME',
    ],
];
