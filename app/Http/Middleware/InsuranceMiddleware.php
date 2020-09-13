<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

class InsuranceMiddleware
{


    protected $auth;



    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $category=DB::table('general_settings')->where('user_roles',$this->auth->getUser()->role)->value('category');


        if ($category=='Insurance only' OR $category=='All') {

        }
        else{
            abort(403, 'Unauthorized action');
        }

        return $next($request);
    }
}
