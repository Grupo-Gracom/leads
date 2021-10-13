<?php

namespace App\Http\Middleware;

use Closure;

class Admin
{
    public function handle($request, Closure $next)
    {
        $nivel = auth()->user()->cargo_id;
        if($nivel != 1){
            return redirect('/');
        }
        return $next($request);
    }
}
