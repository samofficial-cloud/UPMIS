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

        $insurance_agents=DB::table('general_settings')->where('category','Insurance')->orwhere('category','All')->get();
        foreach ($insurance_agents as $insurance_agent){
            if ($this->auth->getUser()->role !=$insurance_agent->user_roles) {
                abort(403, 'Unauthorized action.');
            }
        }

        return $next($request);
    }
}
