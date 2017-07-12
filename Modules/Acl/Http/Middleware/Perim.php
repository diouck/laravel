<?php 
namespace Modules\Acl\Http\Middleware;

use Closure;
use Modules\Acl\Entities\Application;
use Modules\Acl\Entities\Perimeter;
use Modules\Acl\Entities\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class Perim
{
    public function handle($request, Closure $next)
    {
        $application = Application::where('slug', '=',$request->segment(1))->firstOrFail();
        $roles = Role::all(); 
        $perim = array();

        foreach ($roles as $role) 
        {
            if(is_array(session()->get('auth.'.$application->slug.'.'.$role->slug)))
            {
                $perim = array_merge($perim, session()->get('auth.'.$application->slug.'.'.$role->slug));
            }
        }

        $post = DB::table('avz_'.$application->id.'_posts')->find($request->id);
        $perim_id = $post->perimeter_id;
        $epci = Perimeter::where('epci',$post->slug)->get();
        $test=array();
        foreach($epci as $com)
        {
            array_push($test, $com->id);
        }
        
        if (in_array($perim_id, $perim)) {
            return $next($request);
        } else if (count(array_intersect($test, $perim)) == count($test)){ 
            return $next($request);
        } else {
            return new RedirectResponse(url('/'.$application->slug.''));
        }
    }
}