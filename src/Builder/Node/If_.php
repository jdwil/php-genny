<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class If_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @var ElseIf_[]
     */
    protected $elseIfs;

    /**
     * @var Else_
     */
    public $else;

    public static function new(AbstractNode $condition)
    {
        $ret = new static();
        $ret->condition = $condition;
        $ret->elseIfs = [];

        return $ret;
    }

    /**
     * @param AbstractNode $condition
     * @return ElseIf_
     */
    public function elseIf(AbstractNode $condition): ElseIf_
    {
        $ret = ElseIf_::new($condition);
        $ret->setParent($this);
        $this->elseIfs[] = $ret;

        return $ret;
    }

    /**
     * @return Else_
     */
    public function else(): Else_
    {
        $ret = Else_::new();
        $ret->setParent($this);
        $this->else = $ret;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('If_ must be child of Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $else = null === $this->else ?
            null :
            $this->else->getStatements()
        ;

        return new \PhpParser\Node\Stmt\If_(
            $this->condition->getStatements(),
            [
                'stmts' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->nodes),
                'elseifs' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->elseIfs),
                'else' => $else
            ]
        );
    }
}
