<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class APILog
{
    /**
     * Handle an incoming request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        DB::table('api_logs')->insert([
            'url' => $request->getPathInfo(),
            'method' => $request->getMethod(),
            'request' => json_encode($request->all()),
            'response' => $response->getContent(),
            'ip' => $request->ip()
        ]);

        return $response;
    }
}
