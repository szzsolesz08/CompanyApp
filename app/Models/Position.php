<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    use HasFactory;

    public function user() {
        return $this->hasMany(User::class);
    }

    public function room() {
        return $this->hasMany(Room::class);
    }
}
