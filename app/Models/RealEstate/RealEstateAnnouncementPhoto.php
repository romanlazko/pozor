<?php

namespace App\Models\RealEstate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealEstateAnnouncementPhoto extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'src'
    ];
}
