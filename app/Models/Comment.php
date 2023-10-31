<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    use FilterForModel;
    use SaveModel;

    protected $table = 'comment';
    protected $fillable = [
        'content',
    ];
}
