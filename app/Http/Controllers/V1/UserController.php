<?php

namespace App\Http\Controllers\V1;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

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
}
