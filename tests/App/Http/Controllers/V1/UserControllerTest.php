<?php
namespace Tests\App\Http\Controller\V1;

use TestCase;

/**
 * Test UserControllerTest file.
 */
class UserControllerTest extends TestCase
{
    /**
     * Sign-up User test details.
     *
     * @var array
     */
    private $_userData = [
        'first_name' => 'walter',
        'last_name' => 'kasirye',
        'email' => 'kasirye@gmail.com',
        'username' => 'kasirye',
        'password' => '322er@Fwe3',
        'password_confirmation' => '322er@Fwe3',
        'role' => 'user'
    ];

    /**
     * Sign-in User test detials
     */
    private $_userLoginDetails = [
        'email' => 'johndeo@gmail.com',
        'password' => '3223'
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
        $this->_userData['password'] = 'jon.com';
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

    /**
     * Test successfull user login
     *
     * @return void
     */
    public function testLoginSuccess()
    {
        factory(\App\Models\User::class)->create();

        $response = $this->call('post', 'api/v1/user/', $this->_userLoginDetails);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test login with wrong email
     *
     * @return void
     */
    public function testLoginWithWrongEmail()
    {
        factory(\App\Models\User::class)->create();

        $this->_userLoginDetails['email'] = 'deo@gmail.com';
        $response = $this->call('post', 'api/v1/user/', $this->_userLoginDetails);
        $this->assertEquals(404, $response->status());
        $this->assertContains(
            'User not found',
            $response->content()
        );
    }

    /**
     * Test login with wrong password
     *
     * @return void
     */
    public function testLoginWithWrongPassword()
    {
        factory(\App\Models\User::class)->create();

        $this->_userLoginDetails['password'] = '123';
        $response = $this->call('post', 'api/v1/user/', $this->_userLoginDetails);
        $this->assertEquals(422, $response->status());
        $this->assertContains(
            'Wrong email or password provided.',
            $response->content()
        );
    }


    /**
     * Test valid login details
     *
     * @return void
     */
    public function testLoginWithInvalidCredentials()
    {
        $this->_userLoginDetails['email'] = '123';
        $response = $this->call('post', 'api/v1/user/', $this->_userLoginDetails);
        $this->assertEquals(422, $response->status());
        $this->assertContains(
            'The email must be a valid email address.',
            $response->content()
        );
    }

    /**
     * Test valid email and password details
     *
     * @return void
     */
    public function testEmailPasswordSuccess()
    {
        $userData = [
            'email' => 'chad@gmail.com',
            'password' => 'k@T3kk2ns'
        ];
        $response = $this->call('post', 'api/v1/user/validate', $userData);
        $this->assertEquals(200, $response->status());
    }

    /**
     * Test invalid email and password details
     *
     * @return void
     */
    public function testEmailPasswordFailure()
    {
        $userData = [
            'email' => 'chad.gmail.com',
            'password' => 'k@T3kk2ns'
        ];
        $response = $this->call('post', 'api/v1/user/validate', $userData);
        $this->assertEquals(422, $response->status());

        $userData['password'] = '23ds';
        $response = $this->call('post', 'api/v1/user/validate', $userData);
        $this->assertEquals(422, $response->status());
    }
}
