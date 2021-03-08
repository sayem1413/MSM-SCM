<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function setCreatedAtAttribute($date)
    {
        $createdAt = Carbon::createFromFormat($this->getDateFormat(), $date)
            ->setTimezone('Asia/Dhaka')
            ->format('Y-m-d H:i:s');

        $this->attributes['created_at'] = $createdAt;
    }

    public function setUpdatedAtAttribute($date)
    {
        $updatedAt = Carbon::createFromFormat($this->getDateFormat(), $date)
            ->setTimezone('Asia/Dhaka')
            ->format('Y-m-d H:i:s');

        $this->attributes['updated_at'] = $updatedAt;
    }

}
