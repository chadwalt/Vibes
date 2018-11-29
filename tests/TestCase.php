<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
use Firebase\JWT\JWT;
abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use DatabaseMigrations;

    /**
     * Setup before each test
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Generate API Token
     *
     * @param User $user the current user
     *
     * @return string token The api token generated.
     */
    protected function generateToken($user)
    {
        $payload = [
            'iss' => 'vibes',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60 * 60,
        ];

        return JWT::encode($payload, env('JWT_KEY'));
    }

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
