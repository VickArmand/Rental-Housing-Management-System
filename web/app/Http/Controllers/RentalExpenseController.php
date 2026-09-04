<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalExpense;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class RentalExpenseController extends Controller
{
    //
    public function index()
    {
        try {
            $rentalexpenses = RentalExpense::all();
            return response()->json($rentalexpenses);
        } catch (\Exception $e) {
            Error::saveError('RentalExpenseController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental expenses'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $rentalexpense = RentalExpense::find($id);
            if (!$rentalexpense) 
                return response()->json(['message' => 'Rental Expense not found'], 404);
            return response()->json($rentalexpense);
        } catch (\Exception $e) {
            Error::saveError('RentalExpenseController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental expense'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $rentalexpense = RentalExpense::create($request->all());
            $rentalexpense->created_by = Auth::user()->id;
            $rentalexpense->save();
            return response()->json($rentalexpense, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalExpenseController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving rental expense'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $rentalexpense = RentalExpense::find($id);
            if (!$rentalexpense) 
                return response()->json(['message' => 'Rental Expense not found'], 404);
            $rentalexpense->update($request->all());
            $rentalexpense->updated_by = Auth::user()->id;
            $rentalexpense->save();
            return response()->json($rentalexpense);
        } catch (\Exception $e) {
            Error::saveError('RentalExpenseController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental expense'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $rentalexpense = RentalExpense::find($id);
            if (!$rentalexpense) 
                return response()->json(['message' => 'Rental Expense not found'], 404);
            $rentalexpense->delete();
            return response()->json(['message' => 'Rental Expense deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalExpenseController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting rental expense'], 500);
        }
    }
}
