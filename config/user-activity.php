<?php

use App\ConferenceEvent;
use App\electricity_bill_invoice;
use App\electricity_bill_payment;
use App\insurance_payment;
use App\research_flats_invoice;
use App\research_flats_payment;
use App\water_bill_invoice;
use App\water_bill_payment;

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
        'insurance_parameter' => "App\insurance_parameter",
        'GeneralSetting' => "App\GeneralSetting",
        'SystemSetting' => "App\SystemSetting",
        'carRental' => "App\carRental",
        'carContract' => "App\carContract",
        'car_rental_invoice' => "App\car_rental_invoice",
        'car_rental_payment' => "App\car_rental_payment",
        'log_sheet' => "App\log_sheet",
        'research_flats_contract' => "App\research_flats_contract",
        'space' => "App\space",
        'ConferenceEvent' => "App\ConferenceEvent",
        'client' => "App\client",
        'space_contract' => "App\space_contract",
        'invoice' => "App\invoice",
        'space_payment' => "App\space_payment",
        'electricity_bill_invoice' => "App\electricity_bill_invoice",
        'electricity_bill_payment' => "App\electricity_bill_payment",
        'water_bill_invoice' => "App\water_bill_invoice",
        'water_bill_payment' => "App\water_bill_payment",
        'insurance_invoice' => "App\insurance_invoice",
        'insurance_payment' => "App\insurance_payment",
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
