<?php

namespace App\AttributeType;

use App\Models\Attribute;
use App\Models\Feature;
use Filament\Forms\Components\Component;
use Filament\Forms\Get;
use Filament\Support\Components\ViewComponent;
use Illuminate\Contracts\Database\Query\Builder;

abstract class AbstractAttributeType
{
    public function __construct(public Attribute $attribute, public $data = [])
    {
    }

    public function apply($query) : Builder
    {
        if ($this->isVisible() AND isset($this->data[$this->attribute->name]) AND !empty($this->data[$this->attribute->name]) AND $this->data[$this->attribute->name] != null) {
            return $this->getQuery($query);
        }

        return $query;
    }

    public function getValueByFeature(Feature $feature = null) : ?string
    {
        return $feature->attribute_option?->name 
            ?? $this->getFeatureValue(
                $feature->translated_value[app()->getLocale()]
                ?? $feature->translated_value['original']
                ?? null
            );
    }

    public function getCreateSchema(): array
    {
        if ($this->isVisible()) {
            return $this->schema();
        }

        return null;
    }

    protected function schema(): array
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
        return $this->getFilamentCreateComponent($get)
            ?->columnSpan(['default' => 'full', 'sm' => $this->attribute->create_layout['column_span'] ?? 'full'])
            ?->columnStart(['default' => '1', 'sm' => $this->attribute->create_layout['column_start'] ?? '1'])
            ?->visible(fn (Get $get) => $this->isVisible($get))
            ?->hidden(fn (Get $get) => $this->isHidden($get));
    }

    public function getFilterComponent(Get $get = null): ?ViewComponent
    {
        if ($this->attribute->filter_layout['type'] == 'hidden') {
            return null;
        }

        return $this->getFilamentFilterComponent($get);
    }

    protected function isVisible(Get $get = null): bool
    {
        if (empty($this->attribute->visible)) {
            return true;
        }

        if ($this->checkCondition($get, $this->attribute->visible)) {
            return true;
        }

        return false;
    }

    protected function isHidden(Get $get = null): bool
    {
        if (empty($this->attribute->hidden)) {
            return false;
        }

        if ($this->checkCondition($get, $this->attribute->hidden)) {
            return true;
        }

        return false;
    }

    private function checkCondition(Get|null $get, $conditions): bool
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

    protected abstract function getQuery($query) : Builder;

    protected abstract function getFeatureValue(null|string|array $translated_value = null): ?string;

    protected abstract function getFilamentCreateComponent(Get $get = null): ?ViewComponent;

    protected abstract function getFilamentFilterComponent(Get $get = null): ?ViewComponent;
}