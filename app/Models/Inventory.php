<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';
    
    protected $fillable = ['date', 'description', 'amount', 'department_id', 'purchase_order_no', 'supplier_name', 'supplier_email', 'supplier_address', 'supplier_contactno',
                            'supplier_faxno', 'asset_location', 'asset_to', 'asset_code', 'asset_cat', 'asset_type', 'item_location', 'serial_num', 'microsoft_office',
                            'tel_number', 'nos', 'item', 'id_tag', 'image'];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
