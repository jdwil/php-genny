<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class Else_ extends Builder
{

    public static function new()
    {
        return new static();
    }

    public function done(): Builder
    {
        if (!$this->parent instanceof If_) {
            throw new \Exception('Else_ must be nested in If_');
        }

        return $this->parent->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\Else_(
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        );
    }
}
