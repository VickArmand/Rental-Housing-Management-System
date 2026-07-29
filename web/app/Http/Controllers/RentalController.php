<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rental;
class RentalController extends Controller
{
    //
    public function index()
    {
        $rentals = Rental::all();
        return response()->json($rentals);
    }
    public function show(string $id)
    {
        $rental = Rental::find($id);
        if (!$rental) 
            return response()->json(['message' => 'Rental not found'], 404);
        return response()->json($rental);
    }
    public function store(Request $request)
    {
        $rental = Rental::create($request->all());
        return response()->json($rental, 201);
    }
    public function update(Request $request, string $id)
    {
        $rental = Rental::find($id);
        if (!$rental) 
            return response()->json(['message' => 'Rental not found'], 404);
        $rental->update($request->all());
        return response()->json($rental);
    }
    public function destroy(string $id)
    {
        $rental = Rental::find($id);
        if (!$rental) 
            return response()->json(['message' => 'Rental not found'], 404);
        $rental->delete();
        return response()->json(['message' => 'Rental deleted successfully']);
    }
}
