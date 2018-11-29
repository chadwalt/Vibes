<?php
namespace Test\App\Http\Middleware;

use TestCase;
use Illuminate\Http\Request;
use App\Http\Middleware\RoleMiddleware;

/**
 * Test Role Middleware
 */
class RoleMiddleTest extends TestCase
{
    /**
     * Test user has rights to perform actions.
     *
     * @return void
     */
    public function testUserCanPeformActions()
    {
        $user = factory(\App\Models\User::class)->make(['role' => 'artiste']);
        $request = new Request();

        $roleMiddleware = new RoleMiddleware();
        $request->merge(['user' =>  $user]);

        $response = $roleMiddleware->handle($request, function () {}, 'user');
        $this->assertEquals(null, $response);
    }

    /**
     * Test user has no rights to perform actions.
     *
     * @return void
     */
    public function testUserCannotPeformActions()
    {
        $user = factory(\App\Models\User::class)->make();
        $request = new Request();

        $roleMiddleware = new RoleMiddleware();
        $request->merge(['user' =>  $user]);

        $response = $roleMiddleware->handle($request, function () {}, 'user');
        $this->assertEquals(401, $response->getStatusCode());
    }
}