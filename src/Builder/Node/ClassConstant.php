<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\StaticTrait;
use JDWil\PhpGenny\Builder\Node\Traits\VisibilityTrait;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

/**
 * Class ClassConstant
 */
class ClassConstant extends AbstractNode
{
    use VisibilityTrait;
    use StaticTrait;
    use NestedNodeTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractNode
     */
    protected $value;

    /**
     * @param string $name
     * @param AbstractNode $value
     * @return ClassConstant
     */
    public static function new(string $name, AbstractNode $value): ClassConstant
    {
        $ret = new ClassConstant();
        $ret->name = $name;
        $ret->value = $value;
        $ret->static = false;

        return $ret;
    }

    /**
     * @return Class_|Interface_
     * @throws \Exception
     */
    public function done()
    {
        if (!$this->parent instanceof Class_ && !$this->parent instanceof Interface_) {
            throw new \Exception('Parent of ClassConstant must be an instance of Class_ or Interface_');
        }

        return $this->parent;
    }

    /**
     * @return ClassConst
     */
    public function getStatements(): ClassConst
    {
        $flags = $this->addVisibilityFlags(0);
        $flags = $this->addStaticFlag($flags);

        return new ClassConst([new Const_($this->name, $this->value->getStatements())], $flags);
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'value' => $this->value
        ];
    }
}
