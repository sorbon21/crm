<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Comment;
use App\Traits\CheckRole;
use App\Traits\Pagination;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    use CheckRole;
    use Pagination;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            return $this->paginate($request, Comment::class);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $client = Comment::saveOrUpdate($request);
            return ApiResponse::success($client);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = Comment::find($id);
        return ApiResponse::success($client);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($this->isOperator($request->user()) || $this->isSpecialist($request->user())) {
            $client = Comment::saveOrUpdate($request, $id);
            return ApiResponse::success($client);
        }
        return ApiResponse::error(null, self::ACCESS_DENIED_MESSAGE);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Comment::find($id);
        $client->delete();
        return ApiResponse::success($client);
    }
}
