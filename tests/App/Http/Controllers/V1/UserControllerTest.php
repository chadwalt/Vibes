<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;

/**
 * Test UserControllerTest file.
 */
class UserControllerTest extends TestCase
{
    /**
     * User test details.
     *
     * @var array
     */
    private $_userData = [
        'first_name' => 'walter',
        'last_name' => 'kasirye',
        'email' => 'kasirye@gmail.com',
        'username' => 'kasirye',
        'password' => '323',
        'password_confirmation' => '323'
    ];

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
     * Test successful creation of a new user.
     *
     * @return void
     */
    public function testUserCreationSuccess()
    {
        $response = $this->call('post', 'api/v1/user/signup', $this->_userData);
        $this->assertEquals(201, $response->status());
        $this->seeInDatabase(
            'users', [
            'first_name' => 'walter',
            'last_name' => 'kasirye',
            'email' => 'kasirye@gmail.com'
            ]
        );
    }

    /**
     * Test validation of new user data.
     *
     * @return void
     */
    public function testInvalidUserDetailsFailure()
    {
        $this->_userData['username'] =  '';
        $this->_userData['email'] = 'jon.com';
        $response = $this->call('post', 'api/v1/user/signup', $this->_userData);
        $this->assertEquals(422, $response->status());
        $this->assertContains(
            'The username field is required',
            $response->content()
        );
        $this->assertContains(
            'The email must be a valid email address.',
            $response->content()
        );
    }
}
