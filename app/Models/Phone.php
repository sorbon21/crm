<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phone extends Model
{
    use HasFactory;
    use FilterForModel;
    use SaveModel;


    protected $fillable = [
        'country_code',
        'phone',
        'verified',
        'verify_code',
    ];
}
