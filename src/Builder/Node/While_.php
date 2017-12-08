<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class While_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @param AbstractNode $condition
     * @return While_
     */
    public static function new(AbstractNode $condition): While_
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of While_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\While_(
            $this->condition->getStatements(),
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        );
    }
}
