<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use PhpParser\Comment\Doc;
use PhpParser\Node\Name;

/**
 * Class Trait_
 */
class Trait_ extends AbstractNode implements HasNodeBehaviorInterface
{
    use NodeBehaviorTrait;
    use DocBlockTrait;
    use NestedNodeTrait;

    /**
     * @var AbstractNode[]
     */
    protected $nodes;

    /**
     * @var string
     */
    protected $name;

    /**
     * @param string $name
     * @return Trait_
     */
    public static function new(string $name): Trait_
    {
        $ret = new static();
        $ret->name = $name;
        $ret->nodes = [];

        return $ret;
    }

    /**
     * @param $trait
     * @return UseTrait
     */
    public function use($trait): UseTrait
    {
        if (is_string($trait)) {
            $trait = [$trait];
        }

        $ret = UseTrait::new($trait);
        $ret->setParent($this);
        $this->nodes[] = $ret;

        return $ret;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return \PhpParser\Node\Stmt\Trait_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Trait_
    {
        $ret = new \PhpParser\Node\Stmt\Trait_($this->name, [
            'stmts' => array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes)
        ]);

        if ($this->hasComment()) {
            $ret->setDocComment(new Doc($this->getComments()));
        }

        return $ret;
    }

    /**
     * @return AbstractNode[]
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }
}
