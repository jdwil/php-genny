<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;

class Finally_ extends Builder
{
    public static function new(): Finally_
    {
        return new static();
    }

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Try_) {
            throw new \Exception('Parent of Finally_ must be a Try_');
        }

        if (!$this->parent->parent instanceof Builder) {
            throw new \Exception('Parent of Try_ must be a Builder');
        }

        return $this->parent->parent;
    }

    public function getStatements()
    {
        return new \PhpParser\Node\Stmt\Finally_(parent::getStatements());
    }
}
