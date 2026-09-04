<?php

namespace App\Http\Controllers;

use App\Models\RentalOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class RentalOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        try {
            $rentalOwners = RentalOwner::all();
            return response()->json($rentalOwners);
        } catch (\Exception $e) {
            Error::saveError('RentalOwnerController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental owners'], 500);
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
        //
        try {
            $rentalOwner = RentalOwner::create($request->all());
            return response()->json($rentalOwner, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalOwnerController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving rental owner'], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalOwner $rentalOwner)
    {
        //
        try {
            return response()->json($rentalOwner);
        } catch (\Exception $e) {
            Error::saveError('RentalOwnerController@show', ['id' => $rentalOwner->id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental owner'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RentalOwner $rentalOwner)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RentalOwner $rentalOwner)
    {
        //
        try {
            $rentalOwner->update($request->all());
            return response()->json($rentalOwner);
        } catch (\Exception $e) {
            Error::saveError('RentalOwnerController@update', ['id' => $rentalOwner->id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental owner'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalOwner $rentalOwner)
    {
        //
        try {
            $rentalOwner = RentalOwner::find($rentalOwner->id);
            if (!$rentalOwner) 
                return response()->json(['message' => 'Rental Owner not found'], 404);
            $rentalOwner->delete();
            return response()->json(['message' => 'Rental Owner deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalOwnerController@destroy', ['id' => $rentalOwner->id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting rental owner'], 500);
        }
    }
}
