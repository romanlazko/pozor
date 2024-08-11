<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

class Attribute extends Model
{
    use HasFactory; use SoftDeletes; use HasJsonRelationships;

    public $guarded = [];

    public $casts = [
        'alterlabels' => 'array',
        'visible' => 'array',
        'hidden' => 'array',
        'rules' => 'array',
        'altersuffixes' => 'array',
        'filter_layout' => 'array',
        'create_layout' => 'array',
        'show_layout' => 'array',
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
        return $this->altersuffixes[app()->getLocale()] ?? $this->altersuffixes['en'] ?? null;
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

    public function filterSection()
    {
        return $this->belongsTo(AttributeSection::class, 'filter_layout->section_id');
    }

    public function createSection()
    {
        return $this->belongsTo(AttributeSection::class, 'create_layout->section_id');
    }

    public function showSection()
    {
        return $this->belongsTo(AttributeSection::class, 'show_layout->section_id');
    }
}
