<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Lang;

class UserNotFoundException extends Exception
{
    public function report()
    {
    }

    public function render()
    {
        $response = [
            'status' => false,
            'message' => Lang::get('message.login_fail'),
            'data' => ''
        ];
        return $response;
    }
}
