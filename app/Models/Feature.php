<?php

namespace App\Models;

use App\AttributeType\AttributeFactory;
use App\Facades\Deepl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'translated_value' => 'array'
    ];

    protected $with = [
        'attribute',
    ];

    // protected static function booted(): void
    // {
    //     static::creating(function (Feature $feature) {
            
    //         if ($feature->attribute->translatable) {
    //             $values = [
    //                 'original' => $feature->translated_value['original']
    //             ];

    //             $values['en'] = Deepl::translateText($feature->translated_value['original'], null, 'en-US')->text;
    //             $values['ru'] = Deepl::translateText($feature->translated_value['original'], null, 'RU')->text;
    //             $values['cs'] = Deepl::translateText($feature->translated_value['original'], null, 'CS')->text;

    //             $feature->translated_value = $values;
    //         }
    //     });
    // }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }

    public function attribute_option()
    {
        return $this->belongsTo(AttributeOption::class);
    }

    public function getValueAttribute()
    {
        return AttributeFactory::getValueByFeature($this->attribute, $this);
    }

    public function getLabelAttribute()
    {
        return $this->attribute->label;
    }

    public function getSuffixAttribute()
    {
        return $this->attribute->suffix;
    }
}