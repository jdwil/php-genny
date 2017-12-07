<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use PhpParser\Node\Expr\PropertyFetch;

class Variable extends AbstractNode
{
    use BinaryOpTrait;
    use AssignmentOpTrait;

    protected $name;

    public static function named(string $name): Variable
    {
        $ret = new Variable();
        $ret->name = $name;

        return $ret;
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
}
