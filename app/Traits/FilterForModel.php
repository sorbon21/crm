<?php

namespace App\Traits;

use App\Enums\RBAC;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

trait FilterForModel
{
    public function applyFilters($query, $filters)
    {
        if (property_exists($this, 'fillable')) {
            $fillableFields = array_intersect_key($filters, array_flip($this->fillable));
            foreach ($fillableFields as $field => $value) {
                if (!is_null($value)) {
                    if (is_numeric($value) || is_bool($value)) {
                        $query->where($field, $value);
                    } else {
                        $query->where($field, 'LIKE', "%{$value}%");
                    }
                }
            }
        }
        if (!empty($this->relationsToLoad)) {
            $query->with($this->relationsToLoad);
        }
        return $query;
    }
}
