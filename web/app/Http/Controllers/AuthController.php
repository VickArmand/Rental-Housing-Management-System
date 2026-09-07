<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

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

    public function forgotPassword(Request $request)
    {
        try {
            // Implement forgot password logic here
            $request->validate(['email' => 'required|email']);
            // Send password reset link or code to the user's email
            return response()->json(['message' => 'Password reset link sent']);
        } catch (\Exception $e) {
            Error::saveError('UserController@forgotPassword', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while sending OTP'], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            // Implement reset password logic here
            $request->validate([
                'token' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:8|confirmed',
            ]);
            // Reset the user's password
            $user = User::where($request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json(['message' => 'Password has been reset']);
        } catch (\Exception $e) {
            Error::saveError('UserController@resetPassword', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred during password reset'], 500);
        }
    }
}
