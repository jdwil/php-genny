<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class ElseIf_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    public static function new(AbstractNode $condition)
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    public function else()
    {
        $ret = Else_::new();
        $ret->setParent($this->parent);
        $this->parent->else = $ret;

        return $ret;
    }

    public function done(): Builder
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('ElseIf_ must be nested in If_');
        }

        return $this->parent->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\ElseIf_(
            $this->condition->getStatements(),
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        );
    }
}
