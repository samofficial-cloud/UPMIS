<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class space_contract extends Model
{
    //
    use Notifiable;

    use Loggable;

    protected $primaryKey = 'contract_id';

    public function client(){


            return $this->belongsTo('App\client','full_name','full_name');
    }

}
