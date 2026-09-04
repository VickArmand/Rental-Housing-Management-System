<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class SubscriptionController extends Controller
{
    //
    public function index()
    {
        try {
            $subscriptions = Subscription::all();
            return response()->json($subscriptions);
        } catch (\Exception $e) {
            Error::saveError('SubscriptionController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching subscriptions'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) 
                return response()->json(['message' => 'Subscription not found'], 404);
            return response()->json($subscription);
        } catch (\Exception $e) {
            Error::saveError('SubscriptionController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching subscription'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $subscription = Subscription::create($request->all());
            $subscription->created_by = Auth::user()->id;
            $subscription->save();
            return response()->json($subscription, 201);
        } catch (\Exception $e) {
            Error::saveError('SubscriptionController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving subscription'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) 
                return response()->json(['message' => 'Subscription not found'], 404);
            $subscription->update($request->all());
            $subscription->update_by = Auth::user()->id;
            $subscription->save();
            return response()->json($subscription);
        } catch (\Exception $e) {
            Error::saveError('SubscriptionController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating subscription'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $subscription = Subscription::find($id);
            if (!$subscription) 
                return response()->json(['message' => 'Subscription not found'], 404);
            $subscription->delete();
            return response()->json(['message' => 'Subscription deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('SubscriptionController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting subscription'], 500);
        }
    }
}
