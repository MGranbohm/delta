<?php
/**
 * Created by PhpStorm.
 * User: Butts
 * Date: 2017-10-17
 * Time: 10:59
 */

namespace App\Http\Middleware;


use Closure;

class apiChecker
{
    public function handle($request,Closure $next)
    {
        if($request->token=='32oVMwYhb8Tobd4O5khv0rkrZYzsLFRMEmpSt4sw3ODZdL4wDSf9GZolUkNY')
        {
            return $next($request);
        }
        else
        {
            return redirect('/home');
        }

    }

}