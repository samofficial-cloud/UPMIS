<?php

namespace App\Http\Controllers;
use Auth;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use DB;

class LoginController extends Controller
{



    public function login(Request $request){
      

      $errors = new MessageBag; // initiate MessageBag

      $request->validate([
      'user_name' => 'bail|required|max:50',
      'password' => 'required|min:8',
      ]);
      /*
      Check if credentials match with the records in the database
      */
      if(Auth::attempt([
        'user_name' => $request->user_name,
        'password' => $request->password,
        'status' => 1
      ],$request->remember))

      /*
      (Entered credentials are correct)
      Check the type of user so as to direct the user to the correct page
      */
      {

          if(Auth::user()->password_flag=='0'){
          return redirect()->route('changepasswordlogin');
          }
          elseif (Auth::user()->password_flag=='1') {
        # code...
            $category=DB::table('general_settings')->where('user_roles',Auth::user()->role)->value('category');

          if($category=='All'){
           return redirect()->route('home'); 
          }
          
          elseif($category=='Insurance only'){
             return redirect()->route('home2');
          }
         
          elseif($category=='Real Estate only'){
            return redirect()->route('home4');
          }

          elseif($category=='Research Flats only'){
            return redirect()->route('home6');
          }
          

          if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre')){
            return redirect()->route('home3');
          }
          
          if(($category=='CPTU only') && (Auth::user()->role=='Vote Holder') && (Auth::user()->role!='Accountant-Cost Centre')){
            return redirect()->route('home5');
          }

          if(($category=='CPTU only') && (Auth::user()->role!='Vote Holder') && (Auth::user()->role=='Accountant-Cost Centre')){
            return redirect()->route('home5');
          }

          }


          //return redirect()->route('home');


      }
      /*
      If credentials doesn't match
      */
       $errors = new MessageBag(['password' => ['Incorrect user name or password, Please try again']]);
       return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));

    }
}
