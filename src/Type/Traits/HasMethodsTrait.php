<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type\Traits;

use JDWil\PhpGenny\Type\Method;

/**
 * Trait HasMethodsTrait
 */
trait HasMethodsTrait
{
    /**
     * @var Method[]
     */
    protected $methods = [];

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
