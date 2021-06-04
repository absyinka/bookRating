<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interfaces\IAuthInterface;
use App\Traits\ResponseAPI;
use Exception;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthRepository implements IAuthInterface
{
    use ResponseAPI;

    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        if ($validator->fails()) {
            return $this->error($validator->errors(), 422);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password
        ]);

        return $this->success("User registered successfully!", $user);
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'required',
                    'password' => 'required|string|min:6',
                ]
            );

            if ($validator->fails()) {
                return $this->error($validator->errors(), 422);
            }

            $user = User::where('email', $request->email)->first();

            if ($user) {

                if (Hash::check($request->password, $user->password)) {
                    if (!$token = Auth::attempt($validator->validated())) {
                        return $this->error('Unauthorized', 401);
                    }

                    return $this->createNewToken($token);
                } else {
                    return $this->error('Invalid username or password', 422);
                }
            } else {
                return $this->error('User does not exist', 422);
            }
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function logout()
    {
        try {
            Auth::logout();
            return $this->simpleResponse('User successfully signed out', 200);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    public function refresh()
    {
        return $this->createNewToken(Auth::refresh());
    }

    public function userProfile()
    {
        $user_profile = DB::table('users')
            ->select('name', 'email')
            ->where('users.id', Auth::user()->id)
            ->get();

        return $this->success("User Profile:", $user_profile);
    }

    private function createNewToken($token)
    {
        return response()->json([
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'message'       => 'Login successful',
            'expires_in'    => Auth::factory()->getTTL() * 60
        ]);
    }
}
