<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        $subscriptions = Subscription::all();
        return response()->json($subscriptions);
    }
    public function show($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) 
            return response()->json(['message' => 'Subscription not found'], 404);
        return response()->json($subscription);
    }
    public function store(Request $request)
    {
        $subscription = Subscription::create($request->all());
        return response()->json($subscription, 201);
    }
    public function update(Request $request, $id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) 
            return response()->json(['message' => 'Subscription not found'], 404);
        $subscription->update($request->all());
        return response()->json($subscription);
    }
    public function destroy($id)
    {
        $subscription = Subscription::find($id);
        if (!$subscription) 
            return response()->json(['message' => 'Subscription not found'], 404);
        $subscription->delete();
        return response()->json(['message' => 'Subscription deleted successfully']);
    }
}
