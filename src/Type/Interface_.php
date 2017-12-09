<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;
use JDWil\PhpGenny\Type\Traits\HasConstantsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\ValueObject\Visibility;

/**
 * Class Interface_
 */
class Interface_ implements NamespaceInterface, HasConstantsInterface
{
    use HasNamespaceTrait;
    use HasConstantsTrait;

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
     * @throws \Exception
     */
    public function addMethod(Method $method)
    {
        if ((string) $method->getVisibility() !== Visibility::PUBLIC) {
            throw new \Exception('Interface methods must be public');
        }

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
}
