<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class car_rental_invoice extends Model
{
    //
    protected $primaryKey = 'invoice_number';
    use Loggable;
}
