<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class carContract extends Model
{
    //
    use Notifiable;

    use Loggable;


}
