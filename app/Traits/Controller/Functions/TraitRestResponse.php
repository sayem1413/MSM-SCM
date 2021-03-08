<?php

namespace App\Traits\Controller\Functions;

use App\Exceptions\ErrorException;
use App\Exceptions\NotFoundException;
use App\Exceptions\PermissionException;
use App\Exceptions\AuthenticationException;

trait TraitRestResponse
{
    protected function successResponse($data)
    {
        $response = [
            'code' 		=> 200,
            'status' 	=> 'success',
            'data' 		=> $data
        ];

		return response()->json($response['data'], $response['code'] );
    }

    protected function parseResponseDataToArray($data)
    {
        $jsonResponse = response()->json($data)->getData();
        return json_decode(json_encode($jsonResponse), true);
    }

    protected function successResourceResponse($data)
    {
        $dataArray = $this->parseResponseDataToArray($data);
        $resourceData = $this->resource::withMicroServiceRelationalData($dataArray);

        $response = [
            'code' 		=> 200,
            'status' 	=> 'success',
            'data' 		=> $resourceData
        ];

        return response()->json($response['data'], $response['code'] );
    }

    protected function successResourceCollectionResponse($data)
    {
        $dataArray = $this->parseResponseDataToArray($data);
        $dataArray['results'] = $this->resource::withMicroServiceRelationalData($dataArray['results']);

        $response = [
            'code' 		=> 200,
            'status' 	=> 'success',
            'data' 		=> $dataArray
        ];

        return response()->json($response['data'], $response['code'] );
    }

    protected function notFoundResponse()
    {
        $response = [
            'code' 		=> 404,
            'status'	=> 'error',
            'data' 		=> 'Resource Not Found',
            'message' 	=> 'Not Found'
        ];

        throw new NotFoundException($response['data']);
    }

    protected function authenticationRequiredResponse()
    {
        $response = [
            'code' 		=> 401,
            'status' 	=> 'error',
            'data' 		=> 'Authentication Required',
            'message' 	=> 'Unauthorized'
        ];

        throw new AuthenticationException($response['data']);
    }

    protected function forbiddenResponse()
    {
        $response = [
            'code' 		=> 403,
            'status' 	=> 'error',
            'data' 		=> 'Forbidden Request',
            'message' 	=> 'Forbidden'
        ];

        throw new PermissionException($response['data']);
    }

    protected function deleteResponse()
    {
        $response = [
            'code' 		=> 204,
            'status' 	=> 'success',
            'data' 		=> [],
            'message' 	=> 'Delete Successfully !'
        ];

        return response()->json($response['data'], $response['code'] );
    }

    protected function emptyResponse()
    {
        $response = [
            'code' 		=> 204,
            'status'	=> 'success',
            'data' 		=> [],
            'message' 	=> 'Resource Empty'
        ];

        return response()->json($response['data'], $response['code'] );
    }

    protected function errorResponse($data = null)
    {
        $response = [
            'code' 		=> 422,
            'status' 	=> 'error',
            'data' 		=> $data,
            'message' 	=> 'Unprocessable Entity'
        ];

        throw new ErrorException($response['data']);
    }
}
