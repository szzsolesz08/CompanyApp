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

class SimulationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('simulation.index', [
            'users' => User::all(),
            'positions' => Position::all(),
            'rooms' => Room::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $validated = $request->validate(
                [
                    'user' => 'required',
                    'room' => 'required',
                ]
            );

            $user = User::find($validated['user']);
            $room = Room::find($validated['room']);

            $successful = DB::table('position_room')
                ->where('position_id', $user['position_id'])
                ->where('room_id', $room['id'])
                ->exists();
    
            UserRoomEntry::factory()->create([
                'user_id' => $validated['user'],
                'room_id' => $validated['room'],
                'successful' => $successful,
            ]);
            
            Session::flash('simulation_created');
            return redirect()->route('simulation.index');
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
