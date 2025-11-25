<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;

class UserSubscriptionController extends Controller
{
    //
    public function index()
    {
        $usersubscriptions = UserSubscription::all();
        return response()->json($usersubscriptions);
    }
    public function show($id)
    {
        $usersubscription = UserSubscription::find($id);
        if (!$usersubscription) 
            return response()->json(['message' => 'User Subscription not found'], 404);
        return response()->json($usersubscription);
    }
    public function store(Request $request)
    {
        $usersubscription = UserSubscription::create($request->all());
        return response()->json($usersubscription, 201);
    }
    public function update(Request $request, $id)
    {
        $usersubscription = UserSubscription::find($id);
        if (!$usersubscription) 
            return response()->json(['message' => 'User Subscription not found'], 404);
        $usersubscription->update($request->all());
        return response()->json($usersubscription);
    }
    public function destroy($id)
    {
        $usersubscription = UserSubscription::find($id);
        if (!$usersubscription) 
            return response()->json(['message' => 'User Subscription not found'], 404);
        $usersubscription->delete();
        return response()->json(['message' => 'User Subscription deleted successfully']);
    }
}
