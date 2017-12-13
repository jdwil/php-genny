# PHP-Genny User Documentation

### Table of Contents

1. [Builder Reference](builder-reference.md)
1. [Writer Reference](writing-code.md)

### Overview

PHP Genny comes with a fluid builder API that serves as a wrapper around 
PHP-Parser's own fluid interface. The builder works with the "Standard"
pretty printer from Php-Parser.

[unify]: # (setup, skip)
```php
<?php

use PhpParser\PrettyPrinter\Standard;

$prettyPrinter = new Standard();
```

You can generate arbitrary code strings.

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\Node\Scalar;

$b = new Builder();
$b->execute(Variable::named('foo')->equals(Scalar::string('bar')));

$prettyPrinter->prettyPrint($b->getStatements()); // returns: $foo = 'bar';

$b = new Builder();
$b->execute(Variable::named('foo')->plusEquals(Variable::named('bar')->plus(Scalar::int(1))));

$prettyPrinter->prettyPrint($b->getStatements()); // returns: $foo += $bar + 1;
```

...or easily build entire class files.

```php
<?php

use JDWil\PhpGenny\Builder\Builder;
use JDWil\PhpGenny\Builder\Node\Scalar;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\Node\Parameter;
use JDWil\PhpGenny\ValueObject\InternalType;

$b = new Builder();
$b
    ->declare('strict_types', Scalar::int(1))
    
    ->namespace('Foo\\Bar')
    
    ->use('Other\\Namespace\\ClassName')
    ->use('Some\\OtherInterface')
    
    ->class('MyClass')
        ->makeFinal()
        ->makeAbstract()
        ->extends('ClassName')
        ->implements('OtherInterface')
        ->implements('Fully\\Qualified\\SomeInterface')
        
        ->constant('MY_CONSTANT', Scalar::int(0))->done()
        
        ->property('FOO')
            ->makePrivate()
            ->makeStatic()
            ->setDefault(Scalar::int(10))
        ->done()
        ->property('bar')->done()
        
        ->method('myMethod')
            ->return(Variable::named('this')->property('bar')->plus(Scalar::int(1)))
        ->done()
        ->method('staticMethod')
            ->makeStatic()
            ->makeFinal()
            ->makeProtected()
            ->add(Parameter::named('param1')->setType(InternalType::string())->setDefault(Scalar::string('default')))
            ->execute(Variable::named('ret')->equals(Variable::named('param1')->concat(Scalar::string('-suffix'))))
            ->return(Variable::named('ret'))
        ->done()
        ->method('abstractMethod')
            ->makeAbstract()
        ->done()
    ->done()
;

/**
 * returns:
 * 
 * <?php
 * 
 * declare (strict_types=1);
 * namespace Foo\Bar;
 * 
 * use Other\Namespace\ClassName;
 * use Some\OtherInterface;
 * 
 * abstract final class MyClass extends ClassName implements OtherInterface, Fully\Qualified\SomeInterface
 * {
 *     const MY_CONSTANT = 0;
 * 
 *     private static $FOO = 10;
 * 
 *     public $bar;
 * 
 *     public function myMethod()
 *     {
 *         return $this->bar + 1;
 *     }
 * 
 *     protected static final function staticMethod(string $param1 = 'default')
 *     {
 *         $ret = $param1 . '-suffix';
 *         return $ret;
 *     }
 * 
 *     public abstract function abstractMethod();
 * }
 */
$prettyPrinter->prettyPrintFile($b->getStatements());
```

Additionally, you can use the built-in types to construct more complex graphs of interdependent structures and php-genny
will build them for you.

```php
<?php

use JDWil\PhpGenny\Type\Class_;
use JDWil\PhpGenny\Type\Interface_;
use JDWil\PhpGenny\Type\Method;
use JDWil\PhpGenny\ValueObject\Visibility;
use JDWil\PhpGenny\Type\Parameter;
use JDWil\PhpGenny\ValueObject\InternalType;
use JDWil\PhpGenny\Builder\Node\Variable;
use JDWil\PhpGenny\Builder\BuilderFactory;

$method = new Method(
    'doSomethingAwesome', 
    Visibility::isPublic(), 
    $final = false, 
    $abstract = false,
    [
        new Parameter('myInput', InternalType::string(), 'defaultValue')
    ]
);

$method
    ->getBody()
    ->echo('I am awesome')
    ->newLine()
    ->return(Variable::named('myInput'))
;

$interface = new Interface_('IsAwesomeInterface');
$interface->setNamespace('Path\\To\\Interfaces');
$interface->addMethod($method);

$class = new Class_('MyClass');
$class->setNamespace('Path\\To\\Classes');
$class->implements($interface);

$factory = new BuilderFactory();
$factory
    ->useStrictTypes()
    ->preferDefaultsSetInConstructor()
;

$builder = $factory->constructInterfaceBuilder($interface);

/**
 * returns:
 * 
 * <?php
 * 
 * declare (strict_types=1);
 * 
 * namespace Path\To\Interfaces;
 * 
 * interface IsAwesomeInterface
 * {
 *     public function doSomethingAwesome(string $myInput = 'defaultValue');
 * }
 */
$prettyPrinter->prettyPrintFile($builder->getStatements());

$builder = $factory->constructClassBuilder($class);

/**
 * returns:
 * 
 * <?php
 * 
 * declare (strict_types=1);
 * 
 * namespace Path\To\Classes;
 * 
 * use Path\To\Interfaces\IsAwesomeInterface;
 * 
 * class MyClass implements IsAwesomeInterface
 * {
 *     public function doSomethingAwesome(string $myInput = 'defaultValue')
 *     {
 *         echo 'I am awesome';
 * 
 *         return $myInput;
 *     }
 * }
 */
$prettyPrinter->prettyPrintFile($builder->getStatements());
```

php-genny can attempt to auto-fill your doc blocks as well. By calling `$factory->autoGenerateDocBlocks()` the above
code will generate the following source:

IsAwesomeInterface:

[unify]: # (skip)
```php
<?php

declare (strict_types=1);

namespace Path\To\Interfaces;

/**
 * Interface IsAwesomeInterface
 */
interface IsAwesomeInterface
{
    /**
     * @param string $myInput
     * @return string
     */
    public function doSomethingAwesome(string $myInput = 'defaultValue');
}
```

MyClass:

[unify]: # (skip)
```php
<?php

declare (strict_types=1);

namespace Path\To\Classes;

use Path\To\Interfaces\IsAwesomeInterface;


/**
 * Class MyClass
 */
class MyClass implements IsAwesomeInterface
{
    /**
     * @param string $myInput
     * @return string
     */
    public function doSomethingAwesome(string $myInput = 'defaultValue')
    {
        echo 'I am awesome';
        
        return $myInput;
    }
}
```
