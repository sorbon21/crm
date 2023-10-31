<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestStatus extends Model
{
    use HasFactory;
    use FilterForModel;
    use SaveModel;

    protected $table = 'request_status';
    protected $relationsToLoad = ['request', 'specialist', 'comment'];

    protected $fillable = [
        'request_id',
        'specialist_id',
        'comment_id',
        'status',
    ];

    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id');
    }

    public function specialist()
    {
        return $this->belongsTo(User::class, 'specialist_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
