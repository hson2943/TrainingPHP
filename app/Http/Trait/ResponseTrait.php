<?php

namespace App\Http\Trait;


trait ResponseTrait
{
    public function setResponse($status, $message, $data)
    {
        $this->data = $data;
        $this->status = $status;
        $this->message = $message;
    }

    public function getResponse($status, $message,$data)
    {
        return response()->json([
            'data' => $data,
            'message' => $message,
            'status' => $status
        ]);
    }
}
