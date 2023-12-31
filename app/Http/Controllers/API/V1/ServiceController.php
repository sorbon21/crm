<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SaveServiceRequest;
use App\Http\Responses\ApiResponse;
use App\Models\RequestStatus;
use App\Models\Service;
use App\Traits\CheckRole;
use App\Traits\OutputListFormat;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use CheckRole;
    use OutputListFormat;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isAdmin($request->user())) {
            return $this->full($request, Service::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveServiceRequest $request)
    {
        if ($this->isAdmin($request->user())) {
            $result = Service::saveOrUpdate($request);
            return ApiResponse::success($result);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Service::find($id);
        return ApiResponse::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveServiceRequest $request, string $id)
    {
        if ($this->isAdmin($request->user())) {
            $result = RequestStatus::saveOrUpdate($request, $id);
            return ApiResponse::success($result);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $result = Service::find($id);
        $result->delete();
        return ApiResponse::success($result);
    }
}
