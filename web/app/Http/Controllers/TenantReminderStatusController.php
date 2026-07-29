<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantReminderStatus;

class TenantReminderStatusController extends Controller
{
    //
    public function index()
    {
        $tenantReminderStatuses = TenantReminderStatus::all();
        return response()->json($tenantReminderStatuses);
    }
    public function show(string $id)
    {
        $tenantReminderStatus = TenantReminderStatus::find($id);
        if (!$tenantReminderStatus) 
            return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
        return response()->json($tenantReminderStatus);
    }
    public function store(Request $request)
    {
        $tenantReminderStatus = TenantReminderStatus::create($request->all());
        return response()->json($tenantReminderStatus, 201);
    }
    public function update(Request $request, string $id)
    {
        $tenantReminderStatus = TenantReminderStatus::find($id);
        if (!$tenantReminderStatus) 
            return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
        $tenantReminderStatus->update($request->all());
        return response()->json($tenantReminderStatus);
    }
    public function destroy(string $id)
    {
        $tenantReminderStatus = TenantReminderStatus::find($id);
        if (!$tenantReminderStatus) 
            return response()->json(['message' => 'Tenant Reminder Status not found'], 404);
        $tenantReminderStatus->delete();
        return response()->json(['message' => 'Tenant Reminder Status deleted successfully']);
    }
}
