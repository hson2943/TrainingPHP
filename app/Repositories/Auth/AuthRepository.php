<?php

namespace App\Repositories\Auth;

use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
        if (Auth::attempt($data)) {
            $user = Auth::user();
            $result['token'] = $user->createToken('User access token')->accessToken;
            $result['name'] = $user->name;
            return $result;
        }
        throw new UserNotFoundException();
    }

    /**
    * Logout the authenticated user.
    *
    * @param  \App\Models\User  $userLogin

    * @return bool
    */
    function logout($userLogin)
    {
        try {
            $userLogin->token()->revoke();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    
    /**
    * Register a new user.
    *
    * @param  array  $data
    
    * @return \App\Models\User
    */
    public function register($data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        return $user;
    }
}
