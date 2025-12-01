<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $users = User::all();
        return response()->json($users);
    }
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required',
                'password' => 'required',
            ]
        );

        $user = User::where('email', $request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            return $user->createToken('auth_token')->plainTextToken;
        } else {
            // Handle the case where the user is not found or credentials are invalid
            return redirect()->back()->withErrors(['message' => 'Invalid credentials or user not found.']);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
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
        //
        $user = User::create($request->all());
        return response()->json($user, 201);
        $user = User::create($request->all());
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) 
            return response()->json(['message' => 'User not found'], 404);
        return response()->json($user);
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
        //
        $user = User::find($id);
        if (!$user) 
            return response()->json(['message' => 'User not found'], 404);
        $user->update($request->all());
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::find($id);
        if (!$user) 
            return response()->json(['message' => 'User not found'], 404);
        $user->delete();
        return response()->json(['message' => 'User deleted successfully']);
    }
}
