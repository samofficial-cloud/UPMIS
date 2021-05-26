<?php

namespace App\Http\Controllers;
use Auth;
use App\user;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Input;
use DB;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Lang;

class LoginController extends Controller
{
    use AuthenticatesUsers;



    /**
     * The maximum number of attempts to allow.
     *
     * @return int
     */
    protected $maxAttempts = 3;


    /**
     * The number of minutes to throttle for.
     *
     * @return int
     */
    protected $decayMinutes = 10;



    public function username()
    {
        return 'user_name';
    }


    protected function sendLockoutResponse(Request $request)
    {
        $seconds = $this->limiter()->availableIn(
            $this->throttleKey($request)
        );

        $minutes=round($seconds/60);
        throw ValidationException::withMessages([
            $this->username() => [Lang::get('auth.throttle', ['minutes' => $minutes])],
        ])->status(429);
    }



    public function login(Request $request){


      $errors = new MessageBag; // initiate MessageBag

      $request->validate([
      'user_name' => 'bail|required|max:50',
      'password' => 'required'
      ]);



        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }



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
          $this->clearLoginAttempts($request);
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


      }else{



          /*
     If credentials doesn't match
     */

          $this->incrementLoginAttempts($request);

          $errors = new MessageBag(['password' => ['Incorrect user name or password, Please try again']]);
          return redirect()->back()->withErrors($errors)->withInput(Input::except('password'));


      }

    }
}
