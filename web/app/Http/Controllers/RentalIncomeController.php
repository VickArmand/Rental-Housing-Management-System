<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RentalIncome;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class RentalIncomeController extends Controller
{
    //
    public function index()
    {
        try {
           $rentalincomes = RentalIncome::all();
           return response()->json($rentalincomes);
        } catch (\Exception $e) {
            Error::saveError('RentalIncomeController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental incomes'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $rentalincome = RentalIncome::find($id);
            if (!$rentalincome) 
                return response()->json(['message' => 'Income not found'], 404);
            return response()->json($rentalincome);
        } catch (\Exception $e) {
            Error::saveError('RentalIncomeController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rental income'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $rentalincome = RentalIncome::create($request->all());
            $rentalincome->created_by = Auth::user()->id;
            $rentalincome->save();
            return response()->json($rentalincome, 201);
        } catch (\Exception $e) {
            Error::saveError('RentalIncomeController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving rental income'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $rentalincome = RentalIncome::find($id);
            if (!$rentalincome) 
                return response()->json(['message' => 'Income not found'], 404);
            $rentalincome->update($request->all());
            $rentalincome->updated_by = Auth::user()->id;
            $rentalincome->save();
            return response()->json($rentalincome);
        } catch (\Exception $e) {
            Error::saveError('RentalIncomeController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating rental income'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $rentalincome = RentalIncome::find($id);
            if (!$rentalincome) 
                return response()->json(['message' => 'Income not found'], 404);
            $rentalincome->delete();
            return response()->json(['message' => 'Income deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RentalIncomeController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while destroy rental income'], 500);
        }
    }
}
