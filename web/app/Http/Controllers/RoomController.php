<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use Illuminate\Support\Facades\Auth;
use App\Models\Error;
use ReflectionClass;

class RoomController extends Controller
{
    //
    public function index()
    {
        try {
            $rooms = Room::all();
            return response()->json($rooms);
        } catch (\Exception $e) {
            Error::saveError('RoomController@index', [], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching rooms'], 500);
        }
    }
    public function show(string $id)
    {
        try {
            $room = Room::find($id);
            if (!$room) 
                return response()->json(['message' => 'Room not found'], 404);
            return response()->json($room);
        } catch (\Exception $e) {
            Error::saveError('RoomController@show', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while fetching room'], 500);
        }
    }
    public function store(Request $request)
    {
        try {
            $room = Room::create($request->all());
            $room->created_by = Auth::user()->id;
            $room->save();
            return response()->json($room, 201);
        } catch (\Exception $e) {
            Error::saveError('RoomController@store', $request->all(), (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while saving room'], 500);
        }
    }
    public function update(Request $request, string $id)
    {
        try {
            $room = Room::find($id);
            if (!$room) 
                return response()->json(['message' => 'Room not found'], 404);
            $room->update($request->all());
            $room->updated_by = Auth::user()->id;
            $room->save();
            return response()->json($room);
        } catch (\Exception $e) {
            Error::saveError('RoomController@update', ['id' => $id, 'data' => $request->all()], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while updating room'], 500);
        }
    }
    public function destroy(string $id)
    {
        try {
            $room = Room::find($id);
            if (!$room) 
                return response()->json(['message' => 'Room not found'], 404);
            $room->delete();
            return response()->json(['message' => 'Room deleted successfully']);
        } catch (\Exception $e) {
            Error::saveError('RoomController@destroy', ['id' => $id], (new ReflectionClass($e))->getShortName(), $e->getMessage());
            return response()->json(['message' => 'Error occurred while deleting room'], 500);
        }
    }
}
