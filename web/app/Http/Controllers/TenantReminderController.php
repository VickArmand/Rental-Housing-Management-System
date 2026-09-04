<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantReminder;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class TenantReminderController extends Controller
{
    //
    public function index()
    {
        try {
            $tenantReminders = TenantReminder::all();
            return response()->json($tenantReminders);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching tenant reminders'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $tenantReminder = TenantReminder::find($id);
            if (!$tenantReminder) 
                return response()->json(['message' => 'Tenant Reminder not found'], 404);
            return response()->json($tenantReminder);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching tenant reminder'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $tenantReminder = TenantReminder::create($request->all());
            $tenantReminder->created_by = Auth::user()->id;
            $tenantReminder->save();
            return response()->json($tenantReminder, 201);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving tenant reminder'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $tenantReminder = TenantReminder::find($id);
            if (!$tenantReminder) 
                return response()->json(['message' => 'Tenant Reminder not found'], 404);
            $tenantReminder->update($request->all());
            $tenantReminder->updated_by = Auth::user()->id;
            $tenantReminder->save();
            return response()->json($tenantReminder);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating tenant reminder'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $tenantReminder = TenantReminder::find($id);
            if (!$tenantReminder) 
                return response()->json(['message' => 'Tenant Reminder not found'], 404);
            $tenantReminder->delete();
            return response()->json(['message' => 'Tenant Reminder deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting tenant reminder'], 500);
        }
    }
}
