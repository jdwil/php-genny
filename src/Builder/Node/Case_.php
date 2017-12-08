<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class Case_ extends Builder
{
    /**
     * @var AbstractNode|null
     */
    protected $condition;

    /**
     * @param AbstractNode|null $condition
     * @return Case_
     */
    public static function new(AbstractNode $condition = null): Case_
    {
        $ret = new static();
        $ret->condition = $condition;

        return $ret;
    }

    /**
     * @return Switch_
     * @throws \Exception
     */
    public function done(): Switch_
    {
        if (!$this->parent instanceof Switch_) {
            throw new \Exception('Parent of Case_ must be a Switch_');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        $condition = null === $this->condition ?
            null :
            $this->condition->getStatements()
        ;

        return new \PhpParser\Node\Stmt\Case_($condition, parent::getStatements());
    }
}
