<?php
namespace App\Repositories\Auth;

interface AuthRepositoryInterface
{
    public function login($data);
    public function logout($userLogin);
    public function register($data);
}
