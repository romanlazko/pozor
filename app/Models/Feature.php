<?php

namespace App\Models;

use App\Facades\Deepl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feature extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'value' => 'array'
    ];

    protected $with = [
        'attribute',
    ];

    protected static function booted(): void
    {
        static::creating(function (Feature $feature) {
            $value = [
                'original' => $feature->original_value,
            ];
            // dd($announcementAttribute->value);
            if ($feature->attribute->translatable) {
                $value['en'] = Deepl::translateText($feature->original_value, null, 'en-US')->text;
                $value['ru'] = Deepl::translateText($feature->original_value, null, 'RU')->text;
                $value['cz'] = Deepl::translateText($feature->original_value, null, 'CS')->text;
            }
            $feature->value = $value;
        });


        static::updating(function (Feature $feature) {
            $value = [
                'original' => $feature->original_value,
            ];
            if ($feature->attribute->translatable) {
                $value['en'] = Deepl::translateText($feature->original_value, null, 'en-US')->text;
                $value['ru'] = Deepl::translateText($feature->original_value, null, 'RU')->text;
                $value['cz'] = Deepl::translateText($feature->original_value, null, 'CS')->text;
            }
            $feature->value = $value;
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class)->with('attribute_options:id,name,attribute_id,alternames', 'section:order_number');
    }

    public function getLabelAttribute()
    {
        return $this->attribute->label;
    }

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
        $attribute_options = $this->attribute->attribute_options;

        if ($attribute_options->isNotEmpty()) {
            return $attribute_options->find(json_decode($this->attributes['value'], true)['original'])?->name;
        }

        return json_decode($this->attributes['value'], true)[app()->getLocale()] ?? json_decode($this->attributes['value'], true)['original'];
    }
}