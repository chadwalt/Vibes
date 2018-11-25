<?php
use Laravel\Lumen\Testing\DatabaseMigrations;
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
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
}
