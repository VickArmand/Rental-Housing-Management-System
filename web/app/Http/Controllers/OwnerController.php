<?php

namespace App\Http\Controllers;
use App\Models\Owner;
use Illuminate\Http\Request;

class OwnerController extends Controller
{
    //
    public function index()
    {
        $owners = Owner::all();
        return response()->json($owners);
    }
    public function show(string $id)
    {
        $owner = Owner::find($id);
        if (!$owner) 
            return response()->json(['message' => 'Owner not found'], 404);
        return response()->json($owner);
    }
    public function store(Request $request)
    {
        $owner = Owner::create($request->all());
        return response()->json($owner, 201);
    }
    public function update(Request $request, string $id)
    {
        $owner = Owner::find($id);
        if (!$owner) 
            return response()->json(['message' => 'Owner not found'], 404);
        $owner->update($request->all());
        return response()->json($owner);
    }
    public function destroy(string $id)
    {
        $owner = Owner::find($id);
        if (!$owner) 
            return response()->json(['message' => 'Owner not found'], 404);
        $owner->delete();
        return response()->json(['message' => 'Owner deleted successfully']);
    }
}
