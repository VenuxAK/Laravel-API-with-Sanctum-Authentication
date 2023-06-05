<?php

namespace App\Traits;

trait HttpResponse
{
    protected function success($data, $message = null, $code = 200)
    {
        return response()->json([
            "message" => $message,
            "status" => $code,
            "data" => $data
        ], $code);
    }
    protected function error($message = null, $code)
    {
        return response()->json([
            "message" => $message,
            "status" => $code,
        ], $code);
    }
}
