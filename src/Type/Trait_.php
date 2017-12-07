<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

class Trait_
{
    /**
     * @var string
     */
    protected $namespace;

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
     * @return string
     */
    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param string $namespace
     */
    public function setNamespace(string $namespace)
    {
        $this->namespace = $namespace;
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
        if ($key = array_search($property, $this->properties, true) !== false) {
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
        if ($key = array_search($method, $this->methods, true) !== false) {
            array_splice($this->methods, $key, 1);
        }
    }
}
