<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;

class TenantController extends Controller
{
    //
    public function index()
    {
        $tenants = Tenant::all();
        return response()->json($tenants);
    }
    public function show(string $id)
    {
        $tenant = Tenant::find($id);
        if (!$tenant) 
            return response()->json(['message' => 'Tenant not found'], 404);
        return response()->json($tenant);
    }
    public function store(Request $request)
    {
        $tenant = Tenant::create($request->all());
        return response()->json($tenant, 201);
    }
    public function update(Request $request, string $id)
    {
        $tenant = Tenant::find($id);
        if (!$tenant) 
            return response()->json(['message' => 'Tenant not found'], 404);
        $tenant->update($request->all());
        return response()->json($tenant);
    }
    public function destroy(string $id)
    {
        $tenant = Tenant::find($id);
        if (!$tenant) 
            return response()->json(['message' => 'Tenant not found'], 404);
        $tenant->delete();
        return response()->json(['message' => 'Tenant deleted successfully']);
    }
}
