<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\AbstractNodeContainer;
use JDWil\PhpGenny\Builder\Node\BinaryOp;
use JDWil\PhpGenny\Builder\Node\Body;
use JDWil\PhpGenny\Builder\Node\Class_;
use JDWil\PhpGenny\Builder\Node\Do_;
use JDWil\PhpGenny\Builder\Node\For_;
use JDWil\PhpGenny\Builder\Node\Foreach_;
use JDWil\PhpGenny\Builder\Node\If_;
use JDWil\PhpGenny\Builder\Node\Namespace_;
use JDWil\PhpGenny\Builder\Node\NestedNodeInterface;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Builder\Node\Node;
use JDWil\PhpGenny\Builder\Node\Parameter;
use JDWil\PhpGenny\Builder\Node\ResultTypeInterface;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Switch_;
use JDWil\PhpGenny\Builder\Node\Traits\InternalFunctionTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NestedNodeTrait;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use JDWil\PhpGenny\Builder\Node\Try_;
use JDWil\PhpGenny\Builder\Node\Type;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\Node\While_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Node\Expr\ErrorSuppress;
use PhpParser\Node\Expr\Exit_;
use PhpParser\Node\Expr\Print_;
use PhpParser\Node\Expr\Yield_;
use PhpParser\Node\Expr\YieldFrom;
use PhpParser\Node\Name;
use PhpParser\Node\Stmt\Break_;
use PhpParser\Node\Stmt\Continue_;
use PhpParser\Node\Stmt\Declare_;
use PhpParser\Node\Stmt\DeclareDeclare;
use PhpParser\Node\Stmt\Echo_;
use PhpParser\Node\Stmt\Global_;
use PhpParser\Node\Stmt\Goto_;
use PhpParser\Node\Stmt\HaltCompiler;
use PhpParser\Node\Stmt\InlineHTML;
use PhpParser\Node\Stmt\Label;
use PhpParser\Node\Stmt\Nop;
use PhpParser\Node\Stmt\Return_;
use PhpParser\Node\Stmt\Static_;
use PhpParser\Node\Stmt\Throw_;
use PhpParser\Node\Stmt\Unset_;
use PhpParser\Node\Stmt\Use_;
use PhpParser\Node\Stmt\UseUse;

class Builder extends AbstractNodeContainer
{
    use NestedNodeTrait;
    use InternalFunctionTrait;
    use NodeBehaviorTrait;

    const PHP_53 = 53;
    const PHP_54 = 54;
    const PHP_55 = 55;
    const PHP_56 = 56;
    const PHP_70 = 70;
    const PHP_71 = 71;

    /**
     * @var bool
     */
    protected $useStrict;

    /**
     * @var bool
     */
    protected $preferDefaultsSetInConstructor;

    public function __construct()
    {
        parent::__construct();

        $this->nodes = [];
        $this->useStrict = false;
        $this->preferDefaultsSetInConstructor = false;
    }

    public function __call(string $name, array $arguments)
    {
        if ($func = static::handleInternalFunctionCall($name, $arguments)) {
            $this->nodes[] = $func;
        }
    }

    /**
     * @return $this
     */
    public function useStrictTypes()
    {
        $this->useStrict = true;

        return $this;
    }

    /**
     * @return $this
     */
    public function preferDefaultsSetInConstructor()
    {
        $this->preferDefaultsSetInConstructor = true;

        return $this;
    }

    public function parameter(string $name)
    {
        return Parameter::named($name);
    }

    /**
     * @param AbstractNode $node
     * @return If_
     */
    public function if(AbstractNode $node): If_
    {
        $if = If_::new($node);
        $if->setParent($this);
        $this->nodes[] = $if;

        return $if;
    }

    /**
     * @param AbstractNode $init
     * @param AbstractNode $condition
     * @param AbstractNode $loop
     * @return For_
     */
    public function for(AbstractNode $init, AbstractNode $condition, AbstractNode $loop): For_
    {
        $for = For_::new($init, $condition, $loop);
        $for->setParent($this);
        $this->nodes[] = $for;

        return $for;
    }

    /**
     * @param AbstractNode $condition
     * @return While_
     */
    public function while(AbstractNode $condition)
    {
        $while = While_::new($condition);
        $while->setParent($this);
        $this->nodes[] = $while;

        return $while;
    }

    /**
     * @return Do_
     */
    public function do(): Do_
    {
        $do = Do_::new();
        $do->setParent($this);
        $this->nodes[] = $do;

        return $do;
    }

    /**
     * @return Try_
     */
    public function try(): Try_
    {
        $try = Try_::new();
        $try->setParent($this);
        $this->nodes[] = $try;

        return $try;
    }

    /**
     * @param AbstractNode $subject
     * @return Switch_
     */
    public function switch(AbstractNode $subject): Switch_
    {
        $switch = Switch_::new($subject);
        $switch->setParent($this);
        $this->nodes[] = $switch;

        return $switch;
    }

    /**
     * @param AbstractNode $subject
     * @param AbstractNode $valueVar
     * @param AbstractNode|null $keyVar
     * @param bool $byRef
     * @return Foreach_
     */
    public function foreach(
        AbstractNode $subject,
        AbstractNode $valueVar,
        AbstractNode $keyVar = null,
        bool $byRef = false
    ): Foreach_ {
        $foreach = Foreach_::new($subject, $valueVar, $keyVar, $byRef);
        $foreach->setParent($this);
        $this->nodes[] = $foreach;

        return $foreach;
    }

    /**
     * @param AbstractNode $throw
     * @return $this
     */
    public function throw(AbstractNode $throw)
    {
        $this->nodes[] = Node::new(Throw_::class, [$throw->getStatements()]);

        return $this;
    }

    /**
     * @param AbstractNode|null $num
     * @return $this
     */
    public function break(AbstractNode $num = null)
    {
        if (null !== $num) {
            $num = $num->getStatements();
        }

        $this->nodes[] = Node::new(Break_::class, [$num]);

        return $this;
    }

    /**
     * @param AbstractNode|null $num
     * @return $this
     */
    public function continue(AbstractNode $num = null)
    {
        if (null !== $num) {
            $num = $num->getStatements();
        }

        $this->nodes[] = Node::new(Continue_::class, [$num]);

        return $this;
    }

    /**
     * @param $value
     * @return $this
     */
    public function print($value)
    {
        if ($value instanceof AbstractNode) {
            $value = [$value->getStatements()];
        }

        $this->nodes[] = Node::new(Print_::class, [$value]);

        return $this;
    }

    /**
     * @param AbstractNode[] ...$vars
     * @return $this
     */
    public function global(...$vars)
    {
        $this->nodes[] = Node::new(Global_::class, [
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $vars)
        ]);

        return $this;
    }

    /**
     * @param AbstractNode[] ...$vars
     * @return $this
     */
    public function static(...$vars)
    {
        $this->nodes[] = Node::new(Static_::class, [
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $vars)
        ]);

        return $this;
    }

    /**
     * @param AbstractNode[] ...$vars
     * @return $this
     */
    public function unset(...$vars)
    {
        $this->nodes[] = Node::new(Unset_::class, [
            array_map(function (AbstractNode $node) {
                return $node->getStatements();
            }, $vars)
        ]);

        return $this;
    }

    /**
     * @param AbstractNode|null $value
     * @param AbstractNode|null $key
     * @return $this
     */
    public function yield(AbstractNode $value = null, AbstractNode $key = null)
    {
        if (null !== $value) {
            $value = $value->getStatements();
        }

        if (null !== $key) {
            $key = $key->getStatements();
        }

        $this->nodes[] = Node::new(Yield_::class, [$value, $key]);

        return $this;
    }

    /**
     * @param AbstractNode $node
     * @return $this
     */
    public function exit(AbstractNode $node)
    {
        $this->nodes[] = Node::new(Exit_::class, [$node->getStatements()]);

        return $this;
    }

    /**
     * @param AbstractNode $node
     * @return Builder
     */
    public function die(AbstractNode $node)
    {
        return $this->exit($node);
    }

    /**
     * @param AbstractNode $node
     * @return $this
     */
    public function suppressError(AbstractNode $node)
    {
        $this->nodes[] = Node::new(ErrorSuppress::class, [$node->getStatements()]);

        return $this;
    }

    /**
     * @param AbstractNode $value
     * @return $this
     */
    public function yieldFrom(AbstractNode $value)
    {
        $this->nodes[] = Node::new(YieldFrom::class, [$value->getStatements()]);

        return $this;
    }

    /**
     * @param string $text
     * @return $this
     */
    public function haltCompiler(string $text)
    {
        $this->nodes[] = Node::new(HaltCompiler::class, [$text]);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function label(string $name)
    {
        $this->nodes[] = Node::new(Label::class, [$name]);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function goto(string $name)
    {
        $this->nodes[] = Node::new(Goto_::class, [$name]);

        return $this;
    }

    /**
     * @param string $html
     * @return $this
     */
    public function inlineHtml(string $html)
    {
        $this->nodes[] = Node::new(InlineHTML::class, [$html]);

        return $this;
    }

    /**
     * @return $this
     */
    public function noop()
    {
        $this->nodes[] = Node::new(Nop::class, []);

        return $this;
    }

    /**
     * @return Builder
     */
    public function newLine()
    {
        return $this->noop();
    }

    /**
     * @param $value
     * @return $this
     */
    public function echo($value)
    {
        if ($value instanceof AbstractNode) {
            $value = [$value->getStatements()];
        }

        $this->nodes[] = Node::new(Echo_::class, [$value]);

        return $this;
    }

    /**
     * @param string $value
     * @param string|null $alias
     * @return $this
     */
    public function use(string $value, string $alias = null)
    {
        $this->nodes[] = Node::new(Use_::class, [[new UseUse(new Name($value), $alias)]]);

        return $this;
    }

    /**
     * @param string $fqn
     * @param string|null $alias
     * @return $this
     */
    public function useFunction(string $fqn, string $alias = null)
    {
        $this->nodes[] = Node::new(Use_::class, [[new UseUse(new Name($fqn), $alias, Use_::TYPE_FUNCTION)]]);

        return $this;
    }

    /**
     * @param string $key
     * @param Scalar $value
     * @return $this
     */
    public function declare(string $key, Scalar $value)
    {
        $this->nodes[] = Node::new(Declare_::class, [[new DeclareDeclare($key, $value->getStatements())]]);

        return $this;
    }

    /**
     * @param AbstractNode $node
     * @return $this
     */
    public function execute(AbstractNode $node)
    {
        $this->nodes[] = $node;

        return $this;
    }

    /**
     * @param string $name
     * @return Class_
     */
    public function class(string $name)
    {
        $c = Class_::new($name);
        $c->setParent($this);
        if ($this->autoGenerateDocBlocks) {
            $c->autoGenerateDocBlocks();
        }

        $this->nodes[] = $c;

        return $c;
    }

    /**
     * @param string $name
     * @return Namespace_
     * @throws \Exception
     */
    public function namespace(string $name): Namespace_
    {
        $this->throwIfNotGlobalScope();

        $namespace = Namespace_::named($name);
        $namespace->setParent($this);
        $this->nodes[] = $namespace;

        return $namespace;
    }

    /**
     * @param AbstractNode $node
     * @return $this
     */
    public function return(AbstractNode $node)
    {
        $this->nodes[] = Node::new(Return_::class, [$node]);

        return $this;
    }

    public function buildClass(\JDWil\PhpGenny\Type\Class_ $class)
    {
        if ($this->useStrict) {
            $this->declare('strict_types', Scalar::int(1));
        }

        $ns = null !== $class->getNamespace() ?
            $this->namespace($class->getNamespace()) :
            $this
        ;

        $uses = $this->collectClassUseStatements($class);
        foreach ($uses as $use) {
            $ns->use($use);
        }

        $c = $ns->class($class->getName());

        if ($class->isAbstract()) {
            $c->makeAbstract();
        }

        if ($class->isFinal()) {
            $c->makeFinal();
        }

        if ($extends = $class->getExtends()) {
            $c->extends($extends);
        }

        $implements = $class->getImplements();
        if (!empty($implements)) {
            foreach ($implements as $i) {
                $c->implements($i);
            }
        }

        $constants = $class->getConstants();
        if (!empty($constants)) {
            foreach ($constants as $constant) {
                $cb = $c->constant($constant['name'], $constant['value']);
                if (null !== $constant['visibility']) {
                    switch ((string) $constant['visibility']) {
                        case Visibility::PUBLIC:
                            $cb->makePublic();
                            break;
                        case Visibility::PROTECTED:
                            $cb->makeProtected();
                            break;
                        case Visibility::PRIVATE:
                            $cb->makePrivate();
                            break;
                    }
                }

                if ($constant['static']) {
                    $cb->makeStatic();
                }
            }
        }

        $properties = $class->getProperties();
        if (!empty($properties)) {
            foreach ($properties as $property) {
                $p = $c->property($property->getName());
                if ($this->preferDefaultsSetInConstructor) {
                    if ($default = $property->getDefaultValue()) {
                        if ($default instanceof \JDWil\PhpGenny\Type\Class_) {
                            $p->setType($default);
                            $constructor = $this->getConstructor($class);
                            $constructor->getBody()->execute(
                                Variable::named('this')->property($property->getName())->equals(NewInstance::of($default->getName()))
                            );
                        } else if ($default instanceof AbstractNode) {
                            if ($default instanceof ResultTypeInterface) {
                                $p->setType($default->getResultType());
                            }
                            $constructor = $this->getConstructor($class);
                            $constructor->getBody()->execute(
                                Variable::named('this')->property($property->getName())->equals($default)
                            );
                        }
                    }
                } else if (($default = $property->getDefaultValue()) && $default instanceof AbstractNode) {
                    $p->setDefault($default);
                }
            }
        }

        $methods = $class->getMethods();
        usort($methods, function (Method $a, Method $b) {
            if ($a->getName() === '__construct') {
                return -1;
            }

            if ($b->getName() === '__construct') {
                return 1;
            }

            return 0;
        });

        if (!empty($methods)) {
            foreach ($methods as $method) {
                $m = $c->method($method->getName());

                foreach ($method->getParameters() as $parameter) {
                    $p = $this->parameter($parameter->getName());
                    if ($type = $parameter->getType()) {
                        $p->setType($type);
                    }

                    if ($default = $parameter->getDefaultValue()) {
                        $p->setDefault($default);
                    }

                    $m->add($p);

                    if ($this->autoGenerateDocBlocks) {
                        $type = $parameter->getType() ?? InternalType::mixed();
                        $m->addComment('@param ' . (string) $type . ' $' . $parameter->getName());
                    }
                }

                $returnTypes = $method->getReturnTypes();
                if (!empty($returnTypes)) {
                    if (count($returnTypes) === 1) {
                        $m->setReturnType($returnTypes[0]);
                        $m->addComment('@return ' . (string) $returnTypes[0]);
                    } else if (
                        count($returnTypes) === 2 &&
                        (
                            ((string) $returnTypes[0]) === 'null' ||
                            ((string) $returnTypes[1]) === 'null'
                        )
                    ) {
                        $nonNullType = (string) $returnTypes[0] === 'null' ?
                            $returnTypes[1] :
                            $returnTypes[0]
                        ;
                        $m->setReturnType($nonNullType, true);
                        $m->addComment('@return ' . (string) $nonNullType . '|null');
                    } else {
                        $types = [];
                        foreach ($returnTypes as $returnType) {
                            $types[] = (string) $returnType;
                        }
                        $m->addComment('@return ' . implode('|', $types));
                    }
                } else if ($this->autoGenerateDocBlocks) {
                    $nodes = $method->getBody()->getNodes();
                    foreach ($nodes as $node) {
                        if ($node instanceof Node && $node->getType() === Return_::class) {
                            $params = $node->getParams();
                            if ($params[0] instanceof ResultTypeInterface) {
                                $m->addComment('@return ' . (string) $params[0]->getResultType());
                            } else {
                                $m->addComment('@return mixed');
                            }
                        }
                    }
                }

                $m->setNodes($method->getBody()->getNodes());
            }
        }
    }

    protected function getConstructor(\JDWil\PhpGenny\Type\Class_ $class): Method
    {
        foreach ($class->getMethods() as $method) {
            if ($method->getName() === '__construct') {
                return $method;
            }
        }

        $method = new Method('__construct');
        $class->addMethod($method);

        return $method;
    }

    protected function collectClassUseStatements(\JDWil\PhpGenny\Type\Class_ $class)
    {
        $ret = [];

        foreach ($class->getProperties() as $property) {
            if (($default = $property->getDefaultValue()) &&
                $default instanceof \JDWil\PhpGenny\Type\Class_ &&
                $default->getNamespace() !== $class->getNamespace()
            ) {
                $ret[] = $default->getFqn();
            }
        }

        return $ret;
    }

    /**
     * @throws \Exception
     */
    protected function throwIfNotGlobalScope()
    {
        if (get_class($this) !== Builder::class) {
            throw new \Exception('namespace cannot be used in block scope.');
        }
    }
}
