<?php 
namespace Modules\Acl\Http\Middleware;

use Closure;

class IsApplication
{
    public function handle($request, Closure $next)
    {

        if (!empty(session()->get('auth.'.$request->segment(1))))
        {
            return $next($request);
        }     
        return redirect('/');
    }
}