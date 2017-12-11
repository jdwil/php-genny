<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\AssignmentOpTrait;
use PhpParser\Node\Expr\ArrayItem;

class List_ extends AbstractNode
{
    use AssignmentOpTrait;

    /**
     * @var array
     */
    protected $vars;

    /**
     * @param array ...$vars
     * @return List_
     */
    public static function new(...$vars): List_
    {
        $ret = new List_();
        $ret->vars = $vars;

        return $ret;
    }

    /**
     * @return \PhpParser\Node\Expr\List_
     */
    public function getStatements()
    {
        return new \PhpParser\Node\Expr\List_(array_map(function ($item) {
            if ($item instanceof AbstractNode) {
                return new ArrayItem($item->getStatements());
            }

            return new ArrayItem($item);
        }, $this->vars));
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->vars;
    }
}
