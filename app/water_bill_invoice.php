<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class water_bill_invoice extends Model
{
    //

    protected $primaryKey = 'invoice_number';

    use Loggable;
}
