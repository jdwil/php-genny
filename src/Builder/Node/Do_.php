<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class Do_ extends Builder
{
    /**
     * @var AbstractNode
     */
    protected $condition;

    /**
     * @return Do_
     */
    public static function new(): Do_
    {
        return new static();
    }

    /**
     * @param AbstractNode $condition
     * @return Builder
     * @throws \Exception
     */
    public function while(AbstractNode $condition): Builder
    {
        $this->condition = $condition;

        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Do_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\Do_(
            $this->condition->getStatements(),
            parent::getStatements()
        );
    }
}
