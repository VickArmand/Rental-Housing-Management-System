<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
use App\Models\Error;
use Illuminate\Support\Facades\Auth;
use ReflectionClass;


class RentalController extends Controller
{
    //
    public function index()
    {
        try {
            $rentals = Rental::all();
            return response()->json($rentals);
        } catch (\Exception $e) {
            Error::saveError('RentalController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rentals'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $rental = Rental::find($id);
            if (!$rental) 
                return response()->json(['message' => 'Rental not found'], 404);
        return response()->json($rental);
        } catch (\Exception $e) {
            Error::saveError('RentalController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $rental = Rental::create($request->all());
            $rental->created_by = Auth::user()->id;
            $rental->save();
            return response()->json($rental, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while storing rental'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $rental = Rental::find($id);
            if (!$rental) 
                return response()->json(['message' => 'Rental not found'], 404);
            $rental->update($request->all());
            $rental->updated_by = Auth::user()->id;
            $rental->save();
            return response()->json($rental);
        } catch (\Exception $e) {
            Error::saveError('RentalController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental'], 500);
        }
        
    }
    public function destroy(string $id)
    {
        try {
            $rental = Rental::find($id);
            if (!$rental) 
                return response()->json(['message' => 'Rental not found'], 404);
            $rental->delete();
            return response()->json(['message' => 'Rental deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting rental'], 500);
        }
    }
}
