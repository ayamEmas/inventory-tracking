<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeletedInventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'purchase_order_no',
        'supplier_name',
        'supplier_email',
        'supplier_address',
        'supplier_contactno',
        'supplier_faxno',
        'department_id',
        'asset_location',
        'asset_to',
        'asset_code',
        'asset_cat',
        'asset_type',
        'item_location',
        'serial_num',
        'microsoft_office',
        'tel_number',
        'nos',
        'description',
        'amount',
        'item',
        'id_tag',
        'deleted_at'
    ];

    protected $casts = [
        'date' => 'date',
        'deleted_at' => 'datetime',
        'amount' => 'decimal:2'
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
