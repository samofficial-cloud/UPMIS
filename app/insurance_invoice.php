<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class insurance_invoice extends Model
{
    //
    protected $primaryKey = 'invoice_number';
    use Loggable;
}
