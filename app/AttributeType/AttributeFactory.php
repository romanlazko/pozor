<?php

namespace App\AttributeType;

use App\Models\Attribute;
use App\Models\Feature;

class AttributeFactory
{
    static $namespace = 'App\\AttributeType\\';

    public static function getCreateComponent(Attribute $attribute)
    {
        $class = self::getNamespace($attribute->create_type);

        if (class_exists($class)) {
            return (new $class($attribute))->getCreateComponent();
        }

        return null;
    }

    public static function getFilterComponent(Attribute $attribute)
    {
        $class = self::getNamespace($attribute->search_type);
        
        if (class_exists($class)) {
            return (new $class($attribute))->getFilterComponent();
        }

        return null;
    }

    public static function applyQuery(Attribute $attribute, array|null $data = [], $query = null)
    {
        $class = self::getNamespace($attribute->search_type);

        if (class_exists($class)) {
            return (new $class($attribute, $data))->applyQuery($query);
        }

        return $query;
    }

    public static function getCreateSchema(Attribute $attribute, array $data = [])
    {
        $class = self::getNamespace($attribute->create_type);

        if (class_exists($class)) {
            return (new $class($attribute, $data))->getCreateSchema();
        }

        return null;
    }

    public static function getValueByFeature(Attribute $attribute, Feature $feature = null)
    {
        $class = self::getNamespace($attribute->create_type);

        if (class_exists($class)) {
            return (new $class($attribute))->getValueByFeature($feature);
        }

        return null;
    }

    private static function getNamespace(string $type)  : string
    {
        return self::$namespace . str_replace('_', '', ucwords($type, '_'));
    }
}