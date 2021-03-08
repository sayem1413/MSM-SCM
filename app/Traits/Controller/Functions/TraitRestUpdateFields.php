<?php

namespace App\Traits\Controller\Functions;

use App\Exceptions\ValidatorException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

trait TraitRestUpdateFields
{
    public function updateFields(Request $request, $id)
    {
        try {
            if(!isset($this->repository)){
                return $this->errorResponse('Repository not defined');
            }

            $updateFields = isset($this->updateFields) ?  $request->only($this->updateFields) : [];
            $rules = $this->validator->rules();
            $updatedRules = [];
            foreach ($updateFields AS $key => $value) {
                if (isset($rules[$key]) && $rules[$key]) {
                    $updatedRules[$key] = $rules[$key];
                }
            }

            if (isset($this->validator)) {
                $this->validate($request, $updatedRules, $this->validator->messages());
            }

            $response = $this->repository->update($updateFields, $id);
            return $this->successResponse($response);
        }
        catch (ValidationException $e) {
            throw new ValidatorException($e);
        }
        catch (\Exception $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
