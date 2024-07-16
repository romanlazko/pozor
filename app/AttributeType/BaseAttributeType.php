<?php

namespace App\AttributeType;

use App\Models\Attribute;
use App\Models\Feature;
use Filament\Forms\Components\Component;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;

class BaseAttributeType
{
    public function __construct(public Attribute $attribute, public $data = [])
    {
    }

    public function applyQuery($query)
    {
        if ($this->isVisible() AND isset($this->data[$this->attribute->name]) AND !empty($this->data[$this->attribute->name]) AND $this->data[$this->attribute->name] != null) {
            return $this->apply($query);
        }

        return $query;
    }

    public function apply($query)
    {
        return $query;
    }

    public function getValueByFeature(Feature $feature = null)
    {
        return $feature->attribute_option?->name
            ?? $feature->translated_value[app()->getLocale()]
            ?? $feature->translated_value['original']
            ?? null;
    }

    public function getCreateSchema(): array
    {
        if ($this->attribute->attribute_options->isNotEmpty()) {
            return [
                'attribute_id' => $this->attribute->id,
                'attribute_option_id' => $this->data[$this->attribute->name],
            ];
        }

        return [
            'attribute_id' => $this->attribute->id,
            'translated_value'        => [
                'original' => $this->data[$this->attribute->name]
            ],
        ];
    }

    public function getCreateComponent(Get $get = null): ?ViewComponent
    {
        return $this->getFilamentCreateComponent($get);
    }

    public function getFilamentCreateComponent(Get $get = null): ?ViewComponent
    {
        return null;
    }

    public function getFilterComponent(Get $get = null): ?ViewComponent
    {
        if (!$this->attribute->filterable) {
            return null;
        }

        return $this->getFilamentFilterComponent($get);
    }

    public function getFilamentFilterComponent(Get $get = null): ?ViewComponent
    {
        return null;
    }

    public function isVisible(Get $get = null): bool
    {
        if (empty($this->attribute->visible)) {
            return true;
        }

        if ($this->checkCondition($get, $this->attribute->visible)) {
            return true;
        }

        return false;
    }

    public function isHidden(Get $get = null): bool
    {
        if (empty($this->attribute->hidden)) {
            return false;
        }

        if ($this->checkCondition($get, $this->attribute->hidden)) {
            return true;
        }

        return true;
    }

    private function checkCondition(Get $get, $conditions): bool
    {
        foreach ($conditions as $condition) {
            $value = $get ? $get($condition['attribute_name']) : data_get($this->data, $condition['attribute_name']);
            $altValue = $get ? $get('attributes.' . $condition['attribute_name']) : data_get($this->data, 'attributes.' . $condition['attribute_name']);
            
            if ($value == $condition['value'] || $altValue == $condition['value']) {
                return true;
            }
        }

        return false;
    }
}