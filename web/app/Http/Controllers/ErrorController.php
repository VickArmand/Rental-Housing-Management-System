<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Error;

class ErrorController extends Controller
{
    //
    public function index()
    {
        $errors = Error::all();
        return response()->json($errors);
    }

    public function show(String $id)
    {
        $error = Error::find($id);
        if ($error) {
            return response()->json($error);
        } else {
            return response()->json(['message' => 'Error not found'], 404);
        }
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'source' => 'required|string',
            'data' => 'nullable|json',
            'error_type' => 'required|string',
            'error_message' => 'required|string',
            'resolved' => 'boolean',
        ]);

        $error = Error::create($validatedData);
        return response()->json($error, 201);
    }

    public function update(Request $request, String $id)
    {
        $error = Error::find($id);
        if ($error) {
            $error->update($request->all());
            return response()->json($error);
        } else {
            return response()->json(['message' => 'Error not found'], 404);
        }
    }

    public function destroy(String $id)
    {
        $error = Error::find($id);
        if ($error) {
            $error->delete();
            return response()->json(['message' => 'Error deleted successfully']);
        } else {
            return response()->json(['message' => 'Error not found'], 404);
        }
    }
}
