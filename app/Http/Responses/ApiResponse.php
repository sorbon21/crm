<?php

namespace App\Http\Responses;

namespace App\Http\Responses;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;


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

    public static function error(Throwable $t = null, $message = null, $status = 400)
    {
        $outputMessage = $message;
        if ($t instanceof Throwable) {
            if (empty($message)) {
                $outputMessage = $t->getMessage();
            }
            Log::error($t);
        }
        return response()->json([
            'status' => 'error',
            'message' => $outputMessage
        ], $status);
    }

    public static function warning($message = null, $status = 200)
    {
        return response()->json([
            'status' => 'warning',
            'message' => $message
        ], $status);
    }
}
