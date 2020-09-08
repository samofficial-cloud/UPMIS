<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\DB;

class SpaceMiddleware
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
        $space_agents=DB::table('general_settings')->where('category','Space')->orwhere('category','All')->get();
foreach ($space_agents as $space_agent){
        if ($this->auth->getUser()->role !=$space_agent->user_roles) {
            abort(403, 'Unauthorized action.');
        }
}
        return $next($request);
    }
}
