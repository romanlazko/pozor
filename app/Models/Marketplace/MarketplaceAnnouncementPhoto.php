<?php
namespace App\Models\Marketplace;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MarketplaceAnnouncementPhoto extends Model
{
    use HasFactory; use SoftDeletes;

    protected $fillable = [
        'src'
    ];
}
