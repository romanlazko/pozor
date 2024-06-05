<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory; use SoftDeletes;

    public $guarded = [];

    public $casts = [
        'alterlabels' => 'array',
        'visible' => 'array',
        'rules' => 'array',
        'altersyffixes' => 'array',
    ];

    public function getVisibleConditionAttribute()
    {
        return json_decode($this->attributes['visible'], true);
    }

    public function attribute_options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function getLabelAttribute()
    {
        return $this->alterlabels[app()->getLocale()] ?? $this->alterlabels['en'] ?? null;
    }

    public function getSuffixAttribute()
    {
        return $this->altersyffixes[app()->getLocale()] ?? $this->altersyffixes['en'] ?? null;
    }

    public function scopeFindByName($query, $name)
    {
        return $query->whereName($name)->first();
    }

    public function categories() 
    {
        return $this->belongsToMany(Category::class);
    }

    public function section()
    {
        return $this->belongsTo(AttributeSection::class, 'attribute_section_id');
    }
}
