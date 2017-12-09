<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\ValueObject\InternalType;

class Parameter
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var InternalType|string
     */
    protected $type;

    /**
     * @var mixed
     */
    protected $defaultValue;

    /**
     * Parameter constructor.
     * @param string $name
     * @param $type
     * @param null $defaultValue
     */
    public function __construct(string $name, $type, $defaultValue = null)
    {
        if ($name[0] === '$') {
            $name = (string) substr($name, 1);
        }

        $this->name = $name;
        $this->type = $type;
        $this->defaultValue = $defaultValue;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return InternalType|string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return Scalar|Class_|Interface_|Type
     */
    public function getDefaultValue()
    {
        return $this->defaultValue;
    }
}
