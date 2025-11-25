<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ReminderStatus;
class ReminderStatusController extends Controller
{
    //
    public function index()
    {
        $reminderstatuses = ReminderStatus::all();
        return response()->json($reminderstatuses);
    }
    public function show($id)
    {
        $reminderstatus = ReminderStatus::find($id);
        if (!$reminderstatus) 
            return response()->json(['message' => 'Reminder Status not found'], 404);
        return response()->json($reminderstatus);
    }
    public function store(Request $request)
    {
        $reminderstatus = ReminderStatus::create($request->all());
        return response()->json($reminderstatus, 201);
    }
    public function update(Request $request, $id)
    {
        $reminderstatus = ReminderStatus::find($id);
        if (!$reminderstatus) 
            return response()->json(['message' => 'Reminder Status not found'], 404);
        $reminderstatus->update($request->all());
        return response()->json($reminderstatus);
    }
    public function destroy($id)
    {
        $reminderstatus = ReminderStatus::find($id);
        if (!$reminderstatus) 
            return response()->json(['message' => 'Reminder Status not found'], 404);
        $reminderstatus->delete();
        return response()->json(['message' => 'Reminder Status deleted successfully']);
    }
}
