<?php

namespace App\Http\Responses;

namespace App\Http\Responses;

class ApiResponse
{
    public static function success($data, $message = null, $status = 200)
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    public static function error($message = null, $status = 400)
    {
        return response()->json([
            'status' => 'error',
            'message' => $message
        ], $status);
    }
}
