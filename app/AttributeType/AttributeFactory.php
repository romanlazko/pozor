<?php

namespace App\AttributeType;

use App\Models\Attribute;
use App\Models\Feature;
use Filament\Support\Components\ViewComponent;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static ?ViewComponent getCreateComponent(Attribute $attribute)
 * @method static ?ViewComponent getFilterComponent(Attribute $attribute)
 * @method static ?Builder applyQuery(Attribute $attribute, ?array $data = [], Builder $query = null)
 * @method static ?Builder applySortQuery(Attribute $attribute, string $destination, Builder $query = null)
 * @method static array getCreateSchema(Attribute $attribute, ?array  $data = [])
 * @method static ?string getValueByFeature(Attribute $attribute, Feature $feature = null)
 * @method static ?AbstractAttributeType __callStatic(string $name, array $arguments)
 */
class AttributeFactory
{
    static $namespace = 'App\\AttributeType\\';

    /**
     * @param Attribute $attribute
     * @return ?ViewComponent
     */
    public static function getCreateComponent(Attribute $attribute) : ?ViewComponent
    {
        return self::getCreateClass($attribute)?->getCreateComponent();
    }

    /**
     * @param Attribute $attribute
     * @return ?ViewComponent
     */
    public static function getFilterComponent(Attribute $attribute) : ?ViewComponent
    {
        return self::getFilterClass($attribute)?->getFilterComponent();
    }

    /**
     * @param Attribute $attribute
     * @param array|null $data
     * @param Builder|null $query
     * @return ?Builder
     */
    public static function applySearchQuery(Attribute $attribute, ?array $data = [], Builder $query = null) : ?Builder
    {
        return self::getFilterClass($attribute, $data)?->search($query) ?? $query;
    }

    /**
     * @param Attribute $attribute
     * @param array|null $data
     * @param Builder|null $query
     * @return ?Builder
     */
    public static function applyAlternativeSearchQuery(Attribute $attribute, ?array $data = [], Builder $query = null) : ?Builder
    {
        return self::getFilterClass($attribute, $data)?->alternativeSearch($query);
    }

    /**
     * @param Attribute $attribute
     * @param string $destination
     * @param Builder|null $query
     * @return ?Builder
     */
    public static function applySortQuery(Attribute $attribute, string $direction, Builder $query = null) : ?Builder
    {
        return self::getFilterClass($attribute)?->sort($query, $direction) ?? $query;
    }

    /**
     * @param Attribute $attribute
     * @param array|null $data
     * @return array
     */
    public static function getCreateSchema(Attribute $attribute, ?array  $data = []) : array
    {
        return self::getCreateClass($attribute, $data)?->getCreateSchema();
    }

    /**
     * @param Attribute $attribute
     * @param Feature|null $feature
     * @return ?string
     */
    public static function getValueByFeature(Attribute $attribute, Feature $feature = null) : ?string
    {
        return self::getShowClass($attribute)?->getValueByFeature($feature);
    }

    /**
     * @param string $name
     * @param array $arguments
     * @return ?AbstractAttributeType
     */
    public static function __callStatic($name, $arguments) : ?AbstractAttributeType
    {
        $layout =  str_replace('class', '_layout', str_replace('get', '', strtolower($name)));

        return self::getClass($arguments[0]->$layout, $arguments[0], $arguments[1] ?? null);
    }

    /**
     * Retrieves the class corresponding to the given layout and attribute, and creates an instance of it.
     *
     * @param array|null $layout The layout array containing the type of the attribute.
     * @param Attribute $attribute The attribute object.
     * @param array|null $data The optional data array.
     * @return AbstractAttributeType|null The instance of the attribute class, or null if the class does not exist.
     */
    private static function getClass(?array $layout, Attribute $attribute, ?array $data = []) : ?AbstractAttributeType
    {
        $namespace = self::getNamespace($layout['type'] ?? 'hidden');

        if (class_exists($namespace)) {
            return new $namespace($attribute, $data);
        }

        return null;
    }

    /**
     * Retrieves the namespace corresponding to the given type.
     *
     * @param string $type The type for which to retrieve the namespace.
     * @return string The namespace corresponding to the given type.
     */
    private static function getNamespace(string $type) : string
    {
        return self::$namespace . str_replace('_', '', ucwords($type, '_'));
    }
}
