<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\SaveClientRequest;
use App\Http\Responses\ApiResponse;
use App\Models\Client;
use App\Traits\CheckRole;
use App\Traits\OutputListFormat;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    use CheckRole;
    use OutputListFormat;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            return $this->paginate($request, Client::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveClientRequest $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $client = Client::saveOrUpdate($request);
            return ApiResponse::success($client);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Client::find($id);
        return ApiResponse::success($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveClientRequest $request, string $id)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $client = Client::saveOrUpdate($request, $id);
            return ApiResponse::success($client);
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
