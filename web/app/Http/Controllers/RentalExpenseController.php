<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalExpense;
class RentalExpenseController extends Controller
{
    //
    public function index()
    {
        $rentalexpenses = RentalExpense::all();
        return response()->json($rentalexpenses);
    }
    public function show($id)
    {
        $rentalexpense = RentalExpense::find($id);
        if (!$rentalexpense) 
            return response()->json(['message' => 'Rental Expense not found'], 404);
        return response()->json($rentalexpense);
    }
    public function store(Request $request)
    {
        $rentalexpense = RentalExpense::create($request->all());
        return response()->json($rentalexpense, 201);
    }
    public function update(Request $request, $id)
    {
        $rentalexpense = RentalExpense::find($id);
        if (!$rentalexpense) 
            return response()->json(['message' => 'Rental Expense not found'], 404);
        $rentalexpense->update($request->all());
        return response()->json($rentalexpense);
    }
    public function destroy($id)
    {
        $rentalexpense = RentalExpense::find($id);
        if (!$rentalexpense) 
            return response()->json(['message' => 'Rental Expense not found'], 404);
        $rentalexpense->delete();
        return response()->json(['message' => 'Rental Expense deleted successfully']);
    }
}
