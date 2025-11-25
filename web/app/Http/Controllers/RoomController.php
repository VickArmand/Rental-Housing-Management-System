<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;

class RoomController extends Controller
{
    //
    public function index()
    {
        $rooms = Room::all();
        return response()->json($rooms);
    }
    public function show($id)
    {
        $room = Room::find($id);
        if (!$room) 
            return response()->json(['message' => 'Room not found'], 404);
        return response()->json($room);
    }
    public function store(Request $request)
    {
        $room = Room::create($request->all());
        return response()->json($room, 201);
    }
    public function update(Request $request, $id)
    {
        $room = Room::find($id);
        if (!$room) 
            return response()->json(['message' => 'Room not found'], 404);
        $room->update($request->all());
        return response()->json($room);
    }
    public function destroy($id)
    {
        $room = Room::find($id);
        if (!$room) 
            return response()->json(['message' => 'Room not found'], 404);
        $room->delete();
        return response()->json(['message' => 'Room deleted successfully']);
    }
}
