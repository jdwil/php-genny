<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Builder;

use JDWil\PhpGenny\Builder\Node\AbstractNode;
use JDWil\PhpGenny\Builder\Node\AssignmentOp;
use JDWil\PhpGenny\Builder\Node\HasNodeBehaviorInterface;
use JDWil\PhpGenny\Builder\Node\Namespace_;
use JDWil\PhpGenny\Builder\Node\NewInstance;
use JDWil\PhpGenny\Builder\Node\Node;
use JDWil\PhpGenny\Builder\Node\ResultTypeInterface;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Traits\NodeBehaviorTrait;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\HasMethodsInterface;
use JDWil\PhpGenny\Type\HasPropertiesInterface;
use JDWil\PhpGenny\Type\HasTraitsInterface;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\Type\NamespaceInterface;
use JDWil\PhpGenny\Type\Trait_;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\ValueObject\Visibility;
use PhpParser\Node\Stmt\Return_;

class BuilderFactory implements HasNodeBehaviorInterface
{
    use NodeBehaviorTrait;

    /**
     * @var Builder
     */
    protected $builder;

    public function constructInterfaceBuilder(Interface_ $interface): Builder
    {
        $this->builder = new Builder();
        $this->builder->copyBehaviorFrom($this);

        $this->addStrictTypes();
        $ns = $this->generateNamespace($interface);

        $uses = [];
        foreach ($interface->getExtends() as $extend) {
            if ($extend->getNamespace() !== $interface->getNamespace() &&
                !in_array($extend->getNamespace(), $uses, true)
            ) {
                $uses[] = $extend->getNamespace();
            }
        }

        foreach ($uses as $use) {
            $ns->use($use);
        }

        if (!empty($uses)) {
            $ns->newLine();
        }

        $i = $ns->interface($interface->getName());
        $this->addConstants($interface->getConstants(), $i);

        $methods = $this->sortMethods($interface->getMethods());
        foreach ($methods as $index => $method) {
            $m = $i->method($method->getName());
            $this->addMethodParameters($method, $m);
            $this->addReturnTypes($method, $m);

            if ($index !== (count($methods) - 1)) {
                $i->lineBreak();
            }
        }

        return $this->builder;
    }

    public function constructClassBuilder(Class_ $class)
    {
        $this->builder = new Builder();
        $this->builder->copyBehaviorFrom($this);

        $this->addStrictTypes();
        $ns = $this->generateNamespace($class);

        $uses = $this->collectClassUseStatements($class);
        foreach ($uses as $use) {
            $ns->use($use);
        }

        if (!empty($uses)) {
            $ns->newLine();
        }

        if ($this->autoGenerateDocBlocks) {
            $ns->newLine();
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
                if ($i instanceof Interface_) {
                    $c->implements($i->getName());
                } else {
                    $c->implements($i);
                }
            }
        }

        $this->addTraits($class, $c);
        $this->addConstants($class->getConstants(), $c);
        $this->addProperties($class, $c);
        $this->addMethods($class, $c);

        return $this->builder;
    }

    /**
     * @param Trait_ $trait
     * @return Builder
     * @throws \Exception
     */
    public function constructTraitBuilder(Trait_ $trait): Builder
    {
        $this->builder = new Builder();
        $this->builder->copyBehaviorFrom($this);

        $this->addStrictTypes();
        $ns = $this->generateNamespace($trait);

        $uses = $this->collectTraitUseStatements($trait);
        foreach ($uses as $use) {
            $ns->use($use);
        }

        if (!empty($uses)) {
            $ns->newLine();
        }

        if ($this->autoGenerateDocBlocks) {
            $ns->newLine();
        }

        $t = $ns->trait($trait->getName());
        $this->addTraits($trait, $t);
        $this->addProperties($trait, $t);
        $this->addMethods($trait, $t);

        return $this->builder;
    }

    /**
     * @param Class_ $class
     * @return Method
     */
    protected function getConstructor(Class_ $class): Method
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

    /**
     * @param Class_ $class
     * @return string[]
     */
    protected function collectClassUseStatements(Class_ $class): array
    {
        $ret = [];

        $this->collectPropertyUseStatements($class, $ret);

        foreach ($class->getImplements() as $implement) {
            if ($implement instanceof Interface_) {
                $ret[] = $implement->getFqn();
            }
        }

        $this->collectUseTraitUseStatements($class, $ret);

        return $ret;
    }

    /**
     * @param Trait_ $trait
     * @return string[]
     */
    protected function collectTraitUseStatements(Trait_ $trait): array
    {
        $ret = [];

        $this->collectPropertyUseStatements($trait, $ret);
        $this->collectUseTraitUseStatements($trait, $ret);

        return $ret;
    }

    private function addStrictTypes()
    {
        if ($this->useStrict) {
            $this
                ->builder
                ->declare('strict_types', Scalar::int(1))
                ->newLine();
        }
    }

    /**
     * @param NamespaceInterface $class
     * @return Builder|Namespace_
     * @throws \Exception
     */
    private function generateNamespace(NamespaceInterface $class)
    {
        return null !== $class->getNamespace() ?
            $this->builder->namespace($class->getNamespace()) :
            $this->builder;
    }

    /**
     * @param array $constants
     * @param \JDWil\PhpGenny\Builder\Node\Class_|\JDWil\PhpGenny\Builder\Node\Interface_ $c
     */
    private function addConstants($constants, $c)
    {
        if (!empty($constants)) {
            foreach ($constants as $index => $constant) {
                $cb = $c->constant($constant['name'], $constant['value']);
                if (null !== $constant['visibility']) {
                    switch ((string)$constant['visibility']) {
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

                if ($cb->hasComment() && $index !== (count($constants) - 1)) {
                    $c->lineBreak();
                }
            }

            $c->lineBreak();
        }
    }

    /**
     * @param Method[] $methods
     * @return Method[]
     */
    private function sortMethods(array $methods): array
    {
        usort($methods, function (Method $a, Method $b) {
            if ($a->getName() === '__construct') {
                return -1;
            }

            if ($b->getName() === '__construct') {
                return 1;
            }

            return 0;
        });

        return $methods;
    }

    /**
     * @param Method $method
     * @param \JDWil\PhpGenny\Builder\Node\Method $m
     */
    private function addMethodParameters($method, $m)
    {
        foreach ($method->getParameters() as $parameter) {
            $p = $this->builder->parameter($parameter->getName());
            if ($type = $parameter->getType()) {
                $p->setType($type);
            }

            if ($default = $parameter->getDefaultValue()) {
                if (is_string($default)) {
                    $default = Scalar::string($default);
                }
                $p->setDefault($default);
            }

            $m->add($p);

            if ($this->autoGenerateDocBlocks) {
                $type = $parameter->getType() ?? InternalType::mixed();
                $m->addComment('@param ' . (string)$type . ' $' . $parameter->getName());
            }
        }
    }

    /**
     * @param Method $method
     * @param \JDWil\PhpGenny\Builder\Node\Method $m
     */
    private function addReturnTypes($method, $m)
    {
        $returnTypes = $method->getReturnTypes();
        if (!empty($returnTypes)) {
            if (count($returnTypes) === 1) {
                $m->setReturnType($returnTypes[0]);
                $m->addComment('@return ' . (string)$returnTypes[0]);
            } else if (
                count($returnTypes) === 2 &&
                (
                    ((string)$returnTypes[0]) === 'null' ||
                    ((string)$returnTypes[1]) === 'null'
                )
            ) {
                $nonNullType = (string)$returnTypes[0] === 'null' ?
                    $returnTypes[1] :
                    $returnTypes[0];
                $m->setReturnType($nonNullType, true);
                $m->addComment('@return ' . (string)$nonNullType . '|null');
            } else {
                $types = [];
                foreach ($returnTypes as $returnType) {
                    $types[] = (string)$returnType;
                }
                $m->addComment('@return ' . implode('|', $types));
            }
        } else if ($this->autoGenerateDocBlocks) {
            $nodes = $method->getBody()->getNodes();
            $types = $this->analyzeMethodTypes($method);
            foreach ($nodes as $node) {
                if ($node instanceof Node &&
                    $node->getType() === Return_::class &&
                    ($type = $this->findReturnType($node->getNodes(), $types))
                ) {
                    $m->addComment('@return ' . (string) $type);
                }
            }
        }
    }

    /**
     * @param Method $method
     * @return array
     */
    private function analyzeMethodTypes(Method $method): array
    {
        $types = [];

        foreach ($method->getParameters() as $parameter) {
            if ($type = $parameter->getType()) {
                $types[$parameter->getName()] = (string) $type;
            } else if ($default = $parameter->getDefaultValue()) {
                if ($default instanceof ResultTypeInterface) {
                    $types[$parameter->getName()] = $default->getResultType();
                }
            }
        }

        $this->analyzeNodes($method->getBody()->getNodes(), $types);

        return $types;
    }

    private function analyzeNodes(array $nodes, array &$types)
    {
        foreach ($nodes as $node) {
            if (is_array($node)) {
                $this->analyzeNodes($node, $types);
            }

            if ($node instanceof AssignmentOp) {
                $n = $node->getNodes();
                $variable = $n['variable'];
                $value = $n['value'];
                if ($value instanceof ResultTypeInterface && $variable instanceof Variable) {
                    $types[$variable->getName()] = $value->getResultType();
                }
            }
        }
    }

    /**
     * @param array $nodes
     * @param array $types
     * @return mixed
     */
    private function findReturnType(array $nodes, array $types)
    {
        foreach ($nodes as $node) {
            if (is_array($node) && ($type = $this->findReturnType($node, $types))) {
                return $type;
            }

            if ($node instanceof Variable) {
                if (isset($types[$node->getName()])) {
                    return $types[$node->getName()];
                }
            } else if ($node instanceof ResultTypeInterface) {
                return $node->getResultType();
            }
        }

        return false;
    }

    /**
     * @param HasTraitsInterface $o
     * @param \JDWil\PhpGenny\Builder\Node\Class_|\JDWil\PhpGenny\Builder\Node\Trait_ $n
     * @throws \Exception
     */
    private function addTraits(HasTraitsInterface $o, $n)
    {
        foreach ($o->getTraits() as $trait) {
            $tu = $n->use($trait->getName());
            foreach ($o->getPrecedences() as $precedence) {
                $tu->use($precedence['trait'], $precedence['method'])->insteadOf(array_map(function (Trait_ $t) {
                    return $t->getName();
                }, $precedence['otherTraits']));
            }

            foreach ($o->getAlias() as $alias) {
                $tu->alias($alias['trait'], $alias['method'])->as($alias['newName'], $alias['visibility']);
            }
        }
    }

    /**
     * @param HasPropertiesInterface $o
     * @param $ret
     */
    protected function collectPropertyUseStatements(HasPropertiesInterface $o, &$ret)
    {
        foreach ($o->getProperties() as $property) {
            if (($default = $property->getDefaultValue()) &&
                $default instanceof Class_ &&
                $default->getNamespace() !== $o->getNamespace()
            ) {
                $ret[] = $default->getFqn();
            }
        }
    }

    /**
     * @param HasTraitsInterface $class
     * @param $ret
     */
    protected function collectUseTraitUseStatements(HasTraitsInterface $class, &$ret)
    {
        foreach ($class->getTraits() as $trait) {
            if ($trait->getNamespace() !== $class->getNamespace()) {
                $ret[] = $trait->getFqn();
            }
        }
    }

    /**
     * @param HasPropertiesInterface $o
     * @param \JDWil\PhpGenny\Builder\Node\Class_|\JDWil\PhpGenny\Builder\Node\Trait_ $n
     */
    protected function addProperties(HasPropertiesInterface $o, $n)
    {
        $properties = $o->getProperties();
        if (!empty($properties)) {
            foreach ($properties as $index => $property) {
                $p = $n->property($property->getName());
                if ($this->preferDefaultsSetInConstructor) {
                    if ($o instanceof Class_) {
                        if ($default = $property->getDefaultValue()) {
                            if ($default instanceof Class_) {
                                $p->setType($default);
                                $constructor = $this->getConstructor($o);
                                $constructor->getBody()->execute(
                                    Variable::named('this')->property($property->getName())->equals(NewInstance::of($default->getName()))
                                );
                            } else if ($default instanceof AbstractNode) {
                                if ($default instanceof ResultTypeInterface) {
                                    $p->setType($default->getResultType());
                                }
                                $constructor = $this->getConstructor($o);
                                $constructor->getBody()->execute(
                                    Variable::named('this')->property($property->getName())->equals($default)
                                );
                            }
                        }
                    }
                } else if (($default = $property->getDefaultValue()) && $default instanceof AbstractNode) {
                    $p->setDefault($default);
                }

                if ($p->hasComment() && $index !== (count($properties) - 1)) {
                    $n->lineBreak();
                }
            }
        }
    }

    /**
     * @param HasMethodsInterface $o
     * @param \JDWil\PhpGenny\Builder\Node\Class_|\JDWil\PhpGenny\Builder\Node\Trait_ $n
     */
    protected function addMethods(HasMethodsInterface $o, $n)
    {
        $methods = $this->sortMethods($o->getMethods());

        if (!empty($methods)) {
            foreach ($methods as $index => $method) {
                $m = $n->method($method->getName());

                $this->addMethodParameters($method, $m);
                $this->addReturnTypes($method, $m);

                $m->setNodes($method->getBody()->getNodes());

                if ($index !== (count($methods) - 1)) {
                    $n->lineBreak();
                }
            }
        }
    }
}
