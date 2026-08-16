<?php

namespace App\Traits\Controller\Functions;

use Illuminate\Http\Request;

trait TraitRestShow
{
    public function show($id)
    {
        try {
            if(!isset($this->repository)){
                return $this->errorResponse('Repository not defined');
            }

            $result = $this->repository->show($id);
            $response = isset($this->resource) ? new $this->resource($result) : $result;
            return $this->successResourceResponse($response);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
