<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class space_contract extends Model
{
    //
    use Notifiable;



    public function client(){


            return $this->belongsTo('App\client','full_name','full_name');
    }

}
