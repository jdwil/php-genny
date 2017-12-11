<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use PhpParser\Comment\Doc;

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
     * @param string $name
     * @return Property
     */
    public function property(string $name): Property
    {
        $property = Property::new($name);
        $property->setParent($this);
        $property->copyBehaviorFrom($this);
        if ($this->autoGenerateDocBlocks) {
            $property->setComments(['@var mixed']);
        }
        $this->nodes[] = $property;

        return $property;
    }

    /**
     * @param string $name
     * @return Method
     */
    public function method(string $name): Method
    {
        $method = Method::new($name);
        $method->setParent($this);
        $this->nodes[] = $method;

        return $method;
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
