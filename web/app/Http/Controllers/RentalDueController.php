<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalDue;
class RentalDueController extends Controller
{
    //
    public function index()
    {
        $rentaldues = RentalDue::all();
        return response()->json($rentaldues);
    }
    public function show($id)
    {
        $rentaldue = RentalDue::find($id);
        if (!$rentaldue) 
            return response()->json(['message' => 'Rental Due not found'], 404);
        return response()->json($rentaldue);
    }
    public function store(Request $request)
    {
        $rentaldue = RentalDue::create($request->all());
        return response()->json($rentaldue, 201);
    }
    public function update(Request $request, $id)
    {
        $rentaldue = RentalDue::find($id);
        if (!$rentaldue) 
            return response()->json(['message' => 'Rental Due not found'], 404);
        $rentaldue->update($request->all());
        return response()->json($rentaldue);
    }
    public function destroy($id)
    {
        $rentaldue = RentalDue::find($id);
        if (!$rentaldue) 
            return response()->json(['message' => 'Rental Due not found'], 404);
        $rentaldue->delete();
        return response()->json(['message' => 'Rental Due deleted successfully']);
    }
}
