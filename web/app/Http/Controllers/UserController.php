<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }
    public function loginAsUser(Request $request, $userId)
    {
        // Find the user by ID
        $user = User::findOrFail($userId);

        // Log in as the specified user
        auth()->login($user);

        // Redirect to the intended page or home
        return redirect()->intended('/');
    }

    public function logoutAsUser(Request $request)
    {
        // Log out the current user
        auth()->logout();

        // Redirect to the admin login page or home
        return redirect('/admin/login');
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
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
