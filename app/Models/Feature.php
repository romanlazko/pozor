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
        'translated_value' => 'array'
    ];

    protected $with = [
        'attribute',
    ];

    protected static function booted(): void
    {
        static::creating(function (Feature $feature) {
            
            // if ($feature->attribute->translatable) {
            //     $values = [
            //         'original' => $feature->translated_value['original']
            //     ];

            //     $values['en'] = Deepl::translateText($feature->translated_value['original'], null, 'en-US')->text;
            //     $values['ru'] = Deepl::translateText($feature->translated_value['original'], null, 'RU')->text;
            //     $values['cz'] = Deepl::translateText($feature->translated_value['original'], null, 'CS')->text;

            //     $feature->translated_value = $values;
            // }
        });
    }

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
        // $attribute_option = $this->attribute_option;
        
        // if ($attribute_option) {
        //     return $attribute_option->name;
        // }

        // $value = ($this->translated_value[app()->getLocale()] ?? $this->translated_value['original']);

        // if ($this->attribute->create_type == "between") {
        //     if (is_array($value)) {
        //         $value = $value['min'] . ' - ' . $value['max'];
        //     }
        // }

        // if ($this->attribute->create_type == "toggle") {
        //     $value = $this->attribute->label;
        // }

        // if ($this->attribute->create_type == "from") {
            
        //     if (is_array($value)) {
        //         $value = $value['from'] . ' - ' . $value['to'];
        //     }
        // }

        $class = "App\\AttributeType\\" . str_replace('_', '', ucwords($this->attribute->create_type, '_'));
        if (class_exists($class)) {
            return (new $class($this->attribute))->getValueByFeature($this);
        }

        return null;
    }

    public function getLabelAttribute()
    {
        return $this->attribute->label;
    }

    public function getSuffixAttribute()
    {
        return $this->attribute->suffix;
    }

    // public function getTranslatedValueAttribute()
    // {
    //     $attribute_options = $this->attribute->attribute_options;

    //     if ($attribute_options->isNotEmpty()) {
    //         return $attribute_options->find($this->value)?->name;
    //     }

    //     return json_decode($this->attributes['translated_value'], true)[app()->getLocale()] ?? $this->value;
    // }
}