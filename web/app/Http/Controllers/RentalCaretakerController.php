<?php

namespace App\Http\Controllers;

use App\Models\Error;
use App\Models\RentalCaretaker;
use Illuminate\Http\Request;
use ReflectionClass;
use Illuminate\Support\Facades\Auth;

class RentalCaretakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $rentalCaretakers = RentalCaretaker::all();
            return response()->json($rentalCaretakers);
        } catch (\Exception $e) {
            Error::saveError('RentalCaretakerController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental caretakers'], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $rentalCaretaker = RentalCaretaker::create($request->all());
            return response()->json($rentalCaretaker, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalCaretakerController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental caretaker'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalCaretaker $rentalCaretaker)
    {
        // Load the associated rental and caretaker relationships
        try {
            return response()->json($rentalCaretaker);
        } catch (\Exception $e) {
            Error::saveError('RentalCaretakerController@show', ['id' => $rentalCaretaker->id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental caretaker'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalCaretaker $rentalCaretaker)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalCaretaker $rentalCaretaker)
    {
        //
        try {
            $rentalCaretaker = RentalCaretaker::find($rentalCaretaker->id);
            if (!$rentalCaretaker) 
                return response()->json(['message' => 'Rental Caretaker not found'], 404);
            $rentalCaretaker->update($request->all());
            $rentalCaretaker->updated_by = Auth::user()->id;
            $rentalCaretaker->save();
            return response()->json($rentalCaretaker);
        } catch (\Exception $e) {
            Error::saveError('RentalCaretakerController@update', ['id' => $rentalCaretaker->id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental caretaker'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalCaretaker $rentalCaretaker)
    {
        //
        try {
            $rentalCaretaker = RentalCaretaker::find($rentalCaretaker->id);
            if (!$rentalCaretaker) 
                return response()->json(['message' => 'Rental Caretaker not found'], 404);
            $rentalCaretaker->delete();
            return response()->json(['message' => 'Rental Caretaker deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalCaretakerController@destroy', ['id' => $rentalCaretaker->id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting rental caretaker'], 500);
        }
        
    }
}
