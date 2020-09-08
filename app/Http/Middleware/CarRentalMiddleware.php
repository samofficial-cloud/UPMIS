<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

class CarRentalMiddleware
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


        $car_agents=DB::table('general_settings')->where('category','Car rental')->orwhere('category','All')->get();
        foreach ($car_agents as $car_agent){
            if ($this->auth->getUser()->role !=$car_agent->user_roles) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
