<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use JDWil\PhpGenny\Type\Traits\HasConstantsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Class_
 */
class Class_ implements NamespaceInterface, HasConstantsInterface, HasTraitsInterface
{
    use HasNamespaceTrait;
    use HasConstantsTrait;
    use HasTraitsTrait;

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

        foreach ($implement->getMethods() as $method) {
            if (!$this->hasMethod($method)) {
                $this->addMethod($method);
            }
        }
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
     * @return bool
     */
    public function hasMethod(Method $method): bool
    {
        foreach ($this->methods as $m) {
            if ($m->getName() === $method->getName()) {
                return true;
            }
        }

        return false;
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
