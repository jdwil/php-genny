<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

/**
 * Interface HasPropertiesInterface
 */
interface HasPropertiesInterface extends NamespaceInterface
{
    /**
     * @param Property $property
     */
    public function addProperty(Property $property);

    /**
     * @param Property $property
     */
    public function removeProperty(Property $property);

    /**
     * @return Property[]
     */
    public function getProperties(): array;
}
