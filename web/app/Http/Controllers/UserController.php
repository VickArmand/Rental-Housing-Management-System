<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
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
