<?php

namespace App\Models\RealEstate;

use Akuechler\Geoly;
use App\Enums\RealEstate\AdditionalSpace;
use App\Enums\RealEstate\Condition;
use App\Enums\RealEstate\Equipment;
use App\Enums\RealEstate\Type;
use App\Enums\Status;
use App\Models\Traits\AnnouncementSearch;
use App\Models\Traits\AnnouncementTrait;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\AsEnumCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class RealEstateAnnouncement extends Model
{
    use HasFactory; use HasSlug; use SoftDeletes; use Geoly; use AnnouncementTrait; use AnnouncementSearch;

    protected $guarded = [];

    protected $casts = [
        'status_info' => 'array',
        'location' => 'array',
        'additional_spaces' => AsEnumCollection::class.':'.AdditionalSpace::class,
        'equipment' => Equipment::class,
        'type' => Type::class,
        'condition' => Condition::class,
        'status' => Status::class,
    ];

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('address')
            ->saveSlugsTo('slug');
    }

    public function getTitleAttribute()
    {
        return "{$this->type->name} {$this->configuration->name} {$this->square_meters}";
    }

    public function photos()
    {
        return $this->hasMany(RealEstateAnnouncementPhoto::class, 'announcement_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(RealEstateCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(RealEstateSubcategory::class);
    }

    public function configuration()
    {
        return $this->belongsTo(RealEstateConfiguration::class);
    }
}
