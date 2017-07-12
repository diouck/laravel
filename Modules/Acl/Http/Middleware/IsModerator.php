<?php 
namespace Modules\Acl\Http\Middleware;

use Closure;
use Modules\Acl\Entities\Application;

class IsModerator
{
    public function handle($request, Closure $next)
    {
        $application = Application::where('slug', '=',$request->segment(1))->firstOrFail();

        if (!empty(session()->get('auth.'.$application->slug.'.moderator')))
        {
            return $next($request);
        }     
        return redirect(url('/'.$application->slug.''));
    }
}