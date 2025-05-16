<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name'];

    public function inventory() {
        return $this->hasMany(Inventory::class);
    }

    public function user() {
        return $this->hasMany(User::class);
    }
}
