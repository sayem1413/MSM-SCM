<?php

namespace App\Traits\Model;

use Illuminate\Support\Facades\Schema;
use App\Services\JwtService;

trait Autofill
{
    protected static function bootAutofill()
    {
        static::creating(function($model)  {
            $jwtService = new JwtService();
            $tokenInfo = $jwtService->getTokeInfo();
            $userId = isset($tokenInfo->id) ? $tokenInfo->id : null;
            $workspaceId = isset($tokenInfo->workspace_id) ? $tokenInfo->workspace_id : null;

            if (Schema::hasColumn($model->getTable(), 'user_id')) {
                $model->user_id = isset($model->user_id) ? $model->user_id : $userId;
            }
            if (Schema::hasColumn($model->getTable(), 'created_by')) {
                $model->created_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
            }
            if (Schema::hasColumn($model->getTable(), 'updated_by')) {
                $model->updated_by = isset($tokenInfo->id) ? $tokenInfo->id : null;
            }
            if (Schema::hasColumn($model->getTable(), 'workspace_id')) {
                $model->workspace_id = isset($model->workspace_id) ? $model->workspace_id : $workspaceId;
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
