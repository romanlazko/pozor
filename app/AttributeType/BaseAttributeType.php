<?php

namespace App\AttributeType;

use App\Models\Feature;
use Filament\Forms\Get;

class BaseAttributeType
{
    public function __construct(public $attribute, public $data = [])
    {
    }

    public function apply($query)
    {
        return $query;
    }

    public function getValueByFeature(Feature $feature = null)
    {
        $attribute_option = $feature->attribute_option;
        
        if ($attribute_option) {
            return $attribute_option->name;
        }

        return $feature->translated_value[app()->getLocale()] ?? $feature->translated_value['original'] ?? null;
    }

    public function create()
    {
        if ($this->attribute->attribute_options->isNotEmpty()) {
            return [
                'attribute_id' => $this->attribute->id,
                'attribute_option_id' => $this->data[$this->attribute->name],
            ];
        }
        else {
            return [
                'attribute_id' => $this->attribute->id,
                'translated_value'        => [
                    'original' => $this->data[$this->attribute->name]
                ],
            ];
        }
    }

    public function getFilterComponent(Get $get = null)
    {
        return null;
    }

    public function getCreateComponent(Get $get = null)
    {
        return null;
    }

    public function isVisible(Get $get = null)
    {
        if (!empty($this->attribute->visible)) {
            foreach ($this->attribute->visible as $condition) {
                if ($get) {
                    if ($get($condition['attribute_name']) == $condition['value'] OR $get('attributes.'.$condition['attribute_name']) == $condition['value']) return true;
                }
                else {
                    if (data_get($this->data, $condition['attribute_name']) == $condition['value'] OR data_get($this->data, 'attributes.'.$condition['attribute_name']) == $condition['value']) return true;
                }
            }
            return false;
        }
        return true;
    }

    public function isHidden(Get $get = null)
    {
        if (!empty($this->attribute->hidden)) {
            foreach ($this->attribute->hidden as $condition) {
                if ($get) {
                    if ($get($condition['attribute_name']) == $condition['value'] OR $get('attributes.'.$condition['attribute_name']) == $condition['value']) return true;
                }
                else {
                    if (data_get($this->data, $condition['attribute_name']) == $condition['value'] OR data_get($this->data, 'attributes.'.$condition['attribute_name']) == $condition['value']) return true;
                }
            }
            return true;
        }
        return false;
    }
}