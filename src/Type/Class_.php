<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Type\Traits\HasConstantsTrait;
use JDWil\PhpGenny\Type\Traits\HasMethodsTrait;
use JDWil\PhpGenny\Type\Traits\HasNamespaceTrait;
use JDWil\PhpGenny\Type\Traits\HasPropertiesTrait;
use JDWil\PhpGenny\Type\Traits\HasTraitsTrait;

/**
 * Class Class_
 */
class Class_ implements HasConstantsInterface, HasTraitsInterface, HasPropertiesInterface, HasMethodsInterface
{
    use HasNamespaceTrait;
    use HasConstantsTrait;
    use HasTraitsTrait;
    use HasPropertiesTrait;
    use HasMethodsTrait;

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
     * Class_ constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
        $this->abstract = false;
        $this->final = false;
        $this->implements = [];
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
}
