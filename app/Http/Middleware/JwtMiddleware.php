<?php
namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use App\Http\Controllers\V1\RestActions;

/**
 * Handle expiration expiration and validation of JWT
 */
class JwtMiddleware
{
    /**
     * Process the request before moving it deeper into the application.
     *
     * @param Request $request the incoming request
     * @param Closure $next the closure
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->get('token');

        if (!token) {
            return $this->respond(
                Response::HTTP_UNAUTHORIZED,
                'API Token not provided'
            );
        }

        try {
            $credentials = JWT::decode(token, env('JWT_KEY'), array('HS256'));
        } catch (ExpiredException $exception) {
            return $this->respond(
                Response::HTTP_BAD_REQUEST,
                'Provided token expired'
            );
        } catch (Exception $exception) {
            return $this->respond(
                Response::HTTP_BAD_REQUEST,
                'An error occured while decoding token'
            );
        }

        $user = User::find($credentials->sub);
        $request->user = $user;

        return next($request);
    }
}