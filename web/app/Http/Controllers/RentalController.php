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
    public function show($id)
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
    public function update(Request $request, $id)
    {
        $rental = Rental::find($id);
        if (!$rental) 
            return response()->json(['message' => 'Rental not found'], 404);
        $rental->update($request->all());
        return response()->json($rental);
    }
    public function destroy($id)
    {
        $rental = Rental::find($id);
        if (!$rental) 
            return response()->json(['message' => 'Rental not found'], 404);
        $rental->delete();
        return response()->json(['message' => 'Rental deleted successfully']);
    }
}
