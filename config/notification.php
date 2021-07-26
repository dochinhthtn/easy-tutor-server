<?php

return [
    'connections' => [
        'pusher' => [
            'instance_id' => env('PUSHER_BEAM_INSTANCE_ID', ''),
            'secret_key' => env('PUSHER_BEAM_SECRET_KEY')
        ]
    ]
];
