<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Response;
use App\Http\Trait\ResponseTrait;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests, ResponseTrait;
    
    public $status;
    public $message;
    public $data;

    public function __construct()
    {
        $this->status = Response::HTTP_SERVICE_UNAVAILABLE;
        $this->message = __('api_auth.something_went_wrong');
        $this->data = [];
    }
}
