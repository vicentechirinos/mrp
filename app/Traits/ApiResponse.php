<?php

namespace App\Traits;

trait ApiResponse
{
    public function responseFormat($data, $message = '', $status = 200)
    {
        return response()->json([
            'data' => $data,
            'message' => $message
        ], $status);
    }
}
