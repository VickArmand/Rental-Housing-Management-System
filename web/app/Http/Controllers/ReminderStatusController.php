<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReminderStatus;
use App\Models\Error;
use ReflectionClass;
use Illuminate\Support\Facades\Auth;

class ReminderStatusController extends Controller
{
    //
    public function index()
    {
        try {
            $reminderstatuses = ReminderStatus::all();
            return response()->json($reminderstatuses);
        } catch (\Exception $e) {
            Error::saveError('ReminderStatusController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching reminder statuses'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $reminderstatus = ReminderStatus::find($id);
            if (!$reminderstatus) 
                return response()->json(['message' => 'Reminder Status not found'], 404);
            return response()->json($reminderstatus);
        } catch (\Exception $e) {
            Error::saveError('ReminderStatusController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching reminder status'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $reminderstatus = ReminderStatus::create($request->all());
            return response()->json($reminderstatus, 201);
        } catch (\Exception $e) {
            Error::saveError('ReminderStatusController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to create reminder status'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $reminderstatus = ReminderStatus::find($id);
            if (!$reminderstatus) 
                return response()->json(['message' => 'Reminder Status not found'], 404);
            $reminderstatus->update($request->all());
            $reminderstatus->updated_by = Auth::user()->id;
            $reminderstatus->save();
            return response()->json($reminderstatus);
        } catch (\Exception $e) {
            Error::saveError('ReminderStatusController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to update reminder status'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $reminderstatus = ReminderStatus::find($id);
            if (!$reminderstatus) 
                return response()->json(['message' => 'Reminder Status not found'], 404);
            $reminderstatus->delete();
            return response()->json(['message' => 'Reminder Status deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('ReminderStatusController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to delete reminder status'], 500);
        }
    }
}
