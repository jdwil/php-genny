<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Type;

use JDWil\PhpGenny\ValueObject\InternalType;

/**
 * Class Function_
 */
class Function_
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string|null
     */
    protected $namespace;

    /**
     * @var string|null
     */
    protected $body;

    /**
     * @var InternalType|Class_|Interface_|string
     */
    protected $returnType;

    /**
     * Function_ constructor.
     * @param string $name
     * @param string|null $namespace
     * @param string $body
     * @param InternalType|Class_|Interface_|string $returnType
     */
    public function __construct(string $name, string $namespace = null, string $body = '', $returnType)
    {
        $this->name = $name;
        $this->namespace = $namespace;
        $this->body = $body;
        $this->returnType = $returnType;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getNamespace()
    {
        return $this->namespace;
    }

    /**
     * @return string|null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return Class_|Interface_|InternalType|string
     */
    public function getReturnType()
    {
        return $this->returnType;
    }

    /**
     * @param Class_|Interface_|InternalType|string $returnType
     */
    public function setReturnType($returnType)
    {
        $this->returnType = $returnType;
    }
}
