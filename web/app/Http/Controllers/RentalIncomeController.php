<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalIncome;

class RentalIncomeController extends Controller
{
    //
    public function index()
    {
        $rentalincomes = RentalIncome::all();
        return response()->json($rentalincomes);
    }
    public function show($id)
    {
        $rentalincome = RentalIncome::find($id);
        if (!$rentalincome) 
            return response()->json(['message' => 'Income not found'], 404);
        return response()->json($rentalincome);
    }
    public function store(Request $request)
    {
        $rentalincome = RentalIncome::create($request->all());
        return response()->json($rentalincome, 201);
    }
    public function update(Request $request, $id)
    {
        $rentalincome = RentalIncome::find($id);
        if (!$rentalincome) 
            return response()->json(['message' => 'Income not found'], 404);
        $rentalincome->update($request->all());
        return response()->json($rentalincome);
    }
    public function destroy($id)
    {
        $rentalincome = RentalIncome::find($id);
        if (!$rentalincome) 
            return response()->json(['message' => 'Income not found'], 404);
        $rentalincome->delete();
        return response()->json(['message' => 'Income deleted successfully']);
    }
}
