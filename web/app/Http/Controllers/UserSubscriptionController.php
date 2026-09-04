<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserSubscription;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class UserSubscriptionController extends Controller
{
    //
    public function index()
    {
        try {
            $usersubscriptions = UserSubscription::all();
            return response()->json($usersubscriptions);
        } catch (\Exception $e) {
            Error::saveError('UserSubscriptionController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching user subscriptions'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $usersubscription = UserSubscription::find($id);
            if (!$usersubscription) 
                return response()->json(['message' => 'User Subscription not found'], 404);
            return response()->json($usersubscription);
        } catch (\Exception $e) {
            Error::saveError('UserSubscriptionController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching user subscription'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $usersubscription = UserSubscription::create($request->all());
            $usersubscription->created_by = Auth::user()->id;
            $usersubscription->save();
            return response()->json($usersubscription, 201);
        } catch (\Exception $e) {
            Error::saveError('UserSubscriptionController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving user subscriptions'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $usersubscription = UserSubscription::find($id);
            if (!$usersubscription) 
                return response()->json(['message' => 'User Subscription not found'], 404);
            $usersubscription->update($request->all());
            $usersubscription->updated_by = Auth::user()->id;
            $usersubscription->save();
            return response()->json($usersubscription);
        } catch (\Exception $e) {
            Error::saveError('UserSubscriptionController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating user subscriptions'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $usersubscription = UserSubscription::find($id);
            if (!$usersubscription) 
                return response()->json(['message' => 'User Subscription not found'], 404);
            $usersubscription->delete();
            return response()->json(['message' => 'User Subscription deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('UserSubscriptionController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting user subscriptions'], 500);
        }
    }
}
