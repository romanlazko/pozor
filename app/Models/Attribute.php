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
        'options' => 'array',
        'alterlabels' => 'array',
        'visible' => 'array'
    ];

    public function attribute_options()
    {
        return $this->hasMany(AttributeOption::class);
    }

    public function getLabelAttribute()
    {
        return $this->alterlabels[app()->getLocale()] ?? $this->attributes['label'];
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

    public function getFeaturedNameAttribute()
    {
        return $this->is_feature ? 'attributes.' . $this->name : $this->name;
    }
}
