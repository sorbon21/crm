<?php

namespace App\Traits;

use App\Enums\RBAC;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait SaveModel
{

    public static function saveOrUpdate($request, $id = null)
    {
        $data = $request->only((new self)->getFillable());
        if ($id) {
            $model = self::find($id);
            if (!$model) {
                return false;
            }
            $model->update($data);
        } else {
            $model = new self($data);
            $model->save();
        }
        return $model;
    }
}
