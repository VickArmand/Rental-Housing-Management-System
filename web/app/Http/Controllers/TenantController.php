<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tenant;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class TenantController extends Controller
{
    //
    public function index()
    {
        try {
            $tenants = Tenant::all();
            return response()->json($tenants);
        } catch (\Exception $e) {
            Error::saveError('TenantController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching subscriptions'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $tenant = Tenant::find($id);
            if (!$tenant) 
                return response()->json(['message' => 'Tenant not found'], 404);
            return response()->json($tenant);
        } catch (\Exception $e) {
            Error::saveError('TenantController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching subscription'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $tenant = Tenant::create($request->all());
            $tenant->created_by = Auth::user()->id;
            $tenant->save();
            return response()->json($tenant, 201);
        } catch (\Exception $e) {
            Error::saveError('TenantController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving subscription'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $tenant = Tenant::find($id);
            if (!$tenant) 
                return response()->json(['message' => 'Tenant not found'], 404);
            $tenant->update($request->all());
            $tenant->updated_by = Auth::user()->id;
            $tenant->save();
            return response()->json($tenant);
        } catch (\Exception $e) {
            Error::saveError('TenantController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating subscription'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $tenant = Tenant::find($id);
            if (!$tenant) 
                return response()->json(['message' => 'Tenant not found'], 404);
            $tenant->delete();
            return response()->json(['message' => 'Tenant deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('TenantController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting subscription'], 500);
        }
    }
}
