<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\StaticTrait;
use JDWil\PhpGenny\Builder\Node\Traits\VisibilityTrait;
use PhpParser\Node\Const_;
use PhpParser\Node\Stmt\ClassConst;

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

    public static function new(string $name, AbstractNode $value)
    {
        $ret = new ClassConstant();
        $ret->name = $name;
        $ret->value = $value;
        $ret->static = false;

        return $ret;
    }

    public function done(): Class_
    {
        if (!$this->parent instanceof Class_) {
            throw new \Exception('Parent of ClassConstant must be an instance of Class_');
        }

        return $this->parent;
    }

    public function getStatements()
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
