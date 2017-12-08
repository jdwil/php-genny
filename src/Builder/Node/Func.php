<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\ArrayAccessTrait;
use PhpParser\Node\Expr\FuncCall;
use PhpParser\Node\Name;

class Func extends AbstractNode
{
    use ArrayAccessTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var AbstractNode[]
     */
    protected $arguments;

    /**
     * @param string $name
     * @param array $arguments
     * @return Func
     */
    public static function call(string $name, array $arguments): Func
    {
        $ret = new Func();
        $ret->name = $name;
        $ret->arguments = $arguments;

        return $ret;
    }

    public function getStatements()
    {
        $arguments = array_map(function (AbstractNode $arg) {
            return $arg->getStatements();
        }, $this->arguments);

        return new FuncCall(new Name($this->name), $arguments);
    }
}
