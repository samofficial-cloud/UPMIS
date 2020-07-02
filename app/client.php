<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class client extends Model
{
    use Notifiable;

    //
    protected  $primaryKey = 'client_id';


    
}
