<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Position;
use App\Models\Room;
use App\Models\UserRoomEntry;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rooms = Room::factory(5)->create();

        $users = User::factory(10)->create();
        $admin = User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => 'admin',
            'admin' => 1,
        ]);

        $positions = Position::factory(4)->create();

        foreach ($users as $user) {
            $positions[rand(0, 3)]->user()->save($user);
        }

        $positions[rand(0, 3)]->user()->save($admin);

        foreach ($rooms as $room) {
            $randomPositions = $positions->random(rand(1, count($positions)))->pluck('id');
            $room->position()->attach($randomPositions);
            for ($i=0; $i < 5; $i++) { 
                $user = $users->random();

                // Fetch user's position ID
                $userPositionId = $user->position_id;

                // Check if user's position exists in room_position for the current room
                $isPositionInRoom = DB::table('position_room')
                    ->where('room_id', $room->id)
                    ->where('position_id', $userPositionId)
                    ->exists();

                if ($isPositionInRoom) {
                    UserRoomEntry::factory()->create([
                        'successful' => 1,
                        'user_id' => $user->id,
                        'room_id' => $room->id
                    ]);
                } else {
                    UserRoomEntry::factory()->create([
                        'successful' => 0,
                        'user_id' => $user->id,
                        'room_id' => $room->id
                    ]);
                }
            }
        }
    }
}
