<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Param;

class Parameter extends AbstractNode
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
     * @var bool
     */
    protected $byRef;

    /**
     * @var bool
     */
    protected $variadic;

    /**
     * @var AbstractNode
     */
    protected $default;

    public static function named(string $name)
    {
        $ret = new Parameter();
        $ret->name = $name;

        return $ret;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function makeByRef()
    {
        $this->byRef = true;

        return $this;
    }

    public function makeVariadic()
    {
        $this->variadic = true;

        return $this;
    }

    public function setDefault(AbstractNode $default)
    {
        $this->default = $default;

        return $this;
    }

    public function getStatements()
    {
        $default = $this->default ?
            $this->default->getStatements() :
            null
        ;

        return new Param($this->name, $default, (string) $this->type, $this->byRef, $this->variadic);
    }
}
