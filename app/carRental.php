<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;

class carRental extends Model
{
    use Loggable;

    protected $fillable = [
        'vehicle_reg_no', 'vehicle_model', 'vehicle_status','hire_rate','flag','form_status','remarks','comments','cptu_msg_status','dvc_msg_status'
    ];


    protected $table = 'car_rentals';

    //
}
