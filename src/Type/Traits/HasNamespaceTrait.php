<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

trait HasNamespaceTrait
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
