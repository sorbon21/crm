<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\CreateUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Client;
use App\Models\User;
use App\Services\UserService;
use App\Traits\CheckRole;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use CheckRole;
    use Pagination;

    public function __construct(private readonly UserService $userService)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isAdmin($request->user())) {
            return $this->paginate($request, User::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        try {
            if ($this->isAdmin($request->user())) {
                DB::beginTransaction();
                $user = User::saveOrUpdate($request);
                DB::commit();
                return ApiResponse::success([$user], 'user created successfully');
            } else {
                throw new Exception(self::ACCESS_DENIED_MESSAGE);
            }
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return ApiResponse::error($throwable);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        if ($this->isAdmin($request->user())) {
            $user = User::find($id);
            return ApiResponse::success($user);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($this->isAdmin($request->user())) {
            $user = User::saveOrUpdate($id);
            return ApiResponse::success($user);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::find($id);
        $client->delete();
        return ApiResponse::success($client);
    }


}
