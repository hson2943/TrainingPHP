<?php

namespace App\Http\Controllers;

use App\Exceptions\UserNotFoundException;
use App\Http\Requests\AuthRequest;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected $authRepo;
    public function __construct(AuthRepositoryInterface $authRepo)
    {
        $this->authRepo = $authRepo;
    }

    /**
    * User login.
    *
    * @param \App\Http\Requests\AuthRequest $request The request object.
    *
    * @return \Illuminate\Http\JsonResponse
    *
    * @throws \App\Exceptions\UserNotFoundException
 */
    public function login(AuthRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->authRepo->login($data);
            $this->setResponse($result, true, Response::$statusTexts[Response::HTTP_OK]);
            return $this->getResponse($this->status, $this->message,$this->data);
        } catch (UserNotFoundException $exception) {
            throw $exception;
        }
    }

    /**
    * User logout.
    *
    * @param \Illuminate\Http\Request $request The request object.
    * 
    * @return mixed
    */
    public function logout(Request $request)
    {
        $userLogin = $request->user();
        return $this->authRepo->logout($userLogin);
    }

    /**
    * User registration.
    *
    * @param \Illuminate\Http\Request $request The request object.
    * 
    * @return \Illuminate\Http\JsonResponse
    * 
    * @throws \App\Exceptions\UserNotFoundException
    */
    public function register(Request $request)
    {
        try {
            $data = $request->all();
            $result = $this->authRepo->register($data);
            $this->setResponse($result, true, Response::$statusTexts[Response::HTTP_OK]);
            return $this->getResponse($this->data, $this->status, $this->message);
        } catch (UserNotFoundException $exception) {
            throw $exception;
        }
    }
}
