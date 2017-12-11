<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\Type\Property;

/**
 * Trait HasPropertiesTrait
 */
trait HasPropertiesTrait
{
    /**
     * @var Property[]
     */
    protected $properties = [];

    /**
     * @param Property $property
     */
    public function addProperty(Property $property)
    {
        $this->properties[] = $property;
    }

    /**
     * @param Property $property
     */
    public function removeProperty(Property $property)
    {
        $key = array_search($property, $this->properties, true);
        if ($key !== false) {
            array_splice($this->properties, $key, 1);
        }
    }

    /**
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }
}
