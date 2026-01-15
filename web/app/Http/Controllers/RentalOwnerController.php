<?php

namespace App\Http\Controllers;

use App\Models\RentalOwner;
use Illuminate\Http\Request;

class RentalOwnerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rentalOwners = RentalOwner::all();
        return response()->json($rentalOwners);
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
        $rentalOwner = RentalOwner::create($request->all());
        return response()->json($rentalOwner, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalOwner $rentalOwner)
    {
        //
        return response()->json($rentalOwner);
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
        $rentalOwner->update($request->all());
        return response()->json($rentalOwner);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalOwner $rentalOwner)
    {
        //
        $rentalOwner = RentalOwner::find($rentalOwner->id);
        if (!$rentalOwner) 
            return response()->json(['message' => 'Rental Owner not found'], 404);
        $rentalOwner->delete();
        return response()->json(['message' => 'Rental Owner deleted successfully']);
    }
}
