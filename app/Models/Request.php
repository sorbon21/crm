<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use FilterForModel;
    use HasFactory;
    use SaveModel;

    protected $table = 'request';

    protected $relationsToLoad = ['service', 'client', 'operator'];


    protected $fillable = [
        'service_id',
        'client_id',
        'operator_id',
        'comment_id',
        'type',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function operator()
    {
        return $this->belongsTo(User::class, 'operator_id');
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class, 'comment_id');
    }
}
