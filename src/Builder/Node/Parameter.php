<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Param;

/**
 * Class Parameter
 */
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

    /**
     * @param string $name
     * @return Parameter
     */
    public static function named(string $name): Parameter
    {
        $ret = new Parameter();
        $ret->name = $name;

        return $ret;
    }

    /**
     * @param InternalType|string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return $this
     */
    public function makeByRef()
    {
        $this->byRef = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function makeVariadic()
    {
        $this->variadic = true;

        return $this;
    }

    /**
     * @param AbstractNode $default
     * @return $this
     */
    public function setDefault(AbstractNode $default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * @return Param
     */
    public function getStatements(): Param
    {
        $default = $this->default ?
            $this->default->getStatements() :
            null
        ;

        return new Param($this->name, $default, (string) $this->type, $this->byRef, $this->variadic);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'default' => $this->default
        ];
    }
}
