<?php

namespace App\Models;

use App\Facades\Deepl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AnnouncementAttribute extends Pivot
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'value' => 'array'
    ];

    protected $with = [
        'attribute'
    ];

    protected static function booted(): void
    {
        static::creating(function (AnnouncementAttribute $announcementAttribute) {
            $value = [
                'original' => $announcementAttribute->original_value,
            ];
            // dd($announcementAttribute->value);
            if ($announcementAttribute->attribute->translatable) {
                $value['en'] = Deepl::translateText($announcementAttribute->original_value, null, 'en-US')->text;
                $value['ru'] = Deepl::translateText($announcementAttribute->original_value, null, 'RU')->text;
                $value['cz'] = Deepl::translateText($announcementAttribute->original_value, null, 'CS')->text;
            }
            $announcementAttribute->value = $value;
        });


        static::updating(function (AnnouncementAttribute $announcementAttribute) {
            $value = [
                'original' => $announcementAttribute->original_value,
            ];
            if ($announcementAttribute->attribute->translatable) {
                $value['en'] = Deepl::translateText($announcementAttribute->original_value, null, 'en-US')->text;
                $value['ru'] = Deepl::translateText($announcementAttribute->original_value, null, 'RU')->text;
                $value['cz'] = Deepl::translateText($announcementAttribute->original_value, null, 'CS')->text;
            }
            $announcementAttribute->value = $value;
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class)->with('attribute_options');
    }

    // public function getLabelAttribute()
    // {
    //     return $this->attribute->label;
    // }

    public function getValueAttribute()
    {
        return $this->formated_value;
    }

    public function getOriginalValueAttribute()
    {
        return json_decode($this->attributes['value'], true)['original'];
    }

    public function getFormatedValueAttribute()
    {
        if ($this->attribute->attribute_options->isNotEmpty()) {
            return $this->attribute->attribute_options->find(json_decode($this->attributes['value'], true)['original'])?->name;
        } 
        return json_decode($this->attributes['value'], true)[app()->getLocale()] ?? json_decode($this->attributes['value'], true)['original'];
    }
}