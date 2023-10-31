<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SaveUserRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Role;
use App\Models\User;
use App\Traits\CheckRole;
use App\Traits\OutputListFormat;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use CheckRole;
    use OutputListFormat;


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
    public function store(SaveUserRequest $request)
    {
        try {
            if ($this->isAdmin($request->user())) {
                DB::beginTransaction();
                $user = User::saveOrUpdate($request);
                $role = Role::findByName($request->validated('role'));
                $user->assignRole($role);
                DB::commit();
                return ApiResponse::success($user, 'user created successfully');
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
    public function update(SaveUserRequest $request, string $id)
    {
        if ($this->isAdmin($request->user())) {
            $user = User::saveOrUpdate($request, $id);
            $roleName = $request->validated('role');
            if (isset($roleName)) {
                $role = Role::findByName($roleName);
                $roles = $user->getRoles();
                if (is_array($roles)) {
                    foreach ($user->getRoles() as $cureentRole) {
                        $user->removeRole($cureentRole);
                    }
                }
                $user->assignRole($role);
            }
            return ApiResponse::success($user);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();
        return ApiResponse::success($user);
    }
}
