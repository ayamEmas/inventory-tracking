<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = ['item', 'year', 'description', 'amount', 'department_id'];

    public function department () {
        return $this->belongsTo(department::class);
    }
}
