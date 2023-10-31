<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\LoginRequest;
use App\Http\Responses\ApiResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {

        try {
            $credentials = $request->validated();
            if (filter_var($credentials['login'], FILTER_VALIDATE_EMAIL)) {
                $credentials['email'] = $credentials['login'];
                unset($credentials['login']);
            }
            if (!$token = JWTAuth::attempt($credentials)) {
                return ApiResponse::warning('wrong input data', 401);
            }
            return ApiResponse::success(['token' => $token]);

        } catch (\Throwable $throwable) {
            return ApiResponse::error($throwable, 401);
        }
    }
}
