<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Constants\Common;
use App\Traits\Model\Autofill;
use App\Traits\Model\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class Category extends BaseModel
{
    use HasFactory, SoftDeletes, Autofill, Uuid, NodeTrait;

    protected $guarded = [];

    /* protected $fillable = [
        'name',
        'description',
        '_lft',
        '_rgt',
        'parent_id',
        'image_path',
        'active',
    ]; */

    protected $hidden = [
        'deleted_at'
    ];
}
