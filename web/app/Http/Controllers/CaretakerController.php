<?php

namespace App\Http\Controllers;
use App\Models\Caretaker;
use Illuminate\Http\Request;
use App\Models\Error;
use ReflectionClass;
use Illuminate\Support\Facades\Auth;

class CaretakerController extends Controller
{
    //
    public function index()
    {
        try {
            $caretakers = Caretaker::all();
            return response()->json($caretakers);
        } catch (\Exception $e) {
            Error::saveError('CaretakerController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching caretakers'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $caretaker = Caretaker::find($id);
            if (!$caretaker) 
                return response()->json(['message' => 'Caretaker not found'], 404);
            return response()->json($caretaker);
        } catch (\Exception $e) {
            Error::saveError('CaretakerController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching caretaker'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $caretaker = Caretaker::create($request->all());
            return response()->json($caretaker, 201);
        } catch (\Exception $e) {
            Error::saveError('CaretakerController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to create caretaker'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $caretaker = Caretaker::find($id);
            if (!$caretaker) 
                return response()->json(['message' => 'Caretaker not found'], 404);
            $data = $request->all();
            $data['updated_by'] = Auth::user()->id;
            $caretaker->update($data);
            return response()->json($caretaker);
        } catch (\Exception $e) {
            Error::saveError('CaretakerController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to update caretaker'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $caretaker = Caretaker::find($id);
            if (!$caretaker) 
                return response()->json(['message' => 'Caretaker not found'], 404);
            $caretaker->delete();
            return response()->json(['message' => 'Caretaker deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('CaretakerController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to delete caretaker'], 500);
        }
    }
}
