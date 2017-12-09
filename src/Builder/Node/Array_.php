<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use JDWil\PhpGenny\Builder\Node\Traits\BinaryOpTrait;
use PhpParser\Node\Expr\ArrayDimFetch;

class Array_ extends AbstractNode
{
    use AssignmentOpTrait;
    use BinaryOpTrait;

    const DIM_FETCH = 'dim_fetch';

    protected $type;

    /**
     * @var AbstractNode
     */
    protected $var;

    /**
     * @var AbstractNode|null
     */
    protected $index;

    public static function fetchDimension(AbstractNode $var, AbstractNode $index = null)
    {
        $ret = new static();
        $ret->type = self::DIM_FETCH;
        $ret->var = $var;
        $ret->index = $index;

        return $ret;
    }

    public function getStatements()
    {
        switch ($this->type) {
            case self::DIM_FETCH:
                $index = null === $this->index ? null : $this->index->getStatements();
                return new ArrayDimFetch($this->var->getStatements(), $index);
        }
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return [
            'var' => $this->var,
            'index' => $this->index
        ];
    }
}
