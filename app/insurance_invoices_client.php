<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class insurance_invoices_client extends Model
{
    //

    use Loggable;

    protected $primaryKey = 'invoice_number';
}
