<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;
    use FilterForModel;
    use SaveModel;

    protected $table = 'service';
    protected $fillable = [
        'name',
    ];
}
