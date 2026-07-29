<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TenantReminder;

class TenantReminderController extends Controller
{
    //
    public function index()
    {
        $tenantReminders = TenantReminder::all();
        return response()->json($tenantReminders);
    }
    public function show(string $id)
    {
        $tenantReminder = TenantReminder::find($id);
        if (!$tenantReminder) 
            return response()->json(['message' => 'Tenant Reminder not found'], 404);
        return response()->json($tenantReminder);
    }
    public function store(Request $request)
    {
        $tenantReminder = TenantReminder::create($request->all());
        return response()->json($tenantReminder, 201);
    }
    public function update(Request $request, string $id)
    {
        $tenantReminder = TenantReminder::find($id);
        if (!$tenantReminder) 
            return response()->json(['message' => 'Tenant Reminder not found'], 404);
        $tenantReminder->update($request->all());
        return response()->json($tenantReminder);
    }
    public function destroy(string $id)
    {
        $tenantReminder = TenantReminder::find($id);
        if (!$tenantReminder) 
            return response()->json(['message' => 'Tenant Reminder not found'], 404);
        $tenantReminder->delete();
        return response()->json(['message' => 'Tenant Reminder deleted successfully']);
    }
}
