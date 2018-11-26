<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

/**
 * UserController class controlls all operations of the user.
 *
 * This class holds creation, retrieving, updating and deleting of a user from
 * the application.
 */

class UserController extends Controller
{
    use RestActions;

    /**
     * This method creates a new user.
     *
     * @param Request $request Request
     *
     * @return object Response object of the newly created user
     */
    public function createUser(Request $request)
    {
        $response = $this->validate($request, User::$rules);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->username = $request->username;

        if ($user->save()) {
            $response = $this->respond(
                Response::HTTP_CREATED,
                ['message' => 'User created']
            );
        }

        return $response;
    }

    /**
     * Generate API Token
     *
     * @param User $user the current user
     *
     * @return string token The api token generated.
     */
    private function _generateToken(User $user)
    {
        $payload = [
            'iss' => 'vibes',
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + 60*60,
        ];

        return JWT::encode($payload, env('JWT_KEY'));
    }

    /**
     * Authenticate user on loggin.
     *
     * @param Request $request Request
     *
     * @return object Response
     */
    public function authenticateUser(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => 'string|email|required',
                'password' => 'string|required'
            ]
        );

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return $this->respond(
                Response::HTTP_NOT_FOUND,
                ['message' => 'User not found']
            );
        }

        if (Hash::check($request->password, $user->password)) {
            return $this->respond(
                Response::HTTP_OK,
                ['api_token' => $this->_generateToken($user)]
            );
        }

        return $this->respond(
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ['message' => 'Wrong email or password provided.']
        );
    }
}
