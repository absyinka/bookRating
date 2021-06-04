<?php

namespace App\Interfaces;

use Illuminate\Http\Request;

interface IAuthInterface
{
    public function login(Request $request);

    public function register(Request $request);

    public function logout();

    public function refresh();

    public function userProfile();
}
