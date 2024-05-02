<?php

namespace App\Models\Messanger;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thread extends Model
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [
        
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
