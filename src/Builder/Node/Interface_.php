<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use PhpParser\Comment\Doc;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Nop;

class Interface_ extends AbstractNode implements HasNodeBehaviorInterface
{
    use NodeBehaviorTrait;
    use NestedNodeTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string[]
     */
    protected $extends;

    /**
     * @var array
     */
    protected $nodes;

    /**
     * @param string $name
     * @return Interface_
     */
    public static function new(
        string $name
    ): Interface_ {
        $ret = new static();
        $ret->name = $name;
        $ret->extends = [];

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
     * @return Builder
     * @throws \Exception
     */
    public function done(): Builder
    {
        if (!$this->parent instanceof Builder) {
            throw new \Exception('Parent of Interface_ must be an instance of Builder');
        }

        return $this->parent;
    }

    /**
     * @return Interface_
     */
    public function lineBreak(): Interface_
    {
        $this->nodes[] = Node::new(Nop::class, []);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function extends(string $name)
    {
        $this->extends[] = $name;

        return $this;
    }

    /**
     * @param string $name
     * @param AbstractNode $value
     * @return ClassConstant
     */
    public function constant(string $name, AbstractNode $value): ClassConstant
    {
        $constant = ClassConstant::new($name, $value);
        $constant->setParent($this);
        $this->nodes[] = $constant;

        return $constant;
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
     * @return \PhpParser\Node\Stmt\Interface_
     */
    public function getStatements(): \PhpParser\Node\Stmt\Interface_
    {
        $ret = new \PhpParser\Node\Stmt\Interface_(
            $this->name,
            [
                'extends' => array_map(function (string $name) {
                    return new Name($name);
                }, $this->extends),
                'stmts' => array_map(function (AbstractNode $node) {
                    return $node->getStatements();
                }, $this->nodes)
            ]
        );

        if ($this->hasComment()) {
            $ret->setDocComment(new Doc($this->getComments()));
        }

        return $ret;
    }

    /**
     * @return array
     */
    public function getNodes(): array
    {
        return $this->nodes;
    }
}
