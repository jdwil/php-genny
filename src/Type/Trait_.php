<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;

class Trait_ implements NamespaceInterface, HasTraitsInterface
{
    use HasNamespaceTrait;
    use HasTraitsTrait;

    /**
     * @var Property[]
     */
    protected $properties;

    /**
     * @var Method[]
     */
    protected $methods;

    /**
     * Class_ constructor.
     */
    public function __construct()
    {
        $this->properties = [];
        $this->methods = [];
    }

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
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    /**
     * @param Method $method
     */
    public function removeMethod(Method $method)
    {
        $key = array_search($method, $this->methods, true);
        if ($key !== false) {
            array_splice($this->methods, $key, 1);
        }
    }
}
