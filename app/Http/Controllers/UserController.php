<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Factories\UserFactory;
use App\Http\Requests\LoginRequest;



class UserController extends Controller
{
    
    /**
     * handle login user.
     */
    public function login(LoginRequest $request, UserFactory $factory)
    {
        return $factory->login($request);
    }

    
    /**
     * handle login user.
     */
    public function logout(UserFactory $factory)
    {
        return $factory->logout();
    }
}
