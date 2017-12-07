<?php
declare(strict_types=1);

namespace JDWil\PhpGenny\Write;

use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\File;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\Type\Parameter;
use JDWil\PhpGenny\Type\Property;
use PhpParser\Builder\Namespace_;
use PhpParser\Builder\Param;
use PhpParser\BuilderFactory;
use PhpParser\Node\Stmt;
use PhpParser\PrettyPrinter\Standard;

class FileWriter
{
    /**
     * @var File
     */
    protected $file;

    /**
     * @var BuilderFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $statements;

    /**
     * @var array
     */
    protected $namespaces;

    public function __construct()
    {
        $this->namespaces = [];
    }

    public function generateCode(File $file): string
    {
        $this->file = $file;
        $this->factory = new BuilderFactory();
        $nsBuilder = $this->factory->namespace('tmp');

        $this->divideNamespaces();

        $ns = null;
        foreach ($this->namespaces as $namespace => $objects) {
            if ($namespace !== $ns) {
                $nsBuilder = $this->factory->namespace($namespace);
                $this->statements[] = $nsBuilder;
                $ns = $namespace;
            }

            foreach ($objects as $o) {
                if ($o instanceof Class_) {
                    $nsBuilder->addStmt($this->buildClass($o));
                }
            }
        }

        $nodes = [];
        foreach ($this->statements as $stmt) {
            $nodes[] = $stmt->getNode();
        }
        $prettyPrinter = new Standard();

        return $prettyPrinter->prettyPrintFile($nodes);
    }

    protected function buildClass(Class_ $class)
    {
        $builder = $this->factory->class($class->getName());
        $extends = $class->getExtends();
        $extendsString = null;

        if ($extends instanceof Class_ && $extends->getNamespace() !== $class->getNamespace()) {
            if ($extends->getName() === $class->getName()) {
                $extendsString = 'Base' . $extends->getName();
                $builder->addStmt($this->factory->use($extends->getFqn())->as($extendsString));
            } else {
                $extendsString = $extends->getName();
                $builder->addStmt($this->factory->use($extends->getFqn()));
            }
        } else if (is_string($extends)) {
            $extendsString = $extends;
        }

        $implements = $class->getImplements();
        $implementStrings = [];
        foreach ($implements as $implement) {
            if ($implement instanceof Interface_ && $implement->getNamespace() !== $class->getNamespace()) {
                $builder->addStmt($this->factory->use($implement->getFqn()));
                $implementStrings[] = $implement->getName();
            } else if (is_string($implement)) {
                $implementStrings[] = $implement;
            }
        }

        if ($extendsString) {
            $builder->extend($extendsString);
        }

        if (!empty($implementStrings)) {
            call_user_func_array([$builder, 'implement'], $implementStrings);
        }

        if ($class->isAbstract()) {
            $builder->makeAbstract();
        }

        if ($class->isFinal()) {
            $builder->makeFinal();
        }

        foreach ($class->getProperties() as $property) {
            $builder->addStmt($this->buildProperty($property));
        }

        foreach ($class->getMethods() as $method) {
            $builder->addStmt($this->buildMethod($method));
        }

        return $builder;
    }

    /**
     * @param Property $property
     * @return \PhpParser\Builder\Property
     */
    protected function buildProperty(Property $property): \PhpParser\Builder\Property
    {
        $builder = $this->factory->property($property->getName());

        switch ($property->getVisibility()) {
            case 'public':
                $builder->makePublic();
                break;
            case 'protected':
                $builder->makeProtected();
                break;
            case 'private':
                $builder->makePrivate();
                break;
        }

        if ($property->isStatic()) {
            $builder->makeStatic();
        }

        if ($default = $property->getDefaultValue()) {
            $builder->setDefault($default);
        }

        return $builder;
    }

    protected function buildMethod(Method $method): \PhpParser\Builder\Method
    {
        $builder = $this->factory->method($method->getName());

        switch ($method->getVisibility()) {
            case 'public':
                $builder->makePublic();
                break;
            case 'protected':
                $builder->makeProtected();
                break;
            case 'private':
                $builder->makePrivate();
                break;
        }

        if ($returnType = $method->getReturnType()) {
            $builder->setReturnType($returnType);
        }

        foreach ($method->getParameters() as $parameter) {
            $builder->addParam($this->buildParameter($parameter));
        }

        if ($body = $method->getBody()) {
            foreach ($body->getStatements() as $statement) {
                $builder->addStmt($statement);
            }
        }

        return $builder;
    }

    protected function buildParameter(Parameter $parameter): Param
    {
        $builder = $this->factory->param($parameter->getName());

        if ($type = $parameter->getType()) {
            $builder->setTypeHint((string) $type);
        }

        if ($default = $parameter->getDefaultValue()) {
            $builder->setDefault($default);
        }

        return $builder;
    }

    protected function divideNamespaces()
    {
        foreach ($this->file->getClasses() as $class) {
            $this->namespaces[$this->createNamespaceArray($class->getNamespace())][] = $class;
        }

        foreach ($this->file->getInterfaces() as $interface) {
            $this->namespaces[$this->createNamespaceArray($interface->getNamespace())][] = $interface;
        }

        foreach ($this->file->getTraits() as $trait) {
            $this->namespaces[$this->createNamespaceArray($trait->getNamespace())][] = $trait;
        }
    }

    protected function createNamespaceArray(string $ns): string
    {
        if (null === $ns) {
            $ns = '\\';
        }

        if (!isset($this->namespaces[$ns])) {
            $this->namespaces[$ns] = [];
        }

        return $ns;
    }
}
