<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Error;
use ReflectionClass;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $users = User::all();
            return response()->json($users);
        } catch (\Exception $e) {
            Error::saveError('UserController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching users'], 500);
        }
    }
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
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::create($request->all());
            $user->created_by = Auth::user()->id;
            $user->save();
            return response()->json($user, 201);
        } catch (\Exception $e) {
            Error::saveError('UserController@store', ['email' => $request->email], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred during user creation'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) 
                return response()->json(['message' => 'User not found'], 404);
            return response()->json($user);
        } catch (\Exception $e) {
            Error::saveError('UserController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching user'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) 
                return response()->json(['message' => 'User not found'], 404);
            $user->update($request->all());
            $user->updated_by = Auth::user()->id;
            $user->save();
            return response()->json($user);
        } catch (\Exception $e) {
            Error::saveError('UserController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating user'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = User::find($id);
            if (!$user) 
                return response()->json(['message' => 'User not found'], 404);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('UserController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting user'], 500);
        }
    }
}
