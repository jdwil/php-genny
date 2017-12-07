<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use PhpParser\Node\Expr\New_;
use PhpParser\Node\Name;

class NewInstance extends AbstractNode
{
    protected $name;
    protected $arguments;

    public static function of(string $name, array $arguments = [])
    {
        $ret = new static();
        $ret->name = $name;
        $ret->arguments = $arguments;

        return $ret;
    }

    public function getStatements()
    {
        return new New_(new Name($this->name), array_map(function ($arg) {
            if ($arg instanceof AbstractNode) {
                return $arg->getStatements();
            }

            return $arg;
        }, $this->arguments));
    }
}
