<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class clientsController extends Controller
{
    //
    public function index(){
    	return view('clients');
    }
}
