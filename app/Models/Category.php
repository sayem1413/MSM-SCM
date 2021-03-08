<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants\Common;
use App\Traits\Model\Autofill;
use App\Traits\Model\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends BaseModel
{
    use HasFactory, SoftDeletes, Autofill, Uuid;

    protected $guarded = [];

    protected $hidden = [
        'deleted_at'
    ];
}
