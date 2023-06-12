<?php
namespace App\Http\Controllers;

use Illuminate\Http\Response;

class ApisHandleResponse
{
    /**
     * Return data json response
     * 
     * @var int $status
     * 
     * @var string $message
     * 
     * @var array $data
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public static function jsonResponse(int $status = Response::HTTP_OK, string $message = "", array $data = [])
    {
        return response()->json([
            'status' => $status,
            'message' => $message,
            'data' => $data
        ]);
    }
}
?>