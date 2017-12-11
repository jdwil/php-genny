<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder\Node;

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Traits\AbstractTrait;
use JDWil\PhpGenny\Builder\Node\Traits\DocBlockTrait;
use JDWil\PhpGenny\Builder\Node\Traits\FinalTrait;
use JDWil\PhpGenny\Builder\Node\Traits\StaticTrait;
use JDWil\PhpGenny\Builder\Node\Traits\VisibilityTrait;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Comment\Doc;
use PhpParser\Node\NullableType;
use PhpParser\Node\Stmt\ClassMethod;

/**
 * Class Method
 */
class Method extends Builder
{
    use VisibilityTrait;
    use StaticTrait;
    use AbstractTrait;
    use FinalTrait;
    use DocBlockTrait;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var Parameter[]
     */
    protected $parameters;

    /**
     * @var InternalType|string
     */
    protected $returnType;

    /**
     * @var bool
     */
    protected $nullableReturnType;

    /**
     * @param string $name
     * @return Method
     */
    public static function new(string $name): Method
    {
        $ret = new Method();
        $ret->name = $name;
        $ret->static = false;
        $ret->abstract = false;
        $ret->final = false;
        $ret->visibility = Visibility::isPublic();
        $ret->parameters = [];
        $ret->nodes = [];

        return $ret;
    }

    /**
     * @return Class_|Interface_|Trait_
     * @throws \Exception
     */
    public function done()
    {
        if (!$this->parent instanceof Class_ && !$this->parent instanceof Interface_ && !$this->parent instanceof Trait_) {
            throw new \Exception('Parent of Method must be an instance of Class_ or Interface_ or Trait_');
        }

        return $this->parent;
    }

    /**
     * @param Parameter $parameter
     * @return $this
     */
    public function add(Parameter $parameter)
    {
        $this->parameters[] = $parameter;

        return $this;
    }

    /**
     * @param InternalType|string $returnType
     * @param bool $nullable
     * @return $this
     */
    public function setReturnType($returnType, bool $nullable = false)
    {
        $this->returnType = $returnType;
        $this->nullableReturnType = $nullable;

        return $this;
    }

    /**
     * @return ClassMethod
     */
    public function getStatements(): ClassMethod
    {
        $flags = $this->addVisibilityFlags(0);
        $flags = $this->addStaticFlag($flags);
        $flags = $this->addAbstractFlag($flags);
        $flags = $this->addFinalFlag($flags);

        $returnType = null;
        if (null !== $this->returnType) {
            $returnType = $this->nullableReturnType ? new NullableType((string) $this->returnType) : (string) $this->returnType;
        }

        if (empty($this->nodes)) {
            $statements = [];
            if ($this->parent instanceof Interface_ || $this->abstract) {
                $statements = null;
            }
        } else {
            $statements = array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $this->nodes);
        }

        $subNodes = [
            'flags' => $flags,
            'byRef' => false,
            'params' => array_map(function (Parameter $parameter) {
                return $parameter->getStatements();
            }, $this->parameters),
            'returnType' => $returnType,
            'stmts' => $statements
        ];

        $ret = new ClassMethod($this->name, $subNodes);
        if ($this->hasComment()) {
            $ret->setDocComment(new Doc($this->getComments()));
        }

        return $ret;
    }
}
