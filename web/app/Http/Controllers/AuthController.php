<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use ReflectionClass;

class AuthController extends Controller
{
    //
    public function userDetails(Request $request)
    {
        try {
            $roleNames = Auth::user()->getRoleNames();
            $permissions = Auth::user()->getAllPermissions();
            $roles = Auth::user()->roles;
            return response()->json(['user' => $request->user(), 'roles' => $roles, 'roleNames' => $roleNames, 'permissions' => $permissions]);
        } catch (\Exception $e) {
            Error::saveError('UserController@userDetails', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching user details'], 500);
        }
    }
    public function login(Request $request)
    {
        try {
            $request->validate(
                [
                    'email' => 'required',
                    'password' => 'required|min:8',
                ]
            );
            $user = User::where('email', $request->email)->first();
            if ($user && Hash::check($request->password, $user->password)) {
                return $user->createToken('auth_token')->plainTextToken;
            } else {
                // Handle the case where the user is not found or credentials are invalid
                return redirect()->back()->withErrors(['message' => 'Invalid credentials or user not found.']);
            }
        } catch (\Exception $e) {
            Error::saveError('UserController@login', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred during login'], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Logged out successfully']);
        } catch (\Exception $e) {
            Error::saveError('UserController@logout', ['id' => $request->user()->id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred during logout'], 500);
        }
    }

    public function verifyEmail(Request $request)
    {
        try {
            // Implement forgot password logic here
            $request->validate(['email' => 'required|email']);
            $user = User::where('email', $request->email)->first();
            if ($user) {
                $token = Str::random(64);
                $code = Hash::make(random_int(100000, 999999));
                DB::table('password_reset_tokens')->updateOrInsert(['email' => $request->email], ['token' => $token, 'code' => $code, 'expires_at' => Carbon::now()->addMinutes(10)]);
                // Mail::to($request->email)->send()
                // Send password reset link or code to the user's email
                return response()->json(['token' => $token]);
            } else {
                return response(404)->json(['message' => 'Invalid User']);
            }
            
        } catch (\Exception $e) {
            Error::saveError('UserController@forgotPassword', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while sending OTP'], 500);
        }
    }

    public function verifyCode(Request $request, String $token) {
        $request->validate([
            'code' => 'required|min:6',
            // 'token' => 'required',
        ]);
        $token_record = DB::table('password_reset_tokens')->where(['token' => $token])->first();
        if ($token_record && Hash::check($request->code, $token_record->code)) {
            if (now()->greaterThan($token_record->expires_at))
                return response(400)->json(['message' => 'Code Expired']);
            else
                return response()->json(['token' => $token]);
        } else {
            return response()->json(['message' => 'Invalid Code']);
        }
    }

    public function resetPassword(Request $request, String $token)
    {
        try {
            // Implement reset password logic here
            $request->validate([
                // 'token' => 'required',
                'password' => 'required|min:8|confirmed',
            ]);
            // Reset the user's password
            $token_record = DB::table('password_reset_tokens')->where('token', $token)->first();
            if ($token_record) {
                $user = User::where('email', $token_record->email)->first();
                $user->password = Hash::make($request->password);
                $request->merge([
                    'email' => $token_record->email,
                ]);
                $user->save();
                return $this->login($request);
            } else {
                return response(404)->json(['message' => 'Invalid Token']);
            }
        } catch (\Exception $e) {
            Error::saveError('UserController@resetPassword', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred during password reset'], 500);
        }
    }
}
