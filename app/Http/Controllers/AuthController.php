<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\IAuthInterface;

/**
 * @group Authentication
 *
 * API endpoints for managing authentication
 */
class AuthController extends Controller
{
    protected $authInterface;

    public function __construct(IAuthInterface $authInterface)
    {
        $this->authInterface = $authInterface;
    }

    /**
     * @OA\Post(
     * path="/register",
     * summary="Register user",
     * description="Provide name, email and password to register user",
     * operationId="authRegister",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Provide user details for registration",
     *    @OA\JsonContent(
     *       required={"name","email","password"},
     *       @OA\Property(property="name", type="string", example="name"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password123")
     *    ),
     * ),
     * 
     * @OA\Response(
     *    response=200,
     *    description="User registered successfully!",
     *    @OA\JsonContent(
     *       @OA\Property(property="name", type="string", example="user"),
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="updated_at", type="string", example="2021-06-02T19:08:17.000000Z"),  
     *       @OA\Property(property="created_at", type="string", example="2021-06-02T19:08:17.000000Z"),  
     *       @OA\Property(property="id", type="string", format="integer", example="1")
     *        )
     *     ),
     * 
     * @OA\Response(
     *    response=422,
     *    description="Fields are required",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="fields are required")
     *        )
     *     ),
     * )
     */
    public function register(Request $request)
    {
        return $this->authInterface->register($request);
    }

    /**
     * @OA\Post(
     * path="/login",
     * summary="Authenticate user",
     * description="Login by email, password",
     * operationId="authLogin",
     * tags={"Auth"},
     * @OA\RequestBody(
     *    required=true,
     *    description="Pass user credentials",
     *    @OA\JsonContent(
     *       required={"email","password"},
     *       @OA\Property(property="email", type="string", format="email", example="user@email.com"),
     *       @OA\Property(property="password", type="string", format="password", example="password123"),
     *       @OA\Property(property="persistent", type="boolean", example="true"),
     *    ),
     * ),
     * @OA\Response(
     *    response=422,
     *    description="Wrong credentials response",
     *    @OA\JsonContent(
     *       @OA\Property(property="message", type="string", example="email required, password is required")
     *        )
     *     ),
     * )
     */
    public function login(Request $request)
    {
        return $this->authInterface->login($request);
    }

    /**
     * @OA\Post(
     * path="/logout",
     * summary="Logout authenticated user",
     * description="Logout user",
     * operationId="authLogout",
     * tags={"Auth"},
     * @OA\Response(
     *    response=401,
     *    description="Unauthenticated"
     *   ),
     * )
     */
    public function logout()
    {
        return $this->authInterface->logout();
    }

    public function refresh()
    {
        return $this->authInterface->refresh();
    }

    /**
     * @OA\Get(
     *      path="/user-profile",
     *      operationId="displayUserProfile",
     *      tags={"Profile"},
     *      summary="Show user profile",
     *      description="Display user profile",
     *      @OA\Response(
     *          response=200,
     *          description="User Profile",
     *          @OA\JsonContent(
     *              @OA\Property(property="name", type="string", example="ade"),
     *              @OA\Property(property="email", type="string", example="user@email.com")
     *              )
     *       ),
     *     )
     */
    public function userProfile()
    {
        return $this->authInterface->userProfile();
    }
}
