<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function register(UserRequest $request)
    {
        $request->validated();

        $user = User::create([
            'name'      => $request->name,
            'email'     => $request->email,
            'password'  => bcrypt($request->password),
         ]);

        $accessToken = $user->createToken('authToken')->accessToken;
         
        $response = [
            'user' => $user,
            'accessToken' => $accessToken,
            200
        ];
        
        return $response;
    }

    public function checkEmailIfExists($email)
    {
        return User::whereEmail($email)->exists();
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {

        $credentials = request(['email', 'password']);
        $email = request('email');
        try {
            if (!auth()->attempt($credentials)) {
                if($this->checkEmailIfExists($email))
                {
                    return response()->json(['error' => 'The Password you\'ve entered is incorrect! '], 400);
                }
                return response()->json(['error' => 'Email doesn\'t match any account!'], 400);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        /**
         * if credentials are valid, Authenticates and check if email is verified.
         */

        if(!auth()->user()->hasVerifiedEmail())
        {
            auth()->user()->sendEmailVerificationNotification();
            return response(['message' => 'Please check your email!'],403);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;
        $response = [
            'user' => auth()->user(),
            'accessToken' => $accessToken,
            200
        ];
        
        return $response;
    }

    public function changePassword(Request $request)
    {
        $user = auth('api')->user();
        $password = $request->password;

        if(Hash::check($password, $user->password))
        {
            $user->update(['password' => bcrypt($request->new_password)]);

            return response()->json(['message' => 'Password successfully updated!']);
        }

        return response()->json(['error' => 'Password did not match']);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->user()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}
