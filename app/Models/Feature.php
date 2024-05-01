<?php

namespace App\Models;

use App\Facades\Deepl;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Feature extends Pivot
{
    use HasFactory; use SoftDeletes;

    protected $guarded = [];

    // protected $casts = [
    //     'value' => 'array'
    // ];

    protected static function booted(): void
    {
        static::creating(function (Feature $feature) {
            if ($feature->attribute->translatable) {
                $feature->value = json_encode([
                    'en' => Deepl::translateText($feature->value, null, 'en-US')->text,
                    'ru' => Deepl::translateText($feature->value, null, 'RU')->text,
                    'cz' => Deepl::translateText($feature->value, null, 'CS')->text,
                ]);
            }
        });
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class)->with('attribute_options');
    }

    public function getLabelAttribute()
    {
        return $this->attribute->label;
    }

    public function getValueAttribute()
    {
        if ($this->attribute->attribute_options->isNotEmpty()) {
            return $this->attribute->attribute_options->find($this->attributes['value'])?->name;
        } else if ($this->attribute->translatable AND Str::isJson($this->attributes['value'])) {
            $decoded = json_decode($this->attributes['value'], true);

            return $decoded[app()->getLocale()] ?? $decoded['en'];
        }

        return $this->attributes['value'];
    }

    public function getNotFormatedValueAttribute()
    {
        if ($this->attribute->translatable AND Str::isJson($this->attributes['value'])) {
            $decoded = json_decode($this->attributes['value'], true);

            return $decoded[app()->getLocale()] ?? $decoded['en'];
        }

        return $this->attributes['value'];
    }
}
