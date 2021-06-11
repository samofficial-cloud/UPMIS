<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class research_flats_invoice extends Model
{
    //
    use Loggable;

    protected $primaryKey = 'invoice_number';


}
