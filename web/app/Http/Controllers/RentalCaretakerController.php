<?php

namespace App\Http\Controllers;

use App\Models\RentalCaretaker;
use Illuminate\Http\Request;

class RentalCaretakerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $rentalCaretakers = RentalCaretaker::all();
        return response()->json($rentalCaretakers);
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
        $rentalCaretaker = RentalCaretaker::create($request->all());
        return response()->json($rentalCaretaker, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(RentalCaretaker $rentalCaretaker)
    {
        // Load the associated rental and caretaker relationships
        return response()->json($rentalCaretaker);
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
        $rentalCaretaker = RentalCaretaker::find($rentalCaretaker->id);
        if (!$rentalCaretaker) 
            return response()->json(['message' => 'Rental Caretaker not found'], 404);
        return response()->json($rentalCaretaker);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RentalCaretaker $rentalCaretaker)
    {
        //
        $rentalCaretaker = RentalCaretaker::find($rentalCaretaker->id);
        if (!$rentalCaretaker) 
            return response()->json(['message' => 'Rental Caretaker not found'], 404);
        $rentalCaretaker->delete();
        return response()->json(['message' => 'Rental Caretaker deleted successfully']);
    }
}
