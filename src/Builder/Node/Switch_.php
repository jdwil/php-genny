<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;

class Switch_ extends AbstractNode
{
    use NestedNodeTrait;

    /**
     * @var AbstractNode
     */
    protected $subject;

    /**
     * @var Case_[]
     */
    protected $cases;

    /**
     * @param AbstractNode $subject
     * @return Switch_
     */
    public static function new(AbstractNode $subject): Switch_
    {
        $ret = new static();
        $ret->subject = $subject;

        return $ret;
    }

    /**
     * @param AbstractNode|null $condition
     * @return Case_
     */
    public function case(AbstractNode $condition = null): Case_
    {
        $case = Case_::new($condition);
        $case->setParent($this);
        $this->cases[] = $case;

        return $case;
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Switch_ must be a Builder');
        }

        return $this->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\Switch_(
            $this->subject->getStatements(),
            array_map(function (Case_ $case) {
                return $case->getStatements();
            }, $this->cases)
        );
    }
}
