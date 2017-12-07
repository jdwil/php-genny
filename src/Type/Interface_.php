<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

/**
 * Class Interface_
 */
class Interface_
{
    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Interface_[]|string[]
     */
    protected $extends;

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
        $this->extends = [];
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
     * @return Interface_[]
     */
    public function getExtends(): array
    {
        return $this->extends;
    }

    /**
     * @param Interface_ $extend
     */
    public function addExtend($extend)
    {
        $this->extends[] = $extend;
    }

    /**
     * @param Interface_ $extend
     */
    public function removeExtend(Interface_ $extend)
    {
        $key = array_search($extend, $this->extends, true);
        if ($key !== false) {
            array_splice($this->extends, $key, 1);
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

    /**
     * @return Method[]
     */
    public function getMethods(): array
    {
        return $this->methods;
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
