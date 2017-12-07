<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Class_
 */
class Class_
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var bool
     */
    protected $abstract;

    /**
     * @var bool
     */
    protected $final;

    /**
     * @var Class_|string
     */
    protected $extends;

    /**
     * @var Interface_[]|string[]
     */
    protected $implements;

    /**
     * @var array
     */
    protected $constants;

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
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->abstract = false;
        $this->final = false;
        $this->implements = [];
        $this->properties = [];
        $this->methods = [];
        $this->constants = [];
    }

    /**
     * @return string|null
     */
    public function getNamespace()
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
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @param bool $abstract
     */
    public function setAbstract(bool $abstract)
    {
        $this->abstract = $abstract;
    }

    /**
     * @return bool
     */
    public function isFinal(): bool
    {
        return $this->final;
    }

    /**
     * @param bool $final
     */
    public function setFinal(bool $final)
    {
        $this->final = $final;
    }

    /**
     * @return Class_|string
     */
    public function getExtends()
    {
        return $this->extends;
    }

    /**
     * @param Class_|string $extends
     */
    public function setExtends($extends)
    {
        $this->extends = $extends;
    }

    /**
     * @param Interface_ $implement
     */
    public function implements(Interface_ $implement)
    {
        $this->implements[] = $implement;
    }

    /**
     * @param Interface_ $implement
     */
    public function removeImplement(Interface_ $implement)
    {
        $key = array_search($implement, $this->implements, true);
        if ($key !== false) {
            array_splice($this->implements, $key, 1);
        }
    }

    /**
     * @return array
     */
    public function getImplements(): array
    {
        return $this->implements;
    }

    /**
     * @param string $name
     * @param $value
     * @param Visibility|null $visibility
     * @param bool $static
     */
    public function addConstant(string $name, $value, Visibility $visibility = null, bool $static = false)
    {
        $this->constants[] = [
            'name' => $name,
            'value' => $value,
            'visibility' => $visibility,
            'static' => $static
        ];
    }

    /**
     * @return array
     */
    public function getConstants(): array
    {
        return $this->constants;
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
     * @return Property[]
     */
    public function getProperties(): array
    {
        return $this->properties;
    }

    /**
     * @param Method $method
     */
    public function addMethod(Method $method)
    {
        $this->methods[] = $method;
    }

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
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

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getFqn(): string
    {
        return sprintf('%s\\%s', $this->namespace, $this->name);
    }
}
