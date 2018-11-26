<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Http\Controllers\V1\RestActions;
use Illuminate\Http\Response;


/**
 * Authorization of the applciation.
 */
class RoleMiddleware
{
    use RestActions;

    /**
     * Process the request before moving it deeper into the application.
     *
     * @param Request $request the incoming request
     * @param Closure $next    the closure
     *
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        if ($request->user->role == 'user') {
            return $this->respond(
                Response::HTTP_UNAUTHORIZED,
                'Unauthorized'
            );
        }

        return $next($request);
    }
}