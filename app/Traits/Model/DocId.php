<?php

namespace App\Traits\Model;

use Illuminate\Support\Facades\Schema;

trait DocId
{
    protected static function bootDocId()
    {
        static::creating(function ($model) {
            if (Schema::hasColumn($model->getTable(), 'doc_id')) {
                $docIdPrefix = isset(self::$docIdPrefix) ? self::$docIdPrefix : '';
                $model->doc_id = $docIdPrefix . time();
            }
        });
    }
}
