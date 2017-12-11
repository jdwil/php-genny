<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

/**
 * Class ElseIf_
 */
class ElseIf_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @param AbstractNode $condition
     * @return ElseIf_
     */
    public static function new(AbstractNode $condition): ElseIf_
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    /**
     * @return Else_
     * @throws \Exception
     */
    public function else(): Else_
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('Parent of ElseIf_ must be If_');
        }

        $ret = Else_::new();
        $ret->setParent($this->parent);
        $this->parent->else = $ret;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('ElseIf_ must be nested in If_');
        }

        return $this->parent->parent;
    }

    /**
     * @return \PhpParser\Node\Stmt\ElseIf_
     */
    public function getStatements(): \PhpParser\Node\Stmt\ElseIf_
    {
        return new \PhpParser\Node\Stmt\ElseIf_(
            $this->condition->getStatements(),
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        );
    }
}
