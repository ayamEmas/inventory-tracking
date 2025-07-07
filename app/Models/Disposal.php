<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    protected $table = 'disposals';
    
    protected $fillable = [
        'registrationSerialNum',
        'assetDescrip',
        'acquisitionDate',
        'assetAge',
        'oriCost',
        'currentValue',
        'stateAsset',
        'disposalMethod',
        'justification',
        'notes',
        'supervisor1',
        'name1',
        'remarks1'
    ];

    protected $casts = [
        'acquisitionDate' => 'date',
        'assetAge' => 'integer',
        'oriCost' => 'double',
        'currentValue' => 'double',
        'remarks1' => 'integer'
    ];
} 