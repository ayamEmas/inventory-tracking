<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Disposal extends Model
{
    
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
        'supervisor2',
        'supervisor3',
        'name1',
        'name2',
        'name3',
        'remarks1',
        'remarks2',
        'remarks3'
    ];

    protected $casts = [
        'acquisitionDate' => 'date',
        'assetAge' => 'integer',
        'oriCost' => 'double',
        'currentValue' => 'double',
        'remarks1' => 'integer',
        'remarks2' => 'integer',
        'remarks3' => 'integer'
    ];
} 