<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class client extends Model
{
    use Notifiable;

    //
    protected  $primaryKey = 'client_id';


//    public function space_contract(){
//
//
//        return $this->hasMany('App\space_contract');
//    }

}
