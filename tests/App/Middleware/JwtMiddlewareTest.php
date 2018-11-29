<?php

namespace Test\App\Http\Middleware;

use TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\JwtMiddleware;
use Firebase\JWT\JWT;

/**
 * Test JwtMiddleware
 */
class JwtMiddlewareTest extends TestCase
{
    /**
     * Generate API Token
     *
     * @param String $issueTime  - time for issuing the token
     * @param String $expiretime - time when the token expires
     *
     * @return string token The api token generated.
     */
    private function _generateToken($issueTime, $expireTime)
    {
        $payload = [
            'iss' => 'vibes',
            'sub' => 1,
            'iat' => $issueTime,
            'exp' => $expireTime,
        ];

        return JWT::encode($payload, env('JWT_KEY'));
    }

    /**
     * Test that jwt token is not provided.
     *
     * @return void
     */
    public function testTokenNotProvided()
    {
        $request = new Request();
        $jwtMiddleware = new JwtMiddleware();

        $response = $jwtMiddleware->handle($request, function () {});
        $this->assertEquals(401, $response->getStatusCode());
    }

    /**
     * Test invalid jwt token is provided.
     *
     * @return void
     */
    public function testInvalidTokenProvided()
    {
        $request = new Request();
        $request->headers->set('api-token', 'JWT Token');
        $jwtMiddleware = new JwtMiddleware();

        $response = $jwtMiddleware->handle($request, function () {});
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * Test expired time for jwt token provided.
     *
     * @return void
     */
    public function testExpiredTokenProvided()
    {
        $request = new Request();
        $token = $this->_generateToken(Time(), Time());
        $request->headers->set('api-token', $token);
        $jwtMiddleware = new JwtMiddleware();

        $response = $jwtMiddleware->handle($request, function () {});
        $this->assertEquals(400, $response->getStatusCode());
    }

    /**
     * Test that jwt token is valid.
     *
     * @return void
     */
    public function testValidTokenProvided()
    {
        $request = new Request();
        $token = $this->_generateToken(Time(), Time() + 60 * 60);
        $request->headers->set('api-token', $token);
        $jwtMiddleware = new JwtMiddleware();

        $response = $jwtMiddleware->handle($request, function () {});
        $this->assertEquals(null, $response);
    }
}