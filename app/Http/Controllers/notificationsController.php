<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\notification;

class notificationsController extends Controller
{
    //
    public function ShowNotifications($id){
    $notification=notification::find($id);
    $notification->flag='0';
    $notification->save();
    if($notification->type=='car contract'){
     return redirect()->route('carContracts');
    }
    }
}
