<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * Handle Registration and login of users
 */
class AuthController extends Controller {
    protected $users;

    public function __construct(User $users) {
        $this->users = $users;
    }

    /**
     * User registration endpoint
     *
     * @param  Request $request
     * @return string           JSON Response
     */
    public function register(Request $request) {

        // Validation
        $fields = $request->validate([
            // Username
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed"
        ]);

        // Create user
        $user = new $this->users();
        $user->name = $fields["name"];
        $user->email = $fields["email"];
        $user->password = Hash::make($fields["password"]);
        $user->save();

        // Generate a token for created user
        $token = $user->createToken("simple_token")->plainTextToken;

        $response = [
            "status" => true,
            "token" => $token,
            "user" => $user
        ];

        // Send response with 201(create) HTTP status
        return response($response, 201);
    }

    /**
     * User login endpoint
     *
     * @param  Request $request
     * @return string           JSON Response
     */
    public function login(Request $request) {

        // Validation
        $fields = $request->validate([
            // Username
            "name" => "required|string",
            "password" => "required|string"
        ]);

        $user = $this->users::where("name", $fields["name"])->first();

        if(!$user) {
            return response([
                "status" => false,
                "message" => "Account not found."
            ]);
        }

        $is_valid_password = $this->validate_password(
            $fields["password"],
            $user->password
        );
        if(!$is_valid_password) {
            return response([
                "status" => false,
                "message" => "Wrong credentials, please try again."
            ]);
        }

        // Generate a token for created user
        $token = $user->createToken("simple_token")->plainTextToken;

        $response = [
            "status" => true,
            "token" => $token,
            "user" => $user
        ];

        // Send response with 200(ok) HTTP status
        return response($response, 200);
    }


    /**
     * User logout endpoint
     *
     * @param  Request $request
     * @return string           JSON Response
     */
    public function logout(Request $request) {

        // Delete all tokens for current user
        auth()->user()->tokens()->delete();

        $response = [
            "status" => true,
            "message" => "Successfully logged out."
        ];

        // Send response with 200(ok) HTTP status
        return response($response, 200);
    }

    /**
     * Validate user password
     *
     * @param  string $input_password Current password from inputs
     * @param  string $saved_password Password saved in database
     * @return boolean                Validation status
     */
    private function validate_password(string $input_password, string $saved_password): bool {
        if(!$input_password || !$saved_password) {
            return false;
        }

        return Hash::check($input_password, $saved_password);
    }
}
