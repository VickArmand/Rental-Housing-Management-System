<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
use App\Models\Error;
use ReflectionClass;
use Illuminate\Support\Facades\Auth;

class ReminderController extends Controller
{
    //
    public function index()
    {
        try {
            $reminders = Reminder::all();
            return response()->json($reminders);
        } catch (\Exception $e) {
            Error::saveError('ReminderController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching reminders'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $reminder = Reminder::find($id);
            if (!$reminder) 
                return response()->json(['message' => 'Reminder not found'], 404);
            return response()->json($reminder);
        } catch (\Exception $e) {
            Error::saveError('ReminderController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching reminder'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $reminder = Reminder::create($request->all());
            return response()->json($reminder, 201);
        } catch (\Exception $e) {
            Error::saveError('ReminderController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to create reminder'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $reminder = Reminder::find($id);
            if (!$reminder) 
                return response()->json(['message' => 'Reminder not found'], 404);
            $reminder->update($request->all());
            $reminder->updated_by = Auth::user()->id;
            $reminder->save();
            return response()->json($reminder);
        } catch (\Exception $e) {
            Error::saveError('ReminderController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to update reminder'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $reminder = Reminder::find($id);
            if (!$reminder) 
                return response()->json(['message' => 'Reminder not found'], 404);
            $reminder->delete();
            return response()->json(['message' => 'Reminder deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('ReminderController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Failed to delete reminder'], 500);
        }
    }
}
