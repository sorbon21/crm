<?php

namespace App\Models;

use App\Traits\FilterForModel;
use App\Traits\SaveModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    use FilterForModel;
    use SaveModel;

    protected $relationsToLoad = ['phone'];

    protected $fillable = [
        'name',
        'phone_id',
    ];

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
