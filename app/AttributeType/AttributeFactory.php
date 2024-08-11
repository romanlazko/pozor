<?php

namespace App\AttributeType;

use App\Models\Attribute;
use App\Models\Feature;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

class AttributeFactory
{
    static $namespace = 'App\\AttributeType\\';

    public static function getCreateComponent(Attribute $attribute) : ?ViewComponent
    {
        return self::getCreateClass($attribute)?->getCreateComponent();
    }

    public static function getFilterComponent(Attribute $attribute) : ?ViewComponent
    {
        return self::getFilterClass($attribute)?->getFilterComponent();
    }

    public static function applyQuery(Attribute $attribute, ?array $data = [], Builder $query = null) : ?Builder
    {
        return self::getFilterClass($attribute, $data)?->apply($query) ?? $query;
    }

    public static function getCreateSchema(Attribute $attribute, ?array  $data = []) : array
    {
        return self::getCreateClass($attribute, $data)?->getCreateSchema();
    }

    public static function getValueByFeature(Attribute $attribute, Feature $feature = null) : ?string
    {
        return self::getShowClass($attribute)?->getValueByFeature($feature);
    }

    private static function getShowClass(Attribute $attribute, ?array $data = []) : ?AbstractAttributeType
    {
        return self::getClass($attribute->show_layout, $attribute, $data);
    }

    private static function getCreateClass(Attribute $attribute, ?array $data = []) : ?AbstractAttributeType
    {
        return self::getClass($attribute->create_layout, $attribute, $data);
    }

    private static function getFilterClass(Attribute $attribute, ?array $data = []) : ?AbstractAttributeType
    {
        return self::getClass($attribute->filter_layout, $attribute, $data);
    }

    private static function getClass(?array $layout, Attribute $attribute, ?array $data = []) : ?AbstractAttributeType
    {
        $namespace = self::getNamespace($layout['type'] ?? 'hidden');

        if (class_exists($namespace)) {
            return new $namespace($attribute, $data);
        }

        return null;
    }

    private static function getNamespace(string $type) : string
    {
        return self::$namespace . str_replace('_', '', ucwords($type, '_'));
    }
}