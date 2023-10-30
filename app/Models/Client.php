<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_id',
    ];

    public function phone()
    {
        return $this->belongsTo(Phone::class, 'phone_id');
    }
}
