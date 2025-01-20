<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Room;
use App\Models\Position;
use App\Models\UserRoomEntry;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $positions = Position::all();
        $positions_number = [];
        foreach ($positions as $position) {   
            $count = 0;
            foreach (User::all() as $user) {
                if ($user['position_id'] == $position['id']) {
                    $count++;
                }
            }
            $positions_number[$position['id']] = $count;
        }

        $roomsToPositions = [];
        foreach ($positions as $position) {
            $isPositionInRoom = DB::table('position_room')
                ->where('position_id', $position['id'])
                ->select('room_id')
                ->get();

            $roomsToPositions[$position['id']] = [];

            foreach ($isPositionInRoom as $key => $value) {
                array_push($roomsToPositions[$position['id']], $value->room_id);
            }
        }

        if (auth()->user()) {
            return view('positions.index', [
                'positions' => $positions,
                'positions_number' => $positions_number,
                'room_to_positions' => $roomsToPositions,
                'users' => User::all(),
                'rooms' => Room::all(),
            ]);
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('positions.create', [
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
                    'name' => 'required|unique:positions,name',
                ]
            );
    
            Position::factory()->create([
                'name' => $validated['name'],
            ]);
            Session::flash('position_created');
            Session::flash('title',$validated['name']);
            return redirect()->route('positions.create');
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('positions.show', [
            'position' => Position::find($id),
            'users' => User::all(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('positions.edit', [
            'users' => User::all(),
            'position' => Position::find($id),
            'positions' => Position::all(),
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
                ]
            );

            $position = Position::find($id);
            $position->name = $validated['name'];
            $position->save();
    
            return redirect()->route('positions.index');
        }

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $position = Position::find($id);
            Session::flash('position_deleted', $position['name']);
            
            foreach (User::all() as $user) {
                if ($user['position_id'] == $id) {
                    $user['position_id'] = NULL;
                    $user->save();
                }
            }
            $position->delete();
            return redirect()->route('positions.index');
        }

        return redirect('/');

    }
}
