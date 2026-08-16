<?php

namespace App\Models;

use App\Constants\Common;
use App\Traits\Model\Autofill;
use App\Traits\Model\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Adjustment extends BaseModel
{
    use  SoftDeletes, Autofill, Uuid;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at'
    ];

    protected $casts = [
        'id'              => 'integer',
        'employee_id'     => 'integer',
        'dealer_id'       => 'integer',
        'created_by'      => 'integer',
        'updated_by'      => 'integer',
        'status'          => 'integer',
        // Decimal
        'amount'          => 'decimal:4',
        //Date
        'date'            => 'date',
        //Date Time
        'created_at'      => 'datetime:Y-m-d H:i:s',
        'updated_at'      => 'datetime:Y-m-d H:i:s',
        // String
        'adjustment_type' => 'string',
        'note'            => 'string',
    ];

    protected $dates = [
        'created_at', 'updated_at', 'deleted_at'
    ];

    protected $attributes = [
        'status' => Common::STATUS_ACTIVE,
    ];

}
