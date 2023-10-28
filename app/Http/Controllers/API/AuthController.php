<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginRequest;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        if (filter_var($credentials['login'], FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $credentials['login'];
            unset($credentials['login']);
        }
        if (!$token = JWTAuth::attempt($credentials)) {
            return ApiResponse::error('wrong input data', 401);
        }
        return ApiResponse::success(['token' => $token]);
    }
}
