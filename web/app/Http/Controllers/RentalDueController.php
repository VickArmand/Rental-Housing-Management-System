<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalDue;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;

class RentalDueController extends Controller
{
    //
    public function index()
    {
        try {
            $rentaldues = RentalDue::all();
            return response()->json($rentaldues);
        } catch (\Exception $e) {
            Error::saveError('RentalDueController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental dues'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $rentaldue = RentalDue::find($id);
            if (!$rentaldue) 
                return response()->json(['message' => 'Rental Due not found'], 404);
            return response()->json($rentaldue);
        } catch (\Exception $e) {
            Error::saveError('RentalDueController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental due'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $rentaldue = RentalDue::create($request->all());
            $rentaldue->created_by = Auth::user()->id;
            $rentaldue->save();
            return response()->json($rentaldue, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalDueController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving rental due'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $rentaldue = RentalDue::find($id);
            if (!$rentaldue) 
                return response()->json(['message' => 'Rental Due not found'], 404);
            $rentaldue->update($request->all());
            $rentaldue->updated_by = Auth::user()->id;
            $rentaldue->save();
            return response()->json($rentaldue);
        } catch (\Exception $e) {
            Error::saveError('RentalDueController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental due'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $rentaldue = RentalDue::find($id);
            if (!$rentaldue) 
                return response()->json(['message' => 'Rental Due not found'], 404);
            $rentaldue->delete();
            return response()->json(['message' => 'Rental Due deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalDueController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting rental due'], 500);
        }
    }
}
