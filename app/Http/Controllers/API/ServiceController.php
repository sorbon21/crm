<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Phone;
use App\Models\RequestStatus;
use App\Models\Service;
use App\Traits\CheckRole;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use CheckRole;
    use Pagination;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isAdmin($request->user())) {
            return $this->paginate($request, Service::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->isAdmin($request->user())) {
            $client = Service::saveOrUpdate($request);
            return ApiResponse::success($client);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Service::find($id);
        return ApiResponse::success($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($this->isAdmin($request->user())) {
            $client = RequestStatus::saveOrUpdate($request, $id);
            return ApiResponse::success($client);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Service::find($id);
        $client->delete();
        return ApiResponse::success($client);
    }
}
