<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class isCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(auth()->user()->role==1)
        {
            $t = get_custom_settings('timezone');
            if($t!=''){
                date_default_timezone_set($t);
            }
            else{
                $t = get_location(auth()->user()->location);
                if($t){
                    save_custom_setting('timezone',$t->timezone);
                }
            }

            return $next($request);
        }
        else{
            return redirect()->intended(route('dashboard'));
        }
    }
}
