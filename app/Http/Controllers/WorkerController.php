<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use App\Models\Room;
use App\Models\Position;
use App\Models\UserRoomEntry;

class WorkerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()) {
            return view('workers.index', [
                'users' => User::all(),
                'positions' => Position::all(),
            ]);
        }
        return redirect('/');
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('workers.create', [
            'users' => User::all(),
            'positions' => Position::all(),
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
                    'name' => 'required',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required',
                    'admin' => 'required|boolean',
                    'phone_number' => 'required|regex:/^(\+?[0-9]{1,3})?[0-9]{10,12}$/',
                    'card_number' => 'nullable|string|size:16',
                    'position' => 'required|numeric|integer',
                ]
            );
    
            $user = User::factory()->create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'admin' => (bool) $validated['admin'],
                'phone_number' => $validated['phone_number'],
                'card_number' => $validated['card_number'],
            ]);
            isset($validated['position']) ? Position::find($validated['position'])->user()->save($user) : "";
            Session::flash('worker_created');
            Session::flash('title',$validated['name']);
            return redirect()->route('workers.create');
        }

        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('workers.show', [
            'user' => User::find($id),
            'users' => User::all(),
            'rooms' => Room::all(),
            'entries' => UserRoomEntry::where('user_id', $id)
                ->orderBy('created_at', 'desc')
                ->paginate(2),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('workers.edit', [
            'users' => User::all(),
            'user' => User::find($id),
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
                    'email' => 'required',
                    'password' => '',
                    'admin' => 'required|boolean',
                    'phone_number' => 'required|regex:/^(\+?[0-9]{1,3})?[0-9]{10,12}$/',
                    'card_number' => 'string|size:16',
                    'position' => 'required|numeric|integer',
                ]
            );

            $user = User::find($id);
            
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            if ($validated['password'] != "") {
                $user->password = Hash::make($validated['password']);
            }
            $user->admin = (bool) $validated['admin'];
            $user->phone_number = $validated['phone_number'];
            $user->card_number = $validated['card_number'];
            $user->save();
        
            isset($validated['position']) ? Position::find($validated['position'])->user()->save($user) : "";

            return redirect()->route('workers.index');
        }

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(string $id)
    {
        if (User::all()->find(auth()->id())['admin'] == 1) {
            $user = User::find($id);
            Session::flash('worker_deleted',$user['name']);
            
            $user->delete();
            return redirect()->route('workers.index');
        }

        return redirect('/');
    }
}
