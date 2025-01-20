<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Position;
use App\Models\UserRoomEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rooms = Room::all();
        $positionToRooms = [];
        foreach ($rooms as $room) {
            $isPositionInRoom = DB::table('position_room')
                ->where('room_id', $room['id'])
                ->select('position_id')
                ->get();
            
            $positionToRooms[$room['id']] = [];

            foreach ($isPositionInRoom as $key => $value) {
                array_push($positionToRooms[$room['id']], $value->position_id);
            }
        }

        return view('rooms.index', [
            'rooms' => $rooms,
            'position_to_rooms' => $positionToRooms,
            'users' => User::all(),
            'positions' => Position::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.create', [
            'users' => User::all(),
            'positions' => Position::all(),
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $validated = $request->validate(
                [
                    'name' => 'required|min:5',
                    'description' => '',
                    'room_image' => 'required|file|mimes:jpg,png|max:2048',
                ]
            );
            
            $room_image_path = '';
            if($request->hasFile('room_image')){
                $file = $request->file('room_image');
                $room_image_path = 'room_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
                Storage::disk('public')->put($room_image_path,$file->get());
            }

            $room = Room::factory()->create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'room_image_path' => $room_image_path === '' ? null : $room_image_path,
            ]);

            Session::flash('room_created');
            Session::flash('title',$validated['name']);
            return redirect()->route('rooms.create');
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('rooms.show', [
            'room' => Room::find($id),
            'users' => User::all(),
            'rooms' => Room::all(),
            'positions' => Position::all(),
            'entries' => UserRoomEntry::where('room_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('rooms.edit', [
            'users' => User::all(),
            'room' => Room::find($id),
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $validated = $request->validate(
                [
                    'name' => 'required',
                    'description' => '',
                    'room_image' => 'file|mimes:jpg,png|max:2048',
                ]
            );

            $room = Room::find($id);

            $room_image_path = $room->room_image_path;

            if($request->hasFile('room_image')){
                $file = $request->file('room_image');
                $room_image_path = 'room_image_'.Str::random(10).'.'.$file->getClientOriginalExtension();
                Storage::disk('public')->put($room_image_path,$file->get());
            }
    
            if($room_image_path != $room->room_image_path && $room->room_image_path != null) {
                Storage::disk('public')->delete($room->room_image_path);
            }
    
            $room->name = $validated['name'];
            $room->description = $validated['description'];
            $room->room_image_path = $room_image_path;
            $room->save();
    
            return redirect()->route('rooms.index');
        }

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $room = Room::find($id);
            Session::flash('room_deleted', $room['name']);
            
            DB::table('position_room')
                ->where('room_id', $room['id'])
                ->delete();
            
            DB::table('user_room_entries')
                ->where('room_id', $room['id'])
                ->delete();

            $room->delete();
            return redirect()->route('rooms.index');
        }

        return redirect('/');
    }
}
