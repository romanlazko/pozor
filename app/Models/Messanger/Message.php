<?php

namespace App\Models\Messanger;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [
        
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
