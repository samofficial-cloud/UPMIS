<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\client;
use DB;

class clientsController extends Controller
{
    //
    public function index(){
    	$clients=client::orderBy('full_name','asc')->get();
    	return view('clients')->with('clients',$clients);
    }

    public function edit(Request $request){
        $full_name=$request->get('client_name');
        $email=$request->get('email');
        $phone_number=$request->get('phone_number');
        $address=$request->get('address');
    	DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['address' => $address]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['email' => $email]);

            DB::table('clients')
                ->where('full_name', $full_name)
                ->update(['phone_number' => $phone_number]);


         return redirect()->back()->with('success', 'Client Details Edited Successfully');  
    }
}
