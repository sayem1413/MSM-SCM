<?php

namespace App\Traits\Controller\Functions;

trait TraitRestDestroy
{
    public function destroy($id)
    {
        try {
            if(!isset($this->repository)){
                return $this->errorResponse('Repository not defined');
            }

            $entity = $this->repository->findById($id);
            if (!$entity) {
                return $this->notFoundResponse();
            }

            $response = $this->repository->delete($id);
            if (!$response) {
                return $this->errorResponse();
            }
            return $this->deleteResponse();
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
