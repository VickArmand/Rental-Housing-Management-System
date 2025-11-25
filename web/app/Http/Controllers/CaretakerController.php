<?php

namespace App\Http\Controllers;
use App\Models\Caretaker;
use Illuminate\Http\Request;

class CaretakerController extends Controller
{
    //
    public function index()
    {
        $caretakers = Caretaker::all();
        return response()->json($caretakers);
    }
    public function show($id)
    {
        $caretaker = Caretaker::find($id);
        if (!$caretaker) 
            return response()->json(['message' => 'Caretaker not found'], 404);
        return response()->json($caretaker);
    }
    public function store(Request $request)
    {
        $caretaker = Caretaker::create($request->all());
        return response()->json($caretaker, 201);
    }
    public function update(Request $request, $id)
    {
        $caretaker = Caretaker::find($id);
        if (!$caretaker) 
            return response()->json(['message' => 'Caretaker not found'], 404);
        $caretaker->update($request->all());
        return response()->json($caretaker);
    }
    public function destroy($id)
    {
        $caretaker = Caretaker::find($id);
        if (!$caretaker) 
            return response()->json(['message' => 'Caretaker not found'], 404);
        $caretaker->delete();
        return response()->json(['message' => 'Caretaker deleted successfully']);
    }
}
