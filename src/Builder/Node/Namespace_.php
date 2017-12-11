<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;
use PhpParser\Node\Name;

/**
 * Class Namespace_
 */
class Namespace_ extends Builder
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $type;

    /**
     * @param string $name
     * @return Namespace_
     */
    public static function named(string $name): Namespace_
    {
        $ns = new Namespace_();
        $ns->name = $name;
        $ns->type = \PhpParser\Node\Stmt\Namespace_::KIND_SEMICOLON;
        $ns->nodes = [];

        return $ns;
    }

    /**
     * @return Namespace_
     */
    /*
    public function useBraces(): Namespace_
    {
        $this->type = \PhpParser\Node\Stmt\Namespace_::KIND_BRACED;

        return $this;
    }
    */

    /**
     * @return Namespace_
     */
    /*
    public function useSemicolon(): Namespace_
    {
        $this->type = \PhpParser\Node\Stmt\Namespace_::KIND_SEMICOLON;

        return $this;
    }
    */

    /**
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Namespace_ must be Builder');
        }

        return $this->parent;
    }

    /**
     * @return \PhpParser\Node\Stmt\Namespace_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Namespace_
    {
        $nodes = array_map(function (AbstractNode $node) {
            return $node->getStatements();
        }, $this->nodes);

        return new \PhpParser\Node\Stmt\Namespace_(new Name($this->name), $nodes, ['kind' => $this->type]);
    }
}
