<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\ArrayAccessTrait;
use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use JDWil\PhpGenny\ValueObject\InternalType;
use PhpParser\Node\Expr\PropertyFetch;

class Variable extends AbstractNode implements ResultTypeInterface
{
    use BinaryOpTrait;
    use AssignmentOpTrait;
    use ArrayAccessTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var InternalType|string
     */
    protected $type;

    public static function named(string $name): Variable
    {
        $ret = new Variable();
        $ret->name = $name;

        return $ret;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Node
     */
    public function property(string $name): Node
    {
        return Node::new(PropertyFetch::class, [new \PhpParser\Node\Expr\Variable($this->name), $name]);
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Expr\Variable($this->name);
    }

    /**
     * @return InternalType|string
     */
    public function getResultType()
    {
        return $this->type;
    }

    /**
     * @param InternalType|string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [];
    }
}
