<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SaveClientRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Comment;
use App\Traits\CheckRole;
use App\Traits\OutputListFormat;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    use CheckRole;
    use OutputListFormat;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            return $this->paginate($request, \App\Models\Request::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveClientRequest $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $result = \App\Models\Request::saveOrUpdate($request);
            return ApiResponse::success($result);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = \App\Models\Request::find($id);
        return ApiResponse::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveClientRequest $request, string $id)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $result = \App\Models\Request::saveOrUpdate($request, $id);
            return ApiResponse::success($result);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = \App\Models\Request::find($id);
        $result->delete();
        return ApiResponse::success($result);
    }
}
