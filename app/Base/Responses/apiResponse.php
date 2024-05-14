<?php

namespace App\Base\Responses;

use Symfony\Component\HttpFoundation\Response;

trait  apiResponse
{

    public function success(string $message, $data, int $status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => true,
            'status' => $status,
            'message' => $message,
            'data' => $data,
        ],$status);
    }

    public function fail(string $message ,int $status = Response::HTTP_OK)
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
        ],$status);
    }

    public function error(string $message ,$errors = null,int $status = Response::HTTP_UNPROCESSABLE_ENTITY)
    {
        return response()->json([
            'success' => false,
            'status' => $status,
            'message' => $message,
            'errors' => $errors,
        ],$status);
    }

}
