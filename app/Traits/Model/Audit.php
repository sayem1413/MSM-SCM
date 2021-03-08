<?php

namespace App\Traits\Model;

use Illuminate\Support\Facades\Schema;
use App\Services\JwtService;

trait Audit
{
    protected static function bootAudit()
    {
        static::creating(function($model)  {
            $jwtService = new JwtService();
            $tokenInfo = $jwtService->getTokeInfo();

            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
            }
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
            }
        });

        static::updating(function($model)  {
            $jwtService = new JwtService();
            $tokenInfo = $jwtService->getTokeInfo();
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
            }
        });

        static::deleting(function($model) {
            $jwtService = new JwtService();
            $tokenInfo = $jwtService->getTokeInfo();
            if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
                $model->deleted_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
                $model->save();
            }
        });
    }

}
