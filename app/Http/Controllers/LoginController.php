<?php

namespace App\Http\Controllers;
use Auth;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;

class LoginController extends Controller
{



    public function login(Request $request){

      $errors = new MessageBag; // initiate MessageBag
      /*
      Check if credentials match with the records in the database
      */
      if(Auth::attempt([
        'user_name' => $request->user_name,
        'password' => $request->password,
        'status' => 1
      ]))

      /*
      (Entered credentials are correct)
      Check the type of user so as to direct the user to the correct page
      */
      {



          return redirect()->route('home');


      }
      /*
      If credentials doesn't match
      */
       $errors = new MessageBag(['password' => ['Incorrect user name or password, Please try again']]);
       return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));

    }
}
