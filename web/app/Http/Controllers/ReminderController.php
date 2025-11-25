<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reminder;
class ReminderController extends Controller
{
    //
    public function index()
    {
        $reminders = Reminder::all();
        return response()->json($reminders);
    }
    public function show($id)
    {
        $reminder = Reminder::find($id);
        if (!$reminder) 
            return response()->json(['message' => 'Reminder not found'], 404);
        return response()->json($reminder);
    }
    public function store(Request $request)
    {
        $reminder = Reminder::create($request->all());
        return response()->json($reminder, 201);
    }
    public function update(Request $request, $id)
    {
        $reminder = Reminder::find($id);
        if (!$reminder) 
            return response()->json(['message' => 'Reminder not found'], 404);
        $reminder->update($request->all());
        return response()->json($reminder);
    }
    public function destroy($id)
    {
        $reminder = Reminder::find($id);
        if (!$reminder) 
            return response()->json(['message' => 'Reminder not found'], 404);
        $reminder->delete();
        return response()->json(['message' => 'Reminder deleted successfully']);
    }
}
