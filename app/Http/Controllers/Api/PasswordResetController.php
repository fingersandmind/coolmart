<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use App\PasswordReset;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PasswordResetController extends Controller
{
    /**
     * Create token password reset
     *
     * @param  [string] email
     * @return [string] message
     */
    protected $notification_delay;

    public function __construct()
    {
        $this->notification_delay = now()->addSeconds(5);
    }
    public function create(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user)
        {
            return response()->json(['error' => 'We can\'t find user with that email address!']);
        }

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60)
            ]
        );
        
        if($user AND $passwordReset)
        {
            $user->notify((new PasswordResetRequest($passwordReset->token))->delay($this->notification_delay));
        }
        
        return response()->json(['message' => 'We have e-mailed you a password reset link. Please check your email!']);
    }

    /**
     * Find token password reset
     *
     * @param  [string] $token
     * @return [string] message
     * @return [json] passwordReset object
     */
    public function find($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if(!$passwordReset)
        {
            return response()->json(['message' => 'This password reset token is no longer valid!'], 404);
        }
        
        $isTokenExpired = Carbon::parse($passwordReset->updated_at)->addMinutes(10)->isPast();
        
        if($isTokenExpired)
        {
            $passwordReset->delete();
            return response()->json(['This password reset token is no longer valid!'], 404);
        }

        return response()->json($passwordReset);
    }

    /**
     * Reset password
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @param  [string] token
     * @return [string] message
     * @return [json] user object
     */

     public function reset(Request $request)
     {
         $request->validate([
             'email' => 'required|string|email',
             'password' => 'required|min:8|max:16',
             'token' => 'required|string'
         ]);

         $user = User::where('email', $request->email)->first();

         if(!$user)
         {
             return response()->json(['error' => 'We can\'t find user with that email!'],404);
         }

         $passwordReset = PasswordReset::where('email', $user->email)
            ->where('token', $request->token)->first();

         if(!$passwordReset)
         {
             return response()->json(['error' => 'This password reset token is no longer valid!'],404);
         }

         $user->update(['password' => bcrypt($request->password)]);

         $passwordReset->delete();

         $user->notify((new PasswordResetSuccess($passwordReset))->delay($this->notification_delay));

         return response()->json(['message' => 'Password successfully updated!'],200);
     }
}
