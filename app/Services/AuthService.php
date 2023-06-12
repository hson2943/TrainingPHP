<?php

namespace App\Services;

use App\Repositories\Auth\AuthRepositoryInterface;

class AuthService
{
    protected $auth_repo;


    public function __construct(AuthRepositoryInterface $auth_repo)
    {
        $this->auth_repo = $auth_repo;
    }

    /**
    * Authenticate user login.
    *
    * @param  array  $data
    * @return array
    *
    * @throws UserNotFoundException
    */
    function login($data)
    {
        return $this->auth_repo->login($data);
    }

    /**
    * Logout the authenticated user.
    *
    * @param  \App\Models\User  $userLogin
    
    * @return bool
    */
    function logout($userLogin){
        return $this->auth_repo->logout($userLogin);
    }
}
