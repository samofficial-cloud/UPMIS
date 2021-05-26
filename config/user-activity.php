<?php

return [
    'activated'        => true, // active/inactive all logging
    'middleware'       => ['web', 'auth','admin'],
    'route_path'       => '/user_activity',
    'admin_panel_path' => 'admin/dashboard',
    'delete_limit'     => 30, // default 7 days

    'model' => [
        'user' => "App\User",
        'insurance' => "App\insurance",
        'carRental' => "App\carRental",
        'research_flats_contract' => "App\research_flats_contract",
        'space' => "App\space"


    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true
    ]
];
