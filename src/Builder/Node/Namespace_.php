<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use PhpParser\Node\Name;

/**
 * Class Namespace_
 */
class Namespace_ extends Builder
{
    use NestedNodeTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @return Namespace_
     */
    public static function named(string $name): Namespace_
    {
        $ns = new Namespace_();
        $ns->name = $name;
        $ns->nodes = [];

        return $ns;
    }

    /**
     * @return \PhpParser\Node\Stmt\Namespace_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Namespace_
    {
        $nodes = array_map(function (AbstractNode $node) {
            return $node->getStatements();
        }, $this->nodes);

        return new \PhpParser\Node\Stmt\Namespace_(new Name($this->name), $nodes);
    }
}
