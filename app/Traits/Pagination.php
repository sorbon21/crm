<?php

namespace App\Traits;

use App\Enums\RBAC;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait Pagination
{

    const PER_PAGE = 24;

    public function paginate(Request $request, string $ModelClass)
    {
        $page = $request->get('page', 1);
        $modelInstance = new $ModelClass();
        $query = $modelInstance->query();
        $query = $modelInstance->applyFilters($query, $request->all());
        $result = $query->paginate(self::PER_PAGE, ['*'], 'page', $page);
        return ApiResponse::success($result);
    }
}
