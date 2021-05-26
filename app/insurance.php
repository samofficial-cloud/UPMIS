<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
class insurance extends Model
{

use Loggable;

    protected $fillable = [
        'class', 'insurance_company', 'insurance_type','commission_percentage','status',
    ];

protected $table = 'insurance';



}
