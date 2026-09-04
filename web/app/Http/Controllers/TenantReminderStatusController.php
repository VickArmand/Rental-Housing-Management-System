<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantReminderStatus;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class TenantReminderStatusController extends Controller
{
    //
    public function index()
    {
        try {
            $tenantReminderStatuses = TenantReminderStatus::all();
            return response()->json($tenantReminderStatuses);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderStatusController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching tenant reminder statuses'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $tenantReminderStatus = TenantReminderStatus::find($id);
            if (!$tenantReminderStatus) 
                return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
            return response()->json($tenantReminderStatus);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderStatusController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching tenant reminder status'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $tenantReminderStatus = TenantReminderStatus::create($request->all());
            $tenantReminderStatus->created_by = Auth::user()->id;
            $tenantReminderStatus->save();
            return response()->json($tenantReminderStatus, 201);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderStatusController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving tenant reminder status'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $tenantReminderStatus = TenantReminderStatus::find($id);
            if (!$tenantReminderStatus) 
                return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
            $tenantReminderStatus->update($request->all());
            $tenantReminderStatus->updated_by = Auth::user()->id;
            $tenantReminderStatus->save();
            return response()->json($tenantReminderStatus);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderStatusController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating tenant reminder status'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $tenantReminderStatus = TenantReminderStatus::find($id);
            if (!$tenantReminderStatus) 
                return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
            $tenantReminderStatus->delete();
            return response()->json(['message' => 'Tenant Reminder Status deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('TenantReminderStatusController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting tenant reminder status'], 500);
        }
    }
}
