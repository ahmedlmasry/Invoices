<?php

namespace App\Http\Middleware;

use App\Models\Permission;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $routeName = $request->route()->getName();
        $permission = Permission::whereRaw("FIND_IN_SET('$routeName',routes)")->first();
        if($permission){
            if(!$request->user()->can($permission->name)){
                abort(403);
            }
        }
        return $next($request);
    }
}
