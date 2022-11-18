<?php

namespace App\Http\Middleware;

use App\Models\RolesAccesses;
use Closure;
use Illuminate\Http\Request;

use App\Helpers\Response;

class AllowAccess
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
        $user = auth()->user();

        $module = explode('/', $request->url());
        $module = $module[4];

        $method = strtolower($request->method());

        $access = RolesAccesses::where('role_id', $user['role_id'])->where('module', $module)->whereRaw("FIND_IN_SET(?, methods_allowed)", [$method])->first();

        if (!$access) {
            return response()->json(Response::prepareResponse(false, [], 'You dont have access', Response::UNAUTHORIZED_ERROR), Response::UNAUTHORIZED_ERROR);
        }

        return $next($request);
    }
}
