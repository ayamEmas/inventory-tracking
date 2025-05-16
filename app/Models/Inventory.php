<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    
    protected $fillable = ['item', 'year', 'description', 'amount', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
