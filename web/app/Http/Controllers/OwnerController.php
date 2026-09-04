<?php

namespace App\Http\Controllers;
use App\Models\Owner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class OwnerController extends Controller
{
    //
    public function index()
    {
        try {
            $owners = Owner::all();
            return response()->json($owners);
        } catch (\Exception $e) {
            Error::saveError('OwnerController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching owners'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $owner = Owner::find($id);
            if (!$owner) 
                return response()->json(['message' => 'Owner not found'], 404);
            return response()->json($owner);
        } catch (\Exception $e) {
            Error::saveError('OwnerController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching owner'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $owner = Owner::create($request->all());
            return response()->json($owner, 201);
        } catch (\Exception $e) {
            Error::saveError('OwnerController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to create owner'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $owner = Owner::find($id);
            if (!$owner) 
                return response()->json(['message' => 'Owner not found'], 404);
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $owner->update($data);
            return response()->json($owner);
        } catch (\Exception $e) {
            Error::saveError('OwnerController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to update owner'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $owner = Owner::find($id);
            if (!$owner) 
                return response()->json(['message' => 'Owner not found'], 404);
            $owner->delete();
            return response()->json(['message' => 'Owner deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('OwnerController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to delete owner'], 500);
        }
    }
}
