<?php
namespace App\Http\Middleware;

use Closure;

/**
 * Handle Cors for the incoming requests
 */
class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request - Incoming request
     * @param \Closure                 $next    - Move request deep into the app
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Credentials' => 'true',
            'Access-Control-Max-Age' => '86400',
            'Access-Control-Allow-Headers' =>
                'Content-Type, Authorization, X-Requested-With',
        ];

        if ($request->isMethod('OPTIONS')) {
            return response()->json('{"method": "OPTIONS"}', 200, $headers);
        }

        $response = $next($request);

        if (method_exists($response, 'withHeaders')) {
            $response->withHeaders($headers);
        }

        return $response;
    }
}