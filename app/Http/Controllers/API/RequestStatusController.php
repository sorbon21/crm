<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\SaveRequestStatusRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Phone;
use App\Models\RequestStatus;
use App\Traits\CheckRole;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class RequestStatusController extends Controller
{
    use CheckRole;
    use Pagination;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            return $this->paginate($request, RequestStatus::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveRequestStatusRequest $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $save = RequestStatus::saveOrUpdate($request);
            return ApiResponse::success($save);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $result = Phone::find($id);
        return ApiResponse::success($result);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveRequestStatusRequest $request, string $id)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
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
        $result = RequestStatus::find($id);
        $result->delete();
        return ApiResponse::success($result);
    }
}
