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

    public static function __callStatic($name, $arguments) : ?AbstractAttributeType
    {
        $layout =  str_replace('class', '_layout', str_replace('get', '', strtolower($name)));

        return self::getClass($arguments[0]->$layout, $arguments[0], $arguments[1] ?? null);
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