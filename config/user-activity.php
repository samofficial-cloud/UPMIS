<?php

use App\research_flats_invoice;
use App\research_flats_payment;

return [
    'activated'        => true, // active/inactive all logging
    'middleware'       => ['web', 'auth','admin'],
    'route_path'       => '/user_activity',
    'admin_panel_path' => 'admin/dashboard',
    'delete_limit'     => 30, // default 7 days

    'model' => [
        'user' => "App\User",
        'insurance' => "App\insurance",
        'insurance_contract' => "App\insurance_contract",
        'insurance_invoices_client' => "App\insurance_invoices_client",
        'insurance_clients_payment' => "App\insurance_clients_payment",
        'carRental' => "App\carRental",
        'research_flats_contract' => "App\research_flats_contract",
        'space' => "App\space",
        'client' => "App\client",
        'space_contract' => "App\space_contract",
        'invoice' => "App\invoice",
        'space_payment' => "App\space_payment",
        'research_flats_invoice' => "App\research_flats_invoice",
        'research_flats_payment' => "App\research_flats_payment",
        'research_flats_room' => "App\research_flats_room"


    ],

    'log_events' => [
        'on_create'     => true,
        'on_edit'       => true,
        'on_delete'     => true,
        'on_login'      => true,
        'on_lockout'    => true
    ]
];
