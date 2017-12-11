<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use PhpParser\Node\Expr\ClassConstFetch;
use PhpParser\Node\Expr\StaticPropertyFetch;
use PhpParser\Node\Name;

class Reference extends AbstractNode
{
    use AssignmentOpTrait;

    /**
     * @var string
     */
    protected $name;

    public static function self()
    {
        return static::buildStaticReference('self');
    }

    public static function static()
    {
        return static::buildStaticReference('static');
    }

    public static function class(string $name)
    {
        return static::buildStaticReference($name);
    }

    public function getStatements()
    {
        return new Name($this->name);
    }

    /**
     * @param string $name
     * @return Node
     */
    public function staticProperty(string $name): Node
    {
        return Node::new(StaticPropertyFetch::class, [$this->getStatements(), $name]);
    }

    /**
     * @param string $name
     * @return Node
     */
    public function constant(string $name): Node
    {
        return Node::new(ClassConstFetch::class, [$this->getStatements(), $name]);
    }

    public function getNodes(): array
    {
        return [];
    }

    /**
     * @param string $name
     * @return Reference
     */
    protected static function buildStaticReference(string $name): Reference
    {
        $ret = new static();
        $ret->name = $name;

        return $ret;
    }
}
