<?php

namespace App;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class research_flats_contract extends Model
{
    //
    use Notifiable;

    use Loggable;
}
